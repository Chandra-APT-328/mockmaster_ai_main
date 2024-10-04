<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->model('Authentication_model');
		$this->load->model('student_model');
		$this->load->library('encryption');
		$this->load->helper('security');

		$studentId = $this->session->userdata('studentId');
		$studentId = $this->encryption->decrypt($studentId);
		$this->studentId = $studentId;

		if(!$this->session->userdata('pte_type')){
			$this->session->set_userdata('pte_type', PTEACADEMIC);
		}
	}

	private function is_logged_in() {
		if (!$this->session->userdata('studentId')) {
			redirect(base_url().'user/signin');
		}
		if($this->session->userdata('profile_completed')){
			return true;
		}else{
			if(debug_backtrace()[1]['function'] == "profile"){
				return true;
			}else{
				redirect(base_url().'user/profile');
			};
		}
	}

	private function is_practice_available($category, $question_id) {
		if(is_practice_available($category, $question_id)){
			return true;
		}

		redirect(base_url('user/package'));

	}

	public function index(){
		if ($this->session->userdata('studentId')){
			if($this->session->userdata('profile_completed')){
				redirect(base_url().'user/home');
			}else{
				redirect(base_url().'user/profile');
			}
		}
		redirect(base_url().'user/signup');
	}

	public function switch(){
		// created by AKSHITA . R . BHATT
		//sets the value of pte type in session 
		if($this->input->post('ptetype')){
			$pte_type = $this->input->post('ptetype');
			$this->session->set_userdata('pte_type', $pte_type);
			$this->session->set_userdata("switch_notify",true);
		}
		redirect(base_url() . 'user/home');
	}

	public function signin()
	{
		if ($this->session->userdata('studentId')) {
			redirect(base_url() . 'user/home');
		}
		$this->form_validation->set_rules('email', 'Email','required');
		$this->form_validation->set_rules('password', 'Password','required');
		
		if ($this->form_validation->run() == true){
			$email    = $this->input->post('email');
			$password = $this->input->post('password', false);
			$remember = $this->input->post('remember');
			$data = $this->Authentication_model->login($email, $password, $remember);
			if($data){
				if($this->session->userdata('profile_completed')){
					redirect(base_url().'user/home');
				}else{
					redirect(base_url().'user/profile');
				}
			}else{
				$this->load->view('student/signin',$this->data);
			}
		}else{
			$this->load->view('student/signin');
		}
	}

	public function home(){
		$this->is_logged_in();

        $today = strtotime('today');
		$one_week_before = strtotime('-6 days', $today);
		$listening_attempts = [];
		$speaking_attempts = [];
		$reading_attempts = [];
		$writing_attempts = [];
		$week_days = [];
		$week_dates = [];
		for ($i = 0; $i < 7; $i++) {
			$date = date('Y-m-d', strtotime('+' . $i . ' day', $one_week_before));
			$dayOfWeek = date('w', strtotime($date));
			$weekdays = array(
				0 => 'Sunday',
				1 => 'Monday',
				2 => 'Tuesday',
				3 => 'Wednesday',
				4 => 'Thursday',
				5 => 'Friday',
				6 => 'Saturday',
			);

			$listening_attempts[$date] = 0;
			$speaking_attempts[$date] = 0;
			$reading_attempts[$date] = 0;
			$writing_attempts[$date] = 0;
			$week_days[] = $weekdays[$dayOfWeek];
			$week_dates[$date] = $date;
		}
		$fields = "count(question_id) as attempts, CAST(create_date AS DATE) as date";
		$whereUserClause = " CAST(create_date AS DATE) BETWEEN DATE_SUB(CURDATE(), INTERVAL 7 DAY) AND CURDATE() AND user_id = " . $this->studentId . " GROUP BY CAST(create_date AS DATE)";
		$listening_stats = $this->Iifl_info->selectdata($fields,'listening_answers',$whereUserClause);
		$reading_stats = $this->Iifl_info->selectdata($fields,'reading_answers',$whereUserClause);
		$writing_stats = $this->Iifl_info->selectdata($fields,'writing_answers',$whereUserClause);
		$speaking_stats = $this->Iifl_info->selectdata($fields,'speaking_answers',$whereUserClause);

		foreach($listening_stats as $key => $row){
			$listening_attempts[$row->date] += $row->attempts;
			$listening_attempts[$row->date] += $row->attempts;
		}
		foreach($reading_stats as $key => $row){
			$reading_attempts[$row->date] += $row->attempts;
			$reading_attempts[$row->date] += $row->attempts;
		}
		foreach($writing_stats as $key => $row){
			$writing_attempts[$row->date] += $row->attempts;
			$writing_attempts[$row->date] += $row->attempts;
		}
		foreach($speaking_stats as $key => $row){
			$speaking_attempts[$row->date] += $row->attempts;
		}

		$this->data['last_week_practice_attempts'] = array(
			"listening" => $listening_attempts,
			"reading" 	=> $reading_attempts, 
			"writing" 	=> $writing_attempts,
			"speaking" 	=> $speaking_attempts
		);
		
		$usertarget = $this->Iifl_info->getdata('exam_target', array('user_id' => $this->studentId));
		$this->data['questions_progress'] = get_student_questions_progress($this->studentId);
		$this->data['week_dates'] = $week_dates;
		$this->data['week_days'] = $week_days;
		$this->data['target'] = $usertarget;
		$this->data['subview'] = "student/home";
		$this->data['active_bar'] = "home";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function signup(){
		if ($this->session->userdata('studentId')){
			redirect(base_url().'user/home');
		}

		$this->form_validation->set_rules('firstname', 'Firstname','required');
		$this->form_validation->set_rules('lastname', 'Lastname','required');
		$this->form_validation->set_rules('email', 'Email','required');
		$this->form_validation->set_rules('password', 'Password','required');
		$this->form_validation->set_rules('countrycode', 'Country','required');
		$this->form_validation->set_rules('phone', 'Phone','required');

		if ($this->form_validation->run() == true){
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$phone = $_POST['phone'];
			$countrycode = $_POST['countrycode'];
			$email = $_POST['email'];
			$password = md5($_POST['password']);
			$authKey = $_POST['password'];

			$whereclause = array('email'=>$email);
			$wherephoneclause = array('phone'=>$phone);
			$result = $this->Iifl_info->getdata('studentuser',$whereclause);
			$phoneresult = $this->Iifl_info->getdata('studentuser',$wherephoneclause);
			if(count($result) > 0 || count($phoneresult) > 0){
				if(count($result) > 0) $this->session->set_userdata('error','Email already exists');
				if(count($phoneresult) > 0) $this->session->set_userdata('error','Phone number already registered');
				$this->load->view('student/signup',$this->data);
			}else{
				$registerdata = array(
					'first_name' => $firstname, 
					'last_name' => $lastname, 
					'email' => $email, 
					'phone' => $phone, 
					'country_code' => $countrycode, 
					'auth_password' => $password, 
					'last_login' => date('Y-m-d h:i:s'),
					'create_date' => date('Y-m-d h:i:s')
				);
				$registerdata = $this->security->xss_clean($registerdata);
				if($this->security->xss_clean($registerdata)){
					$studentId = $this->Iifl_info->insert('studentuser',$registerdata);

					$mail_data = array(
						'student_name' => ucwords(trim(strtolower($firstname . ' ' .$lastname))), 
						'base_url' => base_url('user'), 
						'email_signature' => MAIL_SIGNATURE
					);
					
					register_and_save_coupon_applykart($studentId,$authKey);
					send_welcome_mail($email, $mail_data);

					// var_dump($studentId);exit;
					$_validity = assignFreeFullMockTestToNewStudent($studentId);

					$studentTests = get_test_and_video_by_studentid($studentId, true, true);
					$studentTestIds = join(",",$studentTests['testIds']);
					$validity = new DateTime($_validity);
					
					$first_name =$this->encryption->encrypt($firstname);
					$last_name =$this->encryption->encrypt($lastname);
					$studentId =$this->encryption->encrypt($studentId);
      				$email =$this->encryption->encrypt($email);

					$data = array(
						'name' => $firstname.' '.$lastname,
						'studentId' => $studentId,
						'email' =>$email,
						'registersuccess' =>1,
						'studentTestIds'=>$studentTestIds,
						'show_videos'=>$studentTests['show_videos'],
						'addon_languages'=>$studentTests['addon_languages'],
						'show_materials'=>$studentTests['show_materials'],
						'show_class_links'=>$studentTests['show_class_links'],
						'validity'=> $validity->format("d M Y"),
						'actual_validity'=> $_validity,
						'profile_completed'=> 0,
					);
							
					$this->session->set_userdata($data); 
					redirect(base_url().'user/home');
				}else{
					$this->session->set_userdata('error','Failed to signup!');
					$this->load->view('student/signup',$this->data);
				}
			}
			// var_dump($this->db->last_query());
		}else{
			$this->load->view('student/signup');
		}
	}

	public function resetpassword(){
		$this->form_validation->set_rules('email', 'Email','required');
		if ($this->form_validation->run() == true){
			$email = $_POST['email'];
			$whereclause = array('email'=>$email);
			$result = $this->Iifl_info->getdata('studentuser',$whereclause);
			if(count($result) > 0){
				$new_password = $this->generateRandomPassword(8); 
				$updatedata = array('auth_password' => md5(trim($new_password)));
				$this->Iifl_info->update('studentuser',$updatedata,array('email' => $email));
	
				$mail_data = array(
					'new_passcode' => $new_password, 
					'email_signature' => MAIL_SIGNATURE
				);
				send_forgot_password_mail($email, $mail_data);
	
				$this->session->set_userdata('error','New Password sent to your email.');
			}else{
				$this->session->set_userdata('error','Please enter a registered email.');
			}
		}

		$this->load->view('student/resetpassword');
	}

	//reading questions

	public function r_mcm($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'r_mcm' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('reading_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/r_mcm/'.$id);
		}
		
		$this->is_practice_available("reading", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'r_mcm');
		$getQuestionData = $this->Iifl_info->getdata('reading_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer);
			$originalAnswerCount = 0;
			foreach ($originalAnswer as $value) {
				if ($value == "1") {
					$originalAnswerCount++;
				}
			}
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'r_mcm';
			$this->data['maxScore'] = $originalAnswerCount;
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'r_mcm');
		$getUserAttempts = $this->Iifl_info->getdata('reading_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "reading_questions","r_mcm");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['options']) > 0){

			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');

			$score = 0;

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
				
				if ($originalAnswer[$key] == 0 && $userScoreResponse[$key] == 1) {
					--$score;
				}
			}

			if($score < 0){
				$score = 0;
			}
			
			if($score < $originalAnswerCount){
				$suggestion = "Choose 1 answer if unsure. Otherwise, wrong choice will result in mark loss.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'r_mcm', 
				'answer' => json_encode($userAnswer), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('reading_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/r_mcm/'.$questionId);
		}
		$this->data['subview'] = "student/practice/reading/multipleChoiceMultiple";
		$this->data['active_bar'] = "r_mcm";
		$this->load->view('layout/userlayout',$this->data);
	}
	

	public function r_mcs($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'r_mcs' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('reading_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/r_mcs/'.$id);
		}
		
		$this->is_practice_available("reading", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'r_mcs');
		$getQuestionData = $this->Iifl_info->getdata('reading_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'r_mcs';
			$this->data['maxScore'] = '1';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'r_mcs');
		$getUserAttempts = $this->Iifl_info->getdata('reading_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "reading_questions","r_mcs");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['optionSelected']) > 0){

			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');
			
			$score = 0;
			$originalAnswer = json_decode($getQuestionData[0]->answer);

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
			}

			if($score < 1){
				$suggestion = "Incorrect choice. Try again.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'r_mcs', 
				'answer' => $userAnswer, 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);
			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('reading_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/r_mcs/'.$questionId);
		}
		$this->data['subview'] = "student/practice/reading/multipleChoiceSingle";
		$this->data['active_bar'] = "r_mcs";
		$this->load->view('layout/userlayout',$this->data);
	}


	public function fib_wr($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'fib_wr' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('reading_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/fib_wr/'.$id);
		}
		
		$this->is_practice_available("reading", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'fib_wr');
		$getQuestionData = $this->Iifl_info->getdata('reading_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer);
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'fib_wr';
			$this->data['maxScore'] = count($originalAnswer);
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'fib_wr');
		$getUserAttempts = $this->Iifl_info->getdata('reading_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "reading_questions","fib_wr");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		if (isset($_POST['selectOptions']) && count($_POST['selectOptions']) > 0){

			$userAnswer = $this->input->post('selectOptions');
			$userAnswer = array_map("trim",$userAnswer);
			$userAnswerArr = array();  

			$score = 0;

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == $userAnswer[$key]) {
					$score++;
				}
				if(strlen($userAnswer[$key]) <= 0){
					$userAnswerArr[] = '___BLANK SKIPPED___';
				}else{
					$userAnswerArr[] = $userAnswer[$key];
				}
			}

			if($score < count($originalAnswer)){
				$suggestion = "Target 79: max 1 mistake. Target 65: max 2 mistakes. Target 50: max 2 mistakes.";
			}else{
				$suggestion = "Excellent";
			}
			
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'fib_wr', 
				'answer' => json_encode($userAnswerArr), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('reading_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			$this->session->set_userdata('previous_response',$userAnswer);

			redirect(base_url().'user/fib_wr/'.$questionId);
		}
		$this->data['subview'] = "student/practice/reading/wr_FillinTheBlanks";
		$this->data['active_bar'] = "fib_wr";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function fib_rd($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'fib_rd' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('reading_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/fib_rd/'.$id);
		}
		
		$this->is_practice_available("reading", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'fib_rd');
		$getQuestionData = $this->Iifl_info->getdata('reading_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer);
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'fib_rd';
			$this->data['maxScore'] = count($originalAnswer);
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'fib_rd');
		$getUserAttempts = $this->Iifl_info->getdata('reading_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "reading_questions","fib_rd");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		if ($this->form_validation->run() == true){

			$userAnswer = json_decode($this->input->post('answer'));
			$userAnswer = array_map("trim",$userAnswer);
			$userAnswerArr = array();  

			$score = 0;

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == $userAnswer[$key]) {
					$score++;
				}
				if(strlen($userAnswer[$key]) <= 0){
					$userAnswerArr[] = '___BLANK SKIPPED___';
				}else{
					$userAnswerArr[] = $userAnswer[$key];
				}
			}

			if($score < count($originalAnswer)){
				$suggestion = "Target 79: max 1 mistake. Target 65: max 2 mistakes. Target 50: max 2 mistakes.";
			}else{
				$suggestion = "Excellent";
			}
			
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'fib_rd', 
				'answer' => json_encode($userAnswerArr), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('reading_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			$this->session->set_userdata('previous_response',$userAnswer);
			redirect(base_url().'user/fib_rd/'.$questionId);
		}
		$this->data['subview'] = "student/practice/reading/rd_FillinTheBlanks";
		$this->data['active_bar'] = "fib_rd";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function ro($questionId = ""){
		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'ro' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('reading_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/ro/'.$id);
		}
		
		$this->is_practice_available("reading", $questionId);
		
		$whereClause = array('id' => $questionId, 'question_type' => 'ro');
		$getQuestionData = $this->Iifl_info->getdata('reading_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer);
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'ro';
			$this->data['maxScore'] = count($originalAnswer) - 1;
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'ro');
		$getUserAttempts = $this->Iifl_info->getdata('reading_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "reading_questions","ro");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		if ($this->form_validation->run() == true){

			$userAnswer = explode(',',$this->input->post('answer'));

			$score = 0;
			$adjacent_pairs = array();

			for ($i = 0; $i < count($userAnswer) - 1; $i++) {
				if (in_array($userAnswer[$i], $originalAnswer) && $originalAnswer[array_search($userAnswer[$i], $originalAnswer) + 1] === $userAnswer[$i + 1]) {
					// $adjacent_pairs[] = array($userAnswer[$i], $userAnswer[$i + 1]);
					$score++;
				}
			}

			if($score < count($originalAnswer)){
				$suggestion = "RO is one of the most difficult question types. Getting half of the marks in RO is already good enough.";
			}else{
				$suggestion = "Excellent! RO is one of the most difficult question types.";
			}
			
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'ro', 
				'answer' => implode(', ',$userAnswer), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('reading_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/ro/'.$questionId);
		}
		$this->data['subview'] = "student/practice/reading/reorder_paragraphs";
		$this->data['active_bar'] = "ro";
		$this->load->view('layout/userlayout',$this->data);
	}

	// speaking questions
	public function read_alouds($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'read_alouds' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('speaking_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/read_alouds/'.$id);
		}
		
		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'read_alouds');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'read_alouds';
			$this->data['maxScore'] = '90';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'read_alouds');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions","read_alouds");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0){
			$userAnswer = $this->input->post('studentAnswer');
			
			$response = getSpeakingScores( base_url().$userAnswer, $getQuestionData[0]->question);
			
			if(!isset($response['result'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/read_alouds/'.$questionId);
			}
			
			$componentScore = array();
			$componentScore['pronunciation'] = $response['result']['pronunciation'];
			$componentScore['fluency'] = $response['result']['fluency'];
			$componentScore['content'] = $response['result']['overall'];

			$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'read_alouds', 
				'answer' => $userAnswer, 
				'score' => floor($score),
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('speaking_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/read_alouds/'.$questionId);
		}
		$this->data['subview'] = "student/practice/speaking/readAlouds";
		$this->data['active_bar'] = "read_alouds";
		$this->load->view('layout/userlayout',$this->data);
	}

// created by AKSHITA . R . BHATT    
// start
	public function respond_situation($questionId = "")
	{
		// user controller method for respond to a situation (pte core)
		$this->is_logged_in();

		if (isset($questionId) && strlen($questionId <= 0)) {
			$whereQuesClause = "status = 1 and question_type = 'respond_situation' order by id desc limit 1";
			$getresult = $this->Iifl_info->selectresult('speaking_questions', $whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url() . 'user/respond_situation/' . $id);
		}

		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'respond_situation');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions', $whereClause);
		if (count($getQuestionData) > 0) {
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'respond_situation';
			$this->data['maxScore'] = '90';
		}

		$whereQuestionClause = array('user_id' => $this->studentId, 'question_id' => $questionId, 'question_type' => 'respond_situation');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers', $whereQuestionClause);
		if (count($getUserAttempts) > 0) {
			$this->data['getUserAttempts'] = $getUserAttempts;
		}

		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions", "respond_situation");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;

		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0) {
			$userAnswer = $this->input->post('studentAnswer');

			$response = get_respond_situation_scores(base_url() . $userAnswer, $getQuestionData[0]->keywords);
			// echo '<pre>';var_dump($response['result']['pronunciation']);var_dump($response['result']['fluency']);var_dump($response['result']['overall']);exit;

			if (!isset($response['result'])) {
				$this->session->set_userdata('error', 'Something went wrong while calculating scores');
				redirect(base_url() . 'user/respond_situation/' . $questionId);
			}

			$componentScore = array();
			$componentScore['pronunciation'] = $response['result']['pronunciation'];
			$componentScore['fluency'] = $response['result']['fluency'];
			$componentScore['content'] = $response['result']['overall'];

			$score = ($componentScore['pronunciation'] + $componentScore['fluency'] + $componentScore['content']) / 3;
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId,
				'question_type' => 'respond_situation',
				'answer' => $userAnswer,
				'score' => floor($score),
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('speaking_answers', $data);
			$this->session->set_userdata('success', 'Answer Submitted successfully');
			redirect(base_url() . 'user/respond_situation/' . $questionId);
		}
		$this->data['subview'] = "student/practice/speaking/respondToASituation";
		$this->data['active_bar'] = "respond_situation";
		$this->load->view('layout/userlayout', $this->data);
	}

	//end

	public function repeat_sentences($questionId = "")
	{

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'repeat_sentences' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('speaking_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/repeat_sentences/'.$id);
		}
		
		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'repeat_sentences');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'repeat_sentences';
			$this->data['maxScore'] = '90';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'repeat_sentences');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions","repeat_sentences");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0){
			$userAnswer = $this->input->post('studentAnswer');
			
			$response = get_repeat_sentence_scores( base_url().$userAnswer, $getQuestionData[0]->transcript);
			// echo '<pre>';var_dump($response['result']['pronunciation']);var_dump($response['result']['fluency']);var_dump($response['result']['overall']);exit;
			
			if(!isset($response['result'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/repeat_sentences/'.$questionId);
			}
			
			$componentScore = array();
			$componentScore['pronunciation'] = $response['result']['pronunciation'];
			$componentScore['fluency'] = $response['result']['fluency'];
			$componentScore['content'] = $response['result']['overall'];

			$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'repeat_sentences', 
				'answer' => $userAnswer, 
				'score' => floor($score),
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('speaking_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/repeat_sentences/'.$questionId);
		}
		$this->data['subview'] = "student/practice/speaking/repeatSentences";
		$this->data['active_bar'] = "repeat_sentences";
		$this->load->view('layout/userlayout',$this->data);
	}
	public function describe_images($questionId = ""){
		
		
		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'describe_images' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('speaking_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/describe_images/'.$id);
		}
		
		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'describe_images');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'describe_images';
			$this->data['maxScore'] = '90';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'describe_images');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions","describe_images");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0){
			$userAnswer = $this->input->post('studentAnswer');
			
			$response = get_describe_image_scores( base_url().$userAnswer, $getQuestionData[0]->keywords);
			// echo '<pre>';var_dump($response['result']['pronunciation']);var_dump($response['result']['fluency']);var_dump($response['result']['overall']);exit;
			
			if(!isset($response['result'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/describe_images/'.$questionId);
			}
			
			$componentScore = array();
			$componentScore['pronunciation'] = $response['result']['pronunciation'];
			$componentScore['fluency'] = $response['result']['fluency'];
			$componentScore['content'] = $response['result']['overall'];

			$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'describe_images', 
				'answer' => $userAnswer, 
				'score' => floor($score),
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('speaking_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/describe_images/'.$questionId);
		}
		$this->data['subview'] = "student/practice/speaking/describeImages";
		$this->data['active_bar'] = "describe_images";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function retell_lectures($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'retell_lectures' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('speaking_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/retell_lectures/'.$id);
		}
		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'retell_lectures');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'retell_lectures';
			$this->data['maxScore'] = '90';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'retell_lectures');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions","retell_lectures");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0){
			$userAnswer = $this->input->post('studentAnswer');
			// var_dump($_POST);exit;
			$response = get_retell_lecture_scores(base_url().$userAnswer, $getQuestionData[0]->keywords);
			// echo '<pre>';var_dump($response['result']['pronunciation']);var_dump($response['result']['fluency']);var_dump($response['result']['overall']);exit;
			
			if(!isset($response['result'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/retell_lectures/'.$questionId);
			}
			
			$componentScore = array();
			$componentScore['pronunciation'] = $response['result']['pronunciation'];
			$componentScore['fluency'] = $response['result']['fluency'];
			$componentScore['content'] = $response['result']['overall'];

			$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'retell_lectures', 
				'answer' => $userAnswer, 
				'score' => floor($score),
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('speaking_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/retell_lectures/'.$questionId);
		}
		$this->data['subview'] = "student/practice/speaking/retellLectures";
		$this->data['active_bar'] = "retell_lectures";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function answer_questions($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'answer_questions' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('speaking_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/answer_questions/'.$id);
		}
		
		$this->is_practice_available("speaking", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'answer_questions');
		$getQuestionData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'answer_questions';
			$this->data['maxScore'] = '1';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'answer_questions');
		$getUserAttempts = $this->Iifl_info->getdata('speaking_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "speaking_questions","answer_questions");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['studentAnswer']) && strlen($_POST['studentAnswer']) > 0){
			$userAnswer = $this->input->post('studentAnswer');
			// var_dump($_POST);exit;
			$response = getSpeakingScores( base_url().$userAnswer, $getQuestionData[0]->answer, "strict");
			// echo '<pre>';var_dump($response);exit;
			
			if(!isset($response['result'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/answer_questions/'.$questionId);
			}
			
			$componentScore = array();
			$componentScore['content'] = $response['result']['content-asq'];

			$score = $componentScore['content'];

			if($score < 1){
				$suggestion = "Inaccurate pronunciation could also result in loss of marks.";
			}else{
				$suggestion = "Correct";
			}

			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'answer_questions', 
				'answer' => $userAnswer, 
				'score' => floor($score),
				'suggestion' => $suggestion,
				'component_score' => json_encode($componentScore),
				'answer_transcript' => $response['result']['mistakes'] ? $response['result']['mistakes'] : "",
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('speaking_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/answer_questions/'.$questionId);
		}
		$this->data['subview'] = "student/practice/speaking/answerQuestions";
		$this->data['active_bar'] = "answer_questions";
		$this->load->view('layout/userlayout',$this->data);
	}



	// listening questions 
	public function ssts($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'ssts' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/ssts/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'ssts');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'ssts';
			$this->data['maxScore'] = '10';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'ssts');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","ssts");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		$this->form_validation->set_rules('answer', 'Answer','required');
		
		if ($this->form_validation->run() == true ){
			$userAnswer = $this->input->post('answer');

			$apiResponse = getsstsscores($userAnswer, $getQuestionData[0]->keywords);

			if(!isset($apiResponse['scores'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/ssts/'.$questionId);
			}

			$score = array_sum($apiResponse['scores']);
			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId, 
				'question_type' => 'ssts', 
				'answer' => $userAnswer, 
				'score' => $score,
				'component_score' => json_encode($apiResponse['scores']),
				'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
				'create_date' => date('Y-m-d h:i:s')
			);

			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			$this->session->set_userdata('redo','1');
			redirect(base_url().'user/ssts/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/summarizeSpokenText";
		$this->data['active_bar'] = "ssts";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function l_mcm($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'l_mcm' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/l_mcm/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'l_mcm');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'l_mcm';
			$this->data['maxScore'] = '2';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'l_mcm');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","l_mcm");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['options']) > 0){

			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');

			$score = 0;
			$count_of_correct_answers = 0;
			$originalAnswer = json_decode($getQuestionData[0]->answer);

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
				
				if ($originalAnswer[$key] == 0 && $userScoreResponse[$key] == 1) {
					--$score;
				}

				if ($originalAnswer[$key] == 1) {
					$count_of_correct_answers++;
				}
			}

			if($score < 0){
				$score = 0;
			}
			
			if($score > 2){
				$score = 2;
			}

			if($count_of_correct_answers == 1 && $score == 1){
				$score = 2;
			}
			
			if($score < 2){
				$suggestion = "Choose 1 answer if unsure. Otherwise, wrong choice will result in mark loss.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'l_mcm', 
				'answer' => json_encode($userAnswer), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/l_mcm/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/multipleChoiceMultiple";
		$this->data['active_bar'] = "l_mcm";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function l_mcs($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'l_mcs' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/l_mcs/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'l_mcs');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'l_mcs';
			$this->data['maxScore'] = '1';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'l_mcs');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","l_mcs");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['optionSelected']) > 0){

			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');
			
			$score = 0;
			$originalAnswer = json_decode($getQuestionData[0]->answer);

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
			}

			if($score < 1){
				$suggestion = "Incorrect choice. Try again.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'l_mcs', 
				'answer' => $userAnswer, 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);
			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/l_mcs/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/multipleChoiceSingle";
		$this->data['active_bar'] = "l_mcs";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function l_hcs($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'l_hcs' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/l_hcs/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'l_hcs');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'l_hcs';
			$this->data['maxScore'] = '1';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'l_hcs');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","l_hcs");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['optionSelected']) > 0){
			
			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');
			
			$score = 0;
			$originalAnswer = json_decode($getQuestionData[0]->answer);

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
			}

			if($score < 1){
				$suggestion = "Incorrect choice. Try again.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'l_hcs', 
				'answer' => $userAnswer, 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);
			
			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/l_hcs/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/highlightCorrectSummary";
		$this->data['active_bar'] = "l_hcs";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function l_smw($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'l_smw' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/l_smw/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'l_smw');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'l_smw';
			$this->data['maxScore'] = '1';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'l_smw');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","l_smw");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		if (isset($_POST['options']) && count($_POST['optionSelected']) > 0){
			
			$userAnswer = $this->input->post('options');
			$userScoreResponse = $this->input->post('optionSelected');
			
			$score = 0;
			$originalAnswer = json_decode($getQuestionData[0]->answer);

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == 1 && $userScoreResponse[$key] == 1) {
					$score++;
				}
			}

			if($score < 1){
				$suggestion = "Incorrect choice. Try again.";
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'l_smw', 
				'answer' => $userAnswer, 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/l_smw/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/selectMissingWord";
		$this->data['active_bar'] = "l_smw";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function wfds($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'wfds' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/wfds/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'wfds');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswerArr = explode(' ',strtolower(trim(preg_replace('/\p{P}/', '',$getQuestionData[0]->transcript))));

			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'wfds';
			$this->data['maxScore'] = count($originalAnswerArr);
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'wfds');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","wfds");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		if ($this->form_validation->run() == true ){

			$userAnswer = preg_replace('/\p{P}/', '',strtolower($this->input->post('answer')));
			$userAnswerArr = explode(' ',$userAnswer);

			$missedWordsArr = array_diff_repeating($originalAnswerArr,$userAnswerArr);
			$score = count($originalAnswerArr) - count($missedWordsArr);

			if($score < count($originalAnswerArr)){
				$suggestion = count($missedWordsArr).' words missed: '.implode(', ',$missedWordsArr);
			}else{
				$suggestion = "Excellent";
			}

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'wfds', 
				'answer' => ucfirst($userAnswer), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/wfds/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/writeFromDictation";
		$this->data['active_bar'] = "wfds";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function l_fib($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'l_fib' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/l_fib/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'l_fib');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer);
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'l_fib';
			$this->data['maxScore'] = count($originalAnswer);
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'l_fib');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","l_fib");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		if (isset($_POST['blanks']) && count($_POST['blanks']) > 0){

			$userAnswer = $this->input->post('blanks');
			$userAnswer = array_map("trim",$userAnswer);
			$userAnswerArr = array();  

			$score = 0;

			foreach ($originalAnswer as $key => $value) {
				if ($originalAnswer[$key] == $userAnswer[$key]) {
					$score++;
				}
				if(strlen($userAnswer[$key]) <= 0){
					$userAnswerArr[] = '_';
				}else{
					$userAnswerArr[] = $userAnswer[$key];
				}
			}

			if($score < count($originalAnswer)){
				$suggestion = "Target 79: max 1 mistake. Target 65: max 2 mistakes. Target 50: max 3 mistakes.";
			}else{
				$suggestion = "Excellent";
			}
			
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'l_fib', 
				'answer' => json_encode($userAnswerArr), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);

			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			$this->session->set_userdata('previous_response',$userAnswer);
			redirect(base_url().'user/l_fib/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/fillinTheBlanks";
		$this->data['active_bar'] = "l_fib";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function hiws($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'hiws' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('listening_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/hiws/'.$id);
		}
		
		$this->is_practice_available("listening", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'hiws');
		$getQuestionData = $this->Iifl_info->getdata('listening_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$originalAnswer = json_decode($getQuestionData[0]->answer,true);
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'hiws';
			$this->data['maxScore'] = count($originalAnswer);
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'hiws');
		$getUserAttempts = $this->Iifl_info->getdata('listening_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "listening_questions","hiws");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		// $this->form_validation->set_rules('answer', 'Answer','required');
		if (isset($_POST['selections'])){
			// echo '<pre>';var_dump($_POST);exit;
			$userAnswerArr = json_decode($this->input->post('selections'));
			$userAnswerArr = array_map(function($string) { return preg_replace('/\p{P}/', '', $string); }, $userAnswerArr);

			$score = 0;
			$missedWordsArr = array_diff(array_keys($originalAnswer),$userAnswerArr);
			$incorrectWordsArr = array_diff($userAnswerArr,array_keys($originalAnswer));
			$score = count($originalAnswer) - count($missedWordsArr);

			$score = $score - count($incorrectWordsArr);

			if($score < 0){
				$score = 0;
			}
			
			if($score < count($originalAnswer)){
				$suggestion = "HIW is one of the easiest scoring questions in PTE. Try to aim for full marks.";
			}else{
				$suggestion = "Excellent";
			}
			
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'hiws', 
				'answer' => json_encode($userAnswerArr), 
				'score' => $score, 
				'suggestion' => $suggestion,
				'create_date' => date('Y-m-d h:i:s')
			);
			// echo '<pre>';var_dump($data);exit;
			$data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('listening_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			$this->session->set_userdata('previous_response',json_encode($this->input->post('formHTML'),true));
			redirect(base_url().'user/hiws/'.$questionId);
		}
		$this->data['subview'] = "student/practice/listening/highlightIncorrectWords";
		$this->data['active_bar'] = "hiws";
		$this->load->view('layout/userlayout',$this->data);
	}
	


	// writing questions
	public function swtx($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'swtx' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('writing_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/swtx/'.$id);
		}
		
		$this->is_practice_available("writing", $questionId);

		$whereClause = array('id'=>$questionId, 'question_type' => 'swtx');
		$getQuestionData = $this->Iifl_info->getdata('writing_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'swtx';
			$this->data['maxScore'] = '7';
		}
		
		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'swtx');
		$getUserAttempts = $this->Iifl_info->getdata('writing_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}

		$getNeighbourIds = $this->getNeighbourIds($questionId, "writing_questions", "swtx");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		
		if ($this->form_validation->run() == true ){
			$userAnswer = $this->input->post('answer');
			$sample_input = $getQuestionData[0]->question;
			$apiResponse = getswtxscores($userAnswer, $getQuestionData[0]->keywords, $sample_input);

			if(!isset($apiResponse['scores'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/swtx/'.$questionId);
			}

			$score = array_sum($apiResponse['scores']);
			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'swtx', 
				'answer' => $userAnswer, 
				'score' => $score,
				'component_score' => json_encode($apiResponse['scores']),
				'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
				'create_date' => date('Y-m-d h:i:s')
			);
			// var_dump($data);exit;
			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('writing_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/swtx/'.$questionId);
		}
		$this->data['subview'] = "student/practice/writing/summarizeWrittenText";
		$this->data['active_bar'] = "swtx";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function essays($questionId = ""){

		$this->is_logged_in();
		
		if(isset($questionId) && strlen($questionId <= 0)){
			$whereQuesClause = "status = 1 and question_type = 'essays' order by id desc limit 1";
			$getresult =  $this->Iifl_info->selectresult('writing_questions',$whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url().'user/essays/'.$id);
		}

		$this->is_practice_available("writing", $questionId);

		$whereClause = array('id'=>$questionId, 'question_type' => 'essays');
		$getQuestionData = $this->Iifl_info->getdata('writing_questions',$whereClause);
		if(count($getQuestionData) > 0){
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'essays';
			$this->data['maxScore'] = '15';
		}

		$whereQuestionClause = array('user_id'=>$this->studentId, 'question_id' => $questionId, 'question_type' => 'essays');
		$getUserAttempts = $this->Iifl_info->getdata('writing_answers',$whereQuestionClause);
		if(count($getUserAttempts) > 0){
			$this->data['getUserAttempts'] = $getUserAttempts;
		}
		
		$getNeighbourIds = $this->getNeighbourIds($questionId, "writing_questions", "essays");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;
		
		$this->form_validation->set_rules('answer', 'Answer','required');
		
		if ($this->form_validation->run() == true ){
			
			$userAnswer = $this->input->post('answer');

			$paragraphs = explode("\r\n", $userAnswer);
			$paragraphs = array_filter($paragraphs,'trim');
			$userAnswer = implode($paragraphs," \n");
			$apiResponse = getessayscores($userAnswer, $getQuestionData[0]->keywords);

			if(!isset($apiResponse['scores'])){
				$this->session->set_userdata('error','Something went wrong while calculating scores');
				redirect(base_url().'user/essays/'.$questionId);
			}

			$score = array_sum($apiResponse['scores']);

			$data = array(
				'user_id' => $this->studentId ,
				'question_id' => $questionId, 
				'question_type' => 'essays', 
				'answer' => $userAnswer,
				'score' => $score,
				'component_score' => json_encode($apiResponse['scores']),
				'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
				'create_date' => date('Y-m-d h:i:s')
			);
			// $data = $this->security->xss_clean($data);
			
			$this->Iifl_info->insert('writing_answers',$data);
			$this->session->set_userdata('success','Answer Submitted successfully');
			redirect(base_url().'user/essays/'.$questionId);
		}
		$this->data['subview'] = "student/practice/writing/writingEssay";
		$this->data['active_bar'] = "essays";
		$this->load->view('layout/userlayout',$this->data);
	}
// created by AKSHITA . R . BHATT    
// start
	public function email($questionId = "")
	{
    // user controller method for email (pte core)
		$this->is_logged_in();

		if (isset($questionId) && strlen($questionId <= 0)) {
			$whereQuesClause = "status = 1 and question_type = 'email' order by id desc limit 1";
			$getresult = $this->Iifl_info->selectresult('writing_questions', $whereQuesClause);
			$id = $getresult[0]->id;
			redirect(base_url() . 'user/email/' . $id);
		}

		$this->is_practice_available("writing", $questionId);

		$whereClause = array('id' => $questionId, 'question_type' => 'email');
		$getQuestionData = $this->Iifl_info->getdata('writing_questions', $whereClause);
		if (count($getQuestionData) > 0) {
			$this->data['getQuestionData'] = $getQuestionData;
			$this->data['testType'] = 'email';
			$this->data['maxScore'] = '15';
		}

		$whereQuestionClause = array('user_id' => $this->studentId, 'question_id' => $questionId, 'question_type' => 'email');
		$getUserAttempts = $this->Iifl_info->getdata('writing_answers', $whereQuestionClause);
		if (count($getUserAttempts) > 0) {
			$this->data['getUserAttempts'] = $getUserAttempts;
		}

		$getNeighbourIds = $this->getNeighbourIds($questionId, "writing_questions", "email");
		$this->data['prev_id'] = $getNeighbourIds->prev_id;
		$this->data['next_id'] = $getNeighbourIds->next_id;

		$this->form_validation->set_rules('answer', 'Answer', 'required');

		if ($this->form_validation->run() == true) {

			$userAnswer = $this->input->post('answer');

			// $paragraphs = explode("\r\n", $userAnswer);
			// $paragraphs = array_filter($paragraphs, 'trim');
			// $userAnswer = implode($paragraphs, "\n");

			$additional_data = json_decode($getQuestionData[0]->additional_json);
			$apiResponse = getemailscores($userAnswer, $getQuestionData[0]->keywords, $additional_data->reason);

			if (!isset($apiResponse['scores'])) {
				$this->session->set_userdata('error', 'Something went wrong while calculating scores');
				redirect(base_url() . 'user/email/' . $questionId);
			}

			$score = array_sum($apiResponse['scores']);

			$data = array(
				'user_id' => $this->studentId,
				'question_id' => $questionId,
				'question_type' => 'email',
				'answer' => $userAnswer,
				'score' => $score,
				'component_score' => json_encode($apiResponse['scores']),
				'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
				'create_date' => date('Y-m-d h:i:s')
			);
			// $data = $this->security->xss_clean($data);

			$this->Iifl_info->insert('writing_answers', $data);
			$this->session->set_userdata('success', 'Answer Submitted successfully');
			redirect(base_url() . 'user/email/' . $questionId);
		}
		$this->data['subview'] = "student/practice/writing/writingEmail";
		$this->data['active_bar'] = "email";
		$this->load->view('layout/userlayout', $this->data);
	}

	// end

	public function studycenter()
	{
		$this->is_logged_in();
		$usertarget = $this->Iifl_info->getdata('exam_target', array('user_id' => $this->studentId));
		$categories = $this->Iifl_info->getdata('question_categories');

		$fields = "*,CAST(create_date AS DATE) as date";
		$whereUserClause = "user_id = " . $this->studentId . " && CAST(create_date AS DATE) = CAST(Date(Now()) as DATE) GROUP BY question_id,CAST(Date(Now()) as DATE)";
		$today_listening = $this->Iifl_info->selectdata($fields,'listening_answers',$whereUserClause);
		$today_reading = $this->Iifl_info->selectdata($fields,'reading_answers',$whereUserClause);
		$today_writing = $this->Iifl_info->selectdata($fields,'writing_answers',$whereUserClause);
		$today_speaking = $this->Iifl_info->selectdata($fields,'speaking_answers',$whereUserClause);

		$today_practiced = array();

		foreach($today_listening as $key => $row){
			$today_practiced[$row->question_type][] = $row;
		}
		foreach($today_reading as $key => $row){
			$today_practiced[$row->question_type][] = $row;
		}
		foreach($today_writing as $key => $row){
			$today_practiced[$row->question_type][] = $row;
		}
		foreach($today_speaking as $key => $row){
			$today_practiced[$row->question_type][] = $row;
		}
		
		foreach($categories as $key => $category){
			$cate_arr[$category->question_code] = $category->type_name;
		}

		$this->data['target'] = $usertarget;
		$this->data['today_practiced'] = $today_practiced;
		$this->data['categories'] = $cate_arr;
		// echo '<pre>';print_r($this->data);exit;
		$this->data['subview'] = "student/studycenter";
		$this->data['active_bar'] = "studycenter";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function practicehistory($date = "", $qcode = ""){
		$this->is_logged_in();
		ini_set('memory_limit', '-1');
		
		$whereClause = '';
		$fields = "id,question_id,question_type,CAST(create_date AS DATE) as date";
		if(strlen($date) > 0){
			$search_date = date('Y-m-d',strtotime($date));
			$whereClause .= " user_id = " . $this->studentId . " and CAST(create_date AS DATE) = '$search_date'";
		}
		if(strlen($qcode) > 0){
			$search_question_code = $qcode;
			$whereClause .= " and question_type = '" . $qcode . "'";
		}
		if(!strlen($date) > 0){
			$last_six_months = strtotime('-6 months', strtotime(date('Y-m-d')));
            $fromDate = date('Y-m-d',$last_six_months);
			$toDate = date('Y-m-d');

			$whereClause =" user_id = " . $this->studentId . " and TIMESTAMPDIFF(DAY , STR_TO_DATE(CAST(create_date AS DATE), '%Y-%m-%d' ) , '$toDate') >=0 and TIMESTAMPDIFF(DAY ,'$fromDate',STR_TO_DATE(CAST(create_date AS DATE),'%Y-%m-%d' )) >=0";
		}
		if(!strlen($qcode) > 0){
			$whereClause .= " GROUP BY question_id,date ORDER BY date desc";
		}

		$listening_records = $this->Iifl_info->selectdata($fields,'listening_answers',$whereClause);
		// var_dump($this->db->last_query());exit;
		$reading_records = $this->Iifl_info->selectdata($fields,'reading_answers',$whereClause);
		$writing_records = $this->Iifl_info->selectdata($fields,'writing_answers',$whereClause);
		$speaking_records = $this->Iifl_info->selectdata($fields,'speaking_answers',$whereClause);
		$categories = $this->Iifl_info->getdata('question_categories');
		
		$records = array();

		foreach($listening_records as $key => $row){
			$row->category = 'listening';
			$records[$row->date][$row->question_type][] = $row;
		}
		foreach($reading_records as $key => $row){
			$row->category = 'reading';
			$records[$row->date][$row->question_type][] = $row;
		}
		foreach($writing_records as $key => $row){
			$row->category = 'writing';
			$records[$row->date][$row->question_type][] = $row;
		}
		foreach($speaking_records as $key => $row){
			$row->category = 'speaking';
			$records[$row->date][$row->question_type][] = $row;
		}

		foreach($categories as $key => $category){
			$cate_arr[$category->question_code] = $category->type_name;
		}

		// echo '<pre>';print_r($records);exit;
		$this->data['records'] = $records;
		$this->data['categories'] = $cate_arr;
		$this->data['search_qcode'] = $qcode;
		$this->data['search_date'] = $date;
		$this->data['subview'] = "student/practicehistory";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function setexamtarget(){
		parse_str($_POST['form'], $form_data);

		$usertarget = $this->Iifl_info->getdata('exam_target', array('user_id' => $this->studentId));
		$status = 0;

		$insertdata = array(
			'user_id' => $this->studentId,
			'exam_date' => $form_data['exam-date'],
			'target' => $form_data['target'],
			'overall' => $form_data['overall-target'],
			'listening' => $form_data['listening-target'],
			'reading' => $form_data['reading-target'],
			'writing' => $form_data['writing-target'],
			'speaking' => $form_data['speaking-target'],
			'update_date' => date('Y-m-d h:i:s')
		);
		if(count($usertarget) > 0){
			$this->Iifl_info->update('exam_target', $insertdata, array('user_id' => $this->studentId));
			$status = 1;
		}else{
			$insertdata['create_date'] = date('Y-m-d h:i:s');
			$this->Iifl_info->insert('exam_target', $insertdata);
			$status = 1;
		}

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
     	$data['status'] = $status;
    	echo json_encode($data);
    	exit;
	}
	
	public function speakingQuestions(){

		$this->is_logged_in();

		$fields = 'count(question_id) as attempts, question_id';
		$whereUserClause = 'user_id = '.$this->studentId.' GROUP BY question_id';
		$getAttempts = $this->Iifl_info->selectdata($fields,'speaking_answers',$whereUserClause);

		$getQuestions = $this->Iifl_info->getdata('speaking_questions');

		if(count($getQuestions) > 0){
			foreach ($getQuestions as $question => $rowQuestion) {
				$attemptCounter = '';
				foreach ($getAttempts as $attempts => $rowAttempts) {
					if($rowQuestion->id == $rowAttempts->question_id){
						$attemptCounter = $rowAttempts->attempts;
					}
				}
				$rowQuestion->attempts = $attemptCounter;
			}
		}

		// echo '<pre>';var_dump($getQuestions);exit;
		$this->data['getQuestions'] = $getQuestions;
		
		$getCatData = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();

		foreach($getCatData as $categories => $rowCategories){
			$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
		}

		$this->data['getCatData'] = $categoriesArr;

		$this->data['subview'] = "student/practice/questions";
		$this->data['show_bar'] = "speakingQuestions";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function listeningQuestions(){

		$this->is_logged_in();

		$fields = 'count(question_id) as attempts, question_id';
		$whereUserClause = 'user_id = '.$this->studentId.' GROUP BY question_id';
		$getAttempts = $this->Iifl_info->selectdata($fields,'listening_answers',$whereUserClause);
		
		$getQuestions = $this->Iifl_info->getdata('listening_questions');

		if(count($getQuestions) > 0){
			foreach ($getQuestions as $question => $rowQuestion) {
				$attemptCounter = '';
				foreach ($getAttempts as $attempts => $rowAttempts) {
					if($rowQuestion->id == $rowAttempts->question_id){
						$attemptCounter = $rowAttempts->attempts;
					}
				}
				$rowQuestion->attempts = $attemptCounter;
			}
		}

		// echo '<pre>';var_dump($getQuestions);exit;
		$this->data['getQuestions'] = $getQuestions;
		
		$getCatData = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();

		foreach($getCatData as $categories => $rowCategories){
			$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
		}

		$this->data['getCatData'] = $categoriesArr;

		$this->data['subview'] = "student/practice/questions";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function writingQuestions(){

		$this->is_logged_in();

		$fields = 'count(question_id) as attempts, question_id';
		$whereUserClause = 'user_id = '.$this->studentId.' GROUP BY question_id';
		$getAttempts = $this->Iifl_info->selectdata($fields,'writing_answers',$whereUserClause);

		$getQuestions = $this->Iifl_info->getdata('writing_questions');

		if(count($getQuestions) > 0){
			foreach ($getQuestions as $question => $rowQuestion) {
				$attemptCounter = '';
				foreach ($getAttempts as $attempts => $rowAttempts) {
					if($rowQuestion->id == $rowAttempts->question_id){
						$attemptCounter = $rowAttempts->attempts;
					}
				}
				$rowQuestion->attempts = $attemptCounter;
			}
		}

		// echo '<pre>';var_dump($getQuestions);exit;
		$this->data['getQuestions'] = $getQuestions;
		
		$getCatData = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();

		foreach($getCatData as $categories => $rowCategories){
			$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
		}

		$this->data['getCatData'] = $categoriesArr;

		$this->data['subview'] = "student/practice/questions";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function readingQuestions(){

		$this->is_logged_in();

		$fields = 'count(question_id) as attempts, question_id';
		$whereUserClause = 'user_id = '.$this->studentId.' GROUP BY question_id';
		$getAttempts = $this->Iifl_info->selectdata($fields,'reading_answers',$whereUserClause);

		$getQuestions = $this->Iifl_info->getdata('reading_questions');

		if(count($getQuestions) > 0){
			foreach ($getQuestions as $question => $rowQuestion) {
				$attemptCounter = '';
				foreach ($getAttempts as $attempts => $rowAttempts) {
					if($rowQuestion->id == $rowAttempts->question_id){
						$attemptCounter = $rowAttempts->attempts;
					}
				}
				$rowQuestion->attempts = $attemptCounter;
			}
		}

		// echo '<pre>';var_dump($getQuestions);exit;
		$this->data['getQuestions'] = $getQuestions;
		
		$getCatData = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();

		foreach($getCatData as $categories => $rowCategories){
			$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
		}

		$this->data['getCatData'] = $categoriesArr;

		$this->data['subview'] = "student/practice/questions";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function get_high_score_board_list(){
		$post = $this->input->post();

		$maxScore = trim($post['maxScore']);
		$getQuestionData = $post['getQuestionData'];
		$limit = trim($post['limit']);
		$offset = trim($post['offset']);

        $category = $getQuestionData['question_type'];
        $questionid = $getQuestionData['id'];
		$table_search = getCategoryDataByCode($category);
		
		$whereQuestionClause = array(
			'question_id' => $questionid, 
			'question_type' => $category);
		$table_name = $table_search['category'].'_answers';
		$groupBY = ['user_id'];
		$getUsers = $this->Iifl_info->getdata($table_name,$whereQuestionClause,[],'score','desc',"",[],$limit,$offset,$groupBY);
		$all_user_data = '';
		$i = 0;
        foreach ($getUsers as $key => $rowdata) {                      
			$user_name = $this->Iifl_info->selectdata('first_name,last_name','studentuser','studentId='.$rowdata->user_id.'');
            $all_user_data .= '<div class="chr pb-4 pt-4" id="answer-box-'.$rowdata->id.'">
				<div style="display:flex;">
					<h6>
					'.$user_name[0]->first_name.' '.$user_name[0]->last_name.'
					</h6>
					<p style="font-size:12px; padding-left: 10px;">
						'.$rowdata->create_date.'
					</p>
				</div>
				<div class="py-4" id="test_type">
					<p style="padding-left: 10px;">';
			switch ($category) {
				case 'l_mcm':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'l_fib':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'hiws':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'read_alouds':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;
				case 'repeat_sentences':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;
				case 'describe_images':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;
				case 'respond_situation':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;	
				case 'retell_lectures':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;
				case 'answer_questions':
					$all_user_data .= '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
					break;
				case 'r_mcm':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'fib_wr':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'fib_rd':
					$answer = json_decode($rowdata->answer);
					$all_user_data .= implode(', ', $answer);
					break;
				case 'essays':
					$all_user_data .= nl2br($rowdata->answer);
					break;
				case 'email':
					$all_user_data .= nl2br($rowdata->answer);
					break;
				case 'wfds':
					$actual_answer = explode(' ', strtolower(trim(preg_replace('/\p{P}/', '', $getQuestionData['transcript']))));
					$userAnswer = preg_replace('/\p{P}/', '', strtolower(strip_tags($rowdata->answer)));
					$userAnswerArr = explode(' ', $userAnswer);
					$all_user_data .= get_wfd_mistakes($actual_answer, $userAnswerArr);
					break;
				default:
					$all_user_data .= $rowdata->answer;
			}

			$all_user_data .= '</p>
				</div>
				<button class="btn btn-xs btn-outline-secondary" onclick="checkResults('.$i . ',' . $rowdata->id .')">Score Info '.$rowdata->score . '/' . $maxScore.'</button>
			</div>';
			$i++;
		}
							
		// $token = $this->security->get_csrf_hash();
		$output = array(
			"data" => $all_user_data,
			// "token" => $token,
		);
		echo json_encode($output);
    	exit;
	}
	public function studyvideos(){
		$this->is_logged_in();
		if(!$this->session->userdata('show_videos')){
			redirect(base_url().'user/home');
		}
		$result = [];
		$videos = $this->Iifl_info->getdata("materials",array("status"=>1,"type"=>"video"));
		if($videos && count($videos) > 0){
			foreach ($videos as $key => $video) {
				$result[$video->language][$video->category][] = $video;
			}
		}
		$this->data['subview'] = "student/studyvideos";
		$this->data['videos'] = $result;
		$this->data['addon_languages'] = $this->session->userdata('addon_languages');
		$this->data['active_bar'] = "studyvideos";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function studyvideosfree(){
		$this->is_logged_in();
		
		$result = [];
		$videos = $this->Iifl_info->getdata("materials",array("status"=>1,"type"=>"video"));
		if($videos && count($videos) > 0){
			foreach ($videos as $key => $video) {
				$result[$video->language][$video->category][] = $video;
			}
		}
		$this->data['subview'] = "student/studyvideosfree";
		$this->data['videos'] = $result;
		$this->data['addon_languages'] = $this->session->userdata('addon_languages');
		$this->data['active_bar'] = "studyvideosfree";
		$this->load->view('layout/userlayout',$this->data);
	}
	
	public function studymaterials(){
		$this->is_logged_in();

		if(!$this->session->userdata('show_materials')){
			redirect(base_url().'user/home');
		}

		$this->data['subview'] = "student/studymaterials";
		$this->data['active_bar'] = "studymaterials";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function getmaterialslist(){
        
		$category = $_GET['type'];
        $order = array('id' => 'desc'); 
        $column_search = array('label_name','type','path','category');
		$column_order = array();
		$whereClause = array("status" => 1, 'type' => $category,"pte_type" => $this->session->userdata('pte_type'));
		$materials = $this->Iifl_info->getRows($_GET, 'materials', $column_search, $column_order, $order, '', '', $whereClause);

        $data = $row = array();

        $i = 0;
        
        foreach($materials as $rowData){
            $i++;
            $row = array();
			$created_on = new DateTime($rowData->create_date);
			$create_date = $created_on->format("M d, Y g:i A");
			if($category == "document"){
				$file = get_material_file_link_by_ext($rowData->path);
				$row[] = '<div class="row align-items-center p-10 font-14"><div class="col-2 col-md-1"><span style="font-size: medium;font-weight: 500;">'.$i.'</span></div><div class="col-4 col-md-1">'.$file.'</div><div class="col-6 col-md-10"><span style="font-size: medium;font-weight: 500;">'.$rowData->label_name.'</span><br><small>Added on: '.$create_date.'</small></div></div>';
			}elseif($category == "link"){
				$row[] = '<div class="row align-items-center p-10 font-14"><div class="col-2 col-md-1"><span style="font-size: medium;font-weight: 500;">'.$i.'</span></div><div class="col-2 col-md-1"><a class="btn-transparent btn-sm text-primary" style="font-size:28px;" href="'.$rowData->path.'" target="_blank"><i class="fa fa-link"></i></a></div><div class="col-8 col-md-10"><span style="font-size: medium;font-weight: 500;">'.$rowData->label_name.'</span><br><small>Added on: '.$create_date.'</small></div></div>';
			}elseif($category == "class_link"){
				$row[] = '<div class="row align-items-center p-10 font-14"><div class="col-2 col-md-1"><span style="font-size: medium;font-weight: 500;">'.$i.'</span></div><div class="col-10 col-md-11"><span style="font-size: medium;font-weight: 500;">'.$rowData->label_name.'</span><br><small>Added on: '.$create_date.'</small><br><br>'.json_decode($rowData->path).'</div></div>';
			}
		    $data[] = $row;
		}

        $question_count = $this->Iifl_info->countAll('materials',$whereClause);

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'materials',$column_search,$column_order,$order,"","",$whereClause),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function search(){
		$this->is_logged_in();

		if($this->session->userdata('pte_type')==PTEACADEMIC){
			$where_clause = array("pte_type" => $this->session->userdata('pte_type'));
			$whereNotIn = [];
		}else{
			$where_clause = [];
			$whereNotInField = 'question_code';
			$whereNotIn = ['essays','retell_lectures'];
		}
		
		
		$question_types = $this->Iifl_info->getdata('question_categories', $where_clause, [], 'question_category', 'ASC',null,[],null,null,[],$whereNotInField,$whereNotIn);


		$this->data['subview'] = "student/search";
		$this->data['types'] = $question_types;
		$this->data['active_bar'] = "search";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function searchlist(){
		$result = perform_search($this->input->get());
		$dt_data = array();

		$i = 0;
		foreach($result['data'] as $key => $rowData){
            $i++;
            $row = array();

			$row[] = getSearchRowString($rowData);

			$dt_data[] = $row;		
        }

		$token = $this->security->get_csrf_hash();
		
		$output = array(
			"token" => $token,
			"draw" => $this->input->get('draw'),
			"recordsTotal" => $result['count'],
			"recordsFiltered" => $result['total_count'],
			"data" => $dt_data,
		);

    	echo json_encode($output);
    	exit;
	}

	public function listquestions(){
		$_GET['order'] = "new";
		$result = perform_search($this->input->get());
		$dt_data = array();

		$i = 0;
		foreach($result['data'] as $key => $rowData){
            $i++;
            $row = array();

			$category_code = $this->input->get('type');
			$category_data = getCategoryDataByCode($category_code);
			
			if(!is_practice_available($category_data['category'], $rowData['id'])){
				$applykartLogo = base_url("assets/images/apply-logo.svg");
				$row[] = '<a href="javascript:void(0);"><div class="row p-10 font-14" onClick="redeemcoupon();"><div class="col-12 col-md-12"><span style="font-size: medium;font-weight: 500;">#'.$rowData['id'].' '.$rowData['title'].'</span><span class="float-right bold">Unlock with <img style="width:25%" src="'.$applykartLogo.'"/></span></div></div></a>';
			}else{
				$row[] = '<a href="'.base_url('user/'.$rowData['question_type'].'/'.$rowData['id']).'"><div class="row p-10 font-14"><div class="col-12 col-md-12"><span style="font-size: medium;font-weight: 500;">#'.$rowData['id'].' '.$rowData['title'].'</span></div></div></a>';
			}

			$dt_data[] = $row;		
        }

		$token = $this->security->get_csrf_hash();
		
		$output = array(
			"token" => $token,
			"draw" => $this->input->get('draw'),
			"recordsTotal" => $result['count'],
			"recordsFiltered" => $result['total_count'],
			"data" => $dt_data,
		);

    	echo json_encode($output);
    	exit;
	}

	public function logout(){
		$this->Authentication_model->logout();
		redirect(base_url().'user/signin');
	}

	public function getNeighbourIds($id, $table, $quesType){
       /**
        * SELECT
        *     (SELECT MAX(`id`) FROM `topics` WHERE `id` < `tmp`.`id`) AS `prev_id`,
        *     (SELECT MIN(`id`) FROM `topics` WHERE `id` > `tmp`.`id`) AS `next_id`
        * FROM
        *     `topics` AS `tmp`
        * WHERE
        *     `id` = 10;
        */

		$idClause = $id." AND question_type = ".$quesType;
        $tableName = $table;
        $columnName = "id";
        $asColumnNamePrev = "prev_" . $columnName;
        $asColumnNameNext = "next_" . $columnName;

        $queryMin = "(SELECT MAX(" . $columnName . ") FROM " . $tableName . " WHERE " . $columnName . " < " . "tmp." . $columnName . " AND question_type = '" . $quesType . "') AS " . $asColumnNameNext;
        $queryMax = "(SELECT MIN(" . $columnName . ") FROM " . $tableName . " WHERE " . $columnName . " > " . "tmp." . $columnName . " AND question_type = '" . $quesType . "') AS " . $asColumnNamePrev;

        $query = $this->db
                      ->select($queryMin)
                      ->select($queryMax)
                      ->where($columnName, $idClause)
                      ->get($tableName . " AS tmp")
                      ->row();
        return $query;
    }

	public function deleteanswer(){
		$testid = $this->input->post('id');
		$model = $this->input->post('model');

		$speaking_test_types = array('read_alouds', 'repeat_sentences', 'respond_situation', 'describe_images', 'retell_lectures', 'answer_questions');
		$writing_test_types = array('swtx', 'essays', 'email');
		$reading_test_types = array('fib_wr', 'r_mcm', 'r_mcs', 'fib_rd', 'ro');
		$listening_test_types = array('ssts', 'wfds', 'l_mcm', 'l_mcs', 'l_hcs', 'l_smw', 'l_fib', 'hiws');

		if (in_array($model, $speaking_test_types)) {
			$category = 'speaking_answers';
		}
		if(in_array($model,$writing_test_types)){
			$category = 'writing_answers';
		}
		if(in_array($model,$reading_test_types)){
			$category = 'reading_answers';
		}
		if(in_array($model,$listening_test_types)){
			$category = 'listening_answers';
		}

		$whereClause = array('id' => $testid, 'user_id' => $this->studentId, 'question_type' => $model);
		$this->Iifl_info->delete($category,$whereClause);
		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
    	echo json_encode($data);
    	exit;
	}

	public function uploadSpeech(){
		$this->load->library('ffmpeg');

		if (!empty($_FILES['audio-blob'])) {
			$file_idx = 'audio-blob';
			$fileName = $_POST['audio-filename'];
			$tempName = $_FILES['audio-blob']['tmp_name'];
		} 
		$file_Path = 'uploads/Speaking/'.$_POST['testType'].'/students/'.$this->studentId.'/';
		$filePath = 'uploads/Speaking/'.$_POST['testType'].'/students/'.$this->studentId.'/'.$fileName;
		
		// make sure that one can upload only allowed audio/video files
		$allowed = array(
			'webm',
			'wav',
			'mp4',
			'mkv',
			'mp3',
			'ogg'
		);
		$extension = pathinfo($filePath, PATHINFO_EXTENSION);
		if (!$extension || empty($extension) || !in_array($extension, $allowed)) {
			echo 'Invalid file extension: '.$extension;
			return;
		}
		
		if (!is_dir($file_Path)) {
			mkdir($file_Path, 0755, TRUE);
		  }

		exec("ffmpeg -i ".$tempName." -ar 16000 -b:a 256000 ".$filePath."");

		$log_data = array(
			"path" => $filePath,
			"original_file_name" => $fileName,
			'create_date' => date('Y-m-d h:i:s')
		);

		$this->Iifl_info->insert('resource_uploads',$log_data);

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
     	$data['path'] = $filePath;
    	echo json_encode($data);
    	exit;
	}


	public function curl_file_get_contents($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT_MS,30000);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 30000);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
		$resp = curl_exec($ch);
		if($resp === false)
		{
		  echo 'download audio error: ' . curl_error($ch) . "\n";
		}
		curl_close($ch);
		return $resp;
	}

	public function getuseranswer(){
		$response = get_answer_details_by_id($this->input->post());

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['result'] = $response;
		echo json_encode($data);
		exit;
	}
	
	public function getscorebyanswer(){
		$response = get_answer_score_by_id($this->input->post());

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['result'] = $response;
		echo json_encode($data);
		exit;
	}
	
	public function profile(){
		$this->is_logged_in();

		$whereUserClause = array('studentId' => $this->studentId);
		$getUser = $this->Iifl_info->getdata('studentuser',$whereUserClause);

		$this->data['getUser'] = $getUser;
		$this->data['subview'] = "student/profile";
		$this->load->view('layout/userlayout',$this->data);	
	}

	public function saveprofile(){
		$this->form_validation->set_rules('email','email','required');
		if ($this->form_validation->run() == true ){
			$updatedata = array();
			if(isset($_POST['avatar']) && strlen($_POST['avatar']) > 0){
				$profile_picture = $_POST['avatar'];
				$updatedata = array('profile_picture' => $profile_picture); 
				$this->session->set_userdata('profile_picture',$_POST['avatar']);
			}else{
				$first_name = $_POST['first_name'];
				$last_name = $_POST['last_name'];
				$email = $_POST['email'];
				$phone = $_POST['phone'];
				$citizenship_country = $_POST['citizenship_country'];
				$residence_country = $_POST['residence_country'];
				$residence_state = $_POST['residence_state'];
				$mother_tongue = $_POST['mother_tongue'];
				$branch = $_POST['branch'];
				$desired_band = $_POST['desired_band'];
				

				$file_location = "";
				if(strlen($_FILES['image']['name']) > 0){
					$fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
					$fileName = uniqid().'.'.$fileExt;
					$labelname ='image';  
					$image = 'uploads/profile_images/';
					$file_location = $this->do_upload_file($image,$labelname,$fileName);
					$updatedata = array('profile_picture' => $file_location[0]); 
					$whereUserClause = array('studentId'=> $this->studentId);
					$this->Iifl_info->update('studentuser', $updatedata, $whereUserClause);
					$this->session->set_userdata('profile_picture',$file_location[0]);
				}

				$updatedata = array(
					'first_name' => $first_name, 
					'last_name' => $last_name, 
					'email' => $email,
					'phone' => $phone,
					'citizenship_country' => $citizenship_country,
					'residence_country' => $residence_country,
					'residence_state' => $residence_state,
					'mother_tongue' => $mother_tongue,
					'branch' => $branch,
					'desired_band' => $desired_band,
					'profile_completed' => 1,
					'last_updated' => date('Y-m-d h:i:s'),
				);

				$this->session->set_userdata(['profile_completed' => 1]);
			}

			$whereUserClause = array('studentId'=> $this->studentId);
			$this->Iifl_info->update('studentuser',$updatedata,$whereUserClause);

			$token = $this->security->get_csrf_hash();
			$data['token'] = $token;
			$data['data'] = 1;
			echo json_encode($data);
			exit;
		}

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

   public function setRedirect(){
	// var_dump($_POST);exit;
	$this->session->set_userdata(array('redirect_to' => $_POST['redirect']));
	$token = $this->security->get_csrf_hash();
	$data['token'] = $token;
	echo json_encode($data);
	exit;
  }

  public function oauthgoogle(){
	$this->load->library('google_Api');
	//check if the code is set then fetch the required data from youtube api
	  if (isset($_GET['code'])) {
  
		$redirectPath = "user/profile";
  
		$client = new Google_Client();
		$client->setAuthConfig(APPPATH.'third_party/google_oauthData.json');
  
		// Exchange authorization code for an access token.
		$accessToken = $client->fetchAccessTokenWithAuthCode($_GET['code']);
		$client->setAccessToken($accessToken);
		
		//user details via service object
		$oauth = new Google_Service_Oauth2($client);
		$userProfile = $oauth->userinfo->get();
		$userData = array();
		
		$userData['fullname'] = $userProfile['name'];
		$userData['email'] = $userProfile['email'];
		$userData['id'] = $userProfile['id'];
		$userData['google_profile_picture'] = $userProfile['picture'];
		$userData['verifiedEmail'] = $userProfile['verifiedEmail'];
		$userData['phoneNumber'] = $userProfile['phoneNumber'] ? $userProfile['phoneNumber'] :'';
		
		//storing data to session
		$this->session->set_userdata(array('google_oauth_success' => 'Profile linked with Google.'));
		$this->session->set_userdata(array('google_oauth_response' => $userData));
		
		//updating latest count in the database
		$whereclause = array('email'=>$userProfile['email']);
		$result = $this->Iifl_info->getdata('studentuser',$whereclause);

		if(count($result) > 0){
			$data = $this->Authentication_model->google_auth_login($userProfile['email'], true);
			if($data){
				if($this->session->userdata('profile_completed')){
					redirect(base_url().'user/home');
				}else{
					redirect(base_url().'user/profile');
				}
			}else{
				redirect(base_url().'user/signin');
			}
		}else{
			$name = explode(' ',$userData['fullname']);
			$firstname = $name[0];
			$lastname = $name[1];
			$email = $userProfile['email'];
			$phone = $userData['phoneNumber'];

			$insertdata = array(
				'first_name' => $firstname, 
				'last_name' => $lastname,
				'email' => $email,
				'phone' => $phone, 
				'create_date' => date('Y-m-d h:i:s'), 
				'last_login' => date('Y-m-d h:i:s'));
				
			$studentId = $this->Iifl_info->insert('studentuser',$insertdata);

			$mail_data = array(
				'student_name' => ucwords(trim(strtolower($firstname . ' ' .$lastname))), 
				'base_url' => base_url('user'), 
				'email_signature' => MAIL_SIGNATURE
			);

			register_and_save_coupon_applykart($studentId);
			send_welcome_mail($email, $mail_data);

			$_validity = assignFreeFullMockTestToNewStudent($studentId);

			$studentTests = get_test_and_video_by_studentid($studentId, true, true);
			$studentTestIds = join(",",$studentTests['testIds']);
			$validity = new DateTime($_validity);
			
			$first_name =$this->encryption->encrypt($firstname);
			$last_name =$this->encryption->encrypt($lastname);
			$studentId =$this->encryption->encrypt($studentId);
			$email =$this->encryption->encrypt($email);

			$data = array(
				'name' => $firstname.' '.$lastname,
				'studentId' => $studentId,
				'email' =>$email,
				'registersuccess' =>1,
				'studentTestIds'=>$studentTestIds,
				'show_videos'=>$studentTests['show_videos'],
				'addon_languages'=>$studentTests['addon_languages'],
				'show_materials'=>$studentTests['show_materials'],
				'show_class_links'=>$studentTests['show_class_links'],
				'validity'=> $validity->format("d M Y"),
				'actual_validity'=> $_validity,
				'profile_completed'=> 0,
			);
	
			$this->session->set_userdata($data); 
			redirect(base_url().$redirectPath);
		}
		exit;
	}
  
	//redirect user for oauth to google page
	$client = new Google_Client();
	$client->setApplicationName('mockmaster.ai');
	$client->setScopes([
		'https://www.googleapis.com/auth/userinfo.profile',
		'https://www.googleapis.com/auth/userinfo.email',
	]);
  
	$client->setAuthConfig(APPPATH.'third_party/google_oauthData.json');
	$client->setAccessType('offline');
	$redirect_uri = base_url()."user/oauthgoogle";
	$client->setRedirectUri($redirect_uri);
  
  
	// Request authorization from the user.
	$authUrl = $client->createAuthUrl();
	// var_dump($authUrl);exit;
	header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
  }


  public function oauth_facebook(){

	$this->load->library('facebook_Api');
  
	//redirect to login user if session is not set
	if(!($this->session->userdata('fb_access_token'))){
	  header('Location: ' . filter_var($this->facebook_api->login_url(), FILTER_SANITIZE_URL));exit;
	}
	
	$data = array();
		  // Check if user is logged in
		  if ($token = $this->facebook_api->is_authenticated()){
		
		// User logged in, get user details
			  $user = $this->facebook_api->request('get', '/me?fields=id,name,email,picture{url}');
		
			//   echo '<pre>'; print_r($user);exit;
		
		  	$redirectPath = "application/views/package/listPackages.phpprofile";
		
			$whereclause = array('email'=>$user['email']);
			$result = $this->Iifl_info->getdata('studentuser',$whereclause);
			if(count($result) > 0){
				$studentId =$this->encryption->encrypt($result[0]->studentId);
				$data = array(
					'name' => $user['name'],
					'studentId' => $studentId,
					'email' =>$user['email'],
					'registersuccess' =>1,
				);
		
				$this->session->set_userdata($data); 
				redirect(base_url().'user/home');
			}else{
				$name = explode(' ', $user['name']);
				
				$insertdata = array(
					'first_name' => $name[0], 
					'last_name' => $name[1], 
					'email' => $user['email'], 
					'create_date' => date('Y-m-d h:i:s')
				);
				$studentId = $this->Iifl_info->insert('studentuser',$insertdata);

				$studentId =$this->encryption->encrypt($studentId);
				$data = array(
					'name' => $user['name'],
					'studentId' => $studentId,
					'email' =>$user['email'],
					'registersuccess' =>1,
				);
				$this->session->set_userdata($data); 
			}

		  }
  
		  // display view
		  redirect(base_url().$redirectPath);
	  exit;
  }

  	public function do_upload_file($resourcepath,$labelname,$filename=''){
	
		$config['upload_path'] = $resourcepath;
		$config['allowed_types'] = 'mp3|m4a|gif|jpg|png|jpeg|pdf|docx|doc|xlsx|mov|mp4';
		$config['overwrite'] = TRUE;
		$config['max_size'] = '700000000';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		if(strlen($filename) > 0){
			$config['file_name'] = $filename;
		}

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!is_dir($config['upload_path'])) {
		mkdir($config['upload_path'], 0755, TRUE);
		}

		$file_path = array();
		if($this->upload->do_upload($labelname)){
			$file_path[] = $resourcepath.$filename;
			return $file_path;
		} else {
			return array('error' => $this->upload->display_errors());
		}
  	}
	  public function package(){
		
		$this->is_logged_in();

		$listpackage = $this->Iifl_info->getdata('packages', array('status' => "1", 'is_purchaseable' => "1", "pte_type" => $this->session->userdata('pte_type')), null, 'cost', 'asc');
		// var_dump($this->db->last_query());
		$this->data['listpackage'] = $listpackage;
		$this->data['user_packages'] = getUserPackagesWithExpireDate($this->studentId);
    
		// var_dump($this->data['user_packages']);exit;
        $this->data['subview'] = "student/listPackages";
		$this->data['active_bar'] = "package";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function subscriptions(){
		
		$this->is_logged_in();
			
		$this->data['user_packages'] = getUserPackagesWithExpireDate($this->studentId);
		$user_packages=$this->data['user_packages'] ;
		$keys=array_keys($user_packages);
		$listpackage = $this->Iifl_info->getdata('packages', array('status' => "1", 'is_purchaseable' => "1"),null,'cost','asc','packageid', $keys);
		$this->data['listpackage'] = $listpackage;
        $this->data['subview'] = "student/listPackages";
		$this->data['active_bar'] = "subscriptions";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function generateRandomPassword($length = 8) {
		// Define the character set from which the password will be generated
		$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$&*';
		
		// Initialize the password string
		$password = '';
		
		// Get the length of the character set
		$charsetLength = strlen($charset);
		
		// Generate random characters to create the password
		for ($i = 0; $i < $length; $i++) {
			$randomIndex = random_int(0, $charsetLength - 1);
			$password .= $charset[$randomIndex];
		}
		
		return $password;
	}

	public function verify_applykart_email(){
		$jsonData = file_get_contents('php://input');
		$request = json_decode($jsonData, true);

		$response = ["success" => false];
		if($request['email']){
			$student = $this->student_model->get("",["email" => $request['email']]);
			if(count($student) == 1){
				$response['success'] = true;
				$response['email'] = $student[0]['email'];
				$response['coupon_code'] = $student[0]['ak_coupon_code'];
				$response['is_coupon_used'] = is_coupon_used($student[0]['ak_coupon_code']);
			}elseif(count($student) == 0){
				$response['msg'] = "Email not registered";
			}
		}
		
		die(json_encode($response));
	}

	public function deletefiles(){
		$answers = $this->Iifl_info->selectdata("*",'speaking_answers'," create_date < DATE_SUB(CURDATE(), INTERVAL 45 DAY) ORDER BY id");
		foreach ($answers as $key => $answer) {
			if(file_exists($answer->answer)){
				echo "<br>";echo base_url().$answer->answer;
				unlink($answer->answer);
			}
		}
	}
}

// Furthermore, Moreover, However, In addition, Therefore, Hence, To conclude, In conclusion, In a nutshell, To sum up, Finally, Thus, To begin with, On the one hand, On the other hand
// If 3, then 2/2
// If 2, then 1/2
// If none, then 0/2