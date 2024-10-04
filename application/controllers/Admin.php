<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->library('encryption');
		$this->load->helper('security');
    }

	public function index(){
		if ($this->session->userdata('authId')){
			redirect(base_url().'admin/students');
		}
		redirect(base_url().'admin/signin');
	}

	private function is_logged_in() {
		if (!$this->session->userdata('authId')) {
			redirect(base_url().'admin/signin');
		}
		return true;
	}

	public function signin(){
		if ($this->session->userdata('authId')){
			redirect(base_url().'admin/students');
		}

		if (isset($_POST['email']) && isset($_POST['password'])){
			$email = $_POST['email'];
			$password = $_POST['password'];

			$whereclause = array('email'=>$email, 'auth_password'=>md5($password));
			$result = $this->Iifl_info->getdata('auth_users',$whereclause);
			if(count($result) == 1){
				$updatedata = array('last_login'=>date('Y-m-d h:i:s'));
				$this->Iifl_info->update('auth_users',$updatedata,$whereclause);

				$first_name =$this->encryption->encrypt($result[0]->first_name);
				$last_name =$this->encryption->encrypt($result[0]->last_name);
       			$authId =$this->encryption->encrypt($result[0]->authId);

				$data = array(
					'name' => $result[0]->first_name.' '.$result[0]->last_name,
					'authId' => $authId,
					'studentlogged' =>true,
					'lastLogin'=>$result[0]->last_login
				);
			
				// $this->session->unset_userdata('studentId');
				$this->session->set_userdata($data);
				redirect(base_url().'admin/students');
			}else{
				$this->data['error_msg'] = 'Invalid email or password.';
				$this->load->view('admin/signin',$this->data);
			}
		}else{
			$this->load->view('admin/signin');
		}
	}

	// public function lay(){

	// 	$this->is_logged_in();
	// 	// $this->data['subview'] = "admin/home";
	// 	$this->load->view('layout/adminlayout',$this->data);

	// }
	public function addstudent($studentId = ''){

		$this->is_logged_in();

		$this->form_validation->set_rules('first_name', 'First Name','required');
		$this->form_validation->set_rules('last_name', 'Last Name','required');
		$this->form_validation->set_rules('email', 'Email','required');
		$this->form_validation->set_rules('validity', 'Validity','required');

		if ($this->form_validation->run() == true ){
			$first_name 				= $this->input->post('first_name');
			$last_name 					= $this->input->post('last_name');
			$email 						= $this->input->post('email');
			$password 					= $this->input->post('password');
			$mobile 					= $this->input->post('mobile');
			$branch 					= $this->input->post('branch');
			$student_type 				= $this->input->post('student_type');
			$validity 					= $this->input->post('validity');
			$new_selected_package_ids 	= $this->input->post('package');

			if(strlen($studentId) > 0){
				$db_data = array(
					'first_name' 	=> $first_name,
					'last_name' 	=> $last_name,
					'email'	 		=> trim($email),
					'phone' 		=> $mobile,
					'branch' 		=> $branch,
					'student_type' 	=> $student_type,
					'validity' 		=> $validity,
					'last_updated' 	=> date('Y-m-d h:i:s')
				);
				$this->session->set_userdata('success','Student Updated Successfully');
				$this->Iifl_info->update('studentuser', $db_data, array('studentId' => $studentId));

				$old_student_packages =  getStudentPackagePurchasesNotExpired($studentId);
				$old_package_ids = array_keys($old_student_packages);
				$temp_packageids = array_unique(array_merge($new_selected_package_ids, $old_package_ids));

				foreach($temp_packageids as $data => $package){ 
					// if purchased package
					if($old_student_packages[$package] && $old_student_packages[$package]->paymentid > 0){
						continue;
					// if old assigned package
					}else if($old_student_packages[$package] && in_array($package, $new_selected_package_ids) && $old_student_packages[$package]->paymentid == 0){
						continue;
					// if removed assigned package
					}else if(in_array($package, $old_package_ids) && !in_array($package, $new_selected_package_ids)){
						$this->Iifl_info->delete('purchases', array('productid' => $package, 'studentid' => $studentId, 'paymentid' => 0));
					// if new assigned package
					}else{
						$package_data = $this->Iifl_info->getdata('packages', array('packageid'=>$package));

						if($package_data && count($package_data) > 0){
							$package_validity = $package_data[0]->duration . " " . $package_data[0]->duration_type . "s";
							$expire_on = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $package_validity));

							$db_data= array(
								'product' 			=> 	$package_data[0]->package_name,
								'productid' 		=> 	$package,
								'studentid'			=> 	$studentId,
								'expire_date'		=> 	$expire_on,
								'create_date' 		=> 	date('Y-m-d h:i:s')
							);
							$this->Iifl_info->insert('purchases',$db_data);

							// updating account validity if purchased package expiry is greater than account validity
							extendAccountValidityWithPackageExpiry($studentId, $expire_on);
						}
					}
				}
			}else{
				$db_data = array(
					'first_name' 		=> $first_name,
					'last_name' 		=> $last_name,
					'email' 			=> trim($email),
					'auth_password' 	=> md5(trim($password)),
					'phone' 			=> $mobile,
					'branch'	 		=> $branch,
					'student_type' 		=> $student_type,
					'validity' 			=> $validity,
					'created_by' 		=> $this->encryption->decrypt($this->session->userdata('authId')),
					'create_date' 		=> date('Y-m-d h:i:s')
				);
				$studentId = $this->Iifl_info->insert('studentuser',$db_data);
				$this->session->set_userdata('success','Student Added Successfully');

				foreach($new_selected_package_ids as $data => $package){ 
					$package_data = $this->Iifl_info->getdata('packages', array('packageid'=>$package));

					if($package_data && count($package_data) > 0){
						$package_validity = $package_data[0]->duration . " " . $package_data[0]->duration_type . "s";
						$expire_on = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $package_validity));

						$db_data= array(
							'product' 			=> 	$package_data[0]->package_name,
							'productid' 		=> 	$package,
							'studentid'			=> 	$studentId,
							'expire_date'		=> 	$expire_on,
							'create_date' 		=> 	date('Y-m-d h:i:s')
						);
						$this->Iifl_info->insert('purchases',$db_data);
						
						// updating account validity if purchased package expiry is greater than account validity
						extendAccountValidityWithPackageExpiry($studentId, $expire_on);
					}	
				}
				
				$mail_data = array(
					'student_name' 		=> ucwords(trim(strtolower($first_name . ' ' . $last_name))), 
					'username' 			=> $email,
					'passcode' 			=> trim($password),
					'base_url' 			=> base_url('user'),
					'email_signature' 	=> MAIL_SIGNATURE
				);
				send_account_creation_mail($email, $mail_data);
			}
			redirect(base_url().'admin/students');
		}

		if(strlen($studentId) > 0){
			$student =  $this->Iifl_info->getdata('studentuser', array('studentId' => $studentId));
			$this->data['student'] = $student;

			$student_packages =  getStudentPackagePurchasesNotExpired($studentId);
			$this->data['student_packages'] = $student_packages;
		}

		$packages =  $this->Iifl_info->getdata('packages', array('status' => "1"));
		$this->data['packages'] = $packages;

		$this->data['form_action'] = strlen($studentId) > 0 ? base_url('admin/addstudent/'.$studentId) : base_url('admin/addstudent');
		$this->data['active_bar'] = "addstudent";
		$this->data['subview'] = "admin/addStudent";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function students(){

		$this->is_logged_in();
		$studentList = $this->Iifl_info->getdata('studentuser');

		$this->data['studentList'] = $studentList;
		
		$this->data['active_bar'] = "students";
		$this->data['subview'] = "admin/studentList";
		$this->load->view('layout/adminlayout',$this->data);

	}

	public function getstudentlist(){
        $order = array('studentId' => 'desc'); // default order 
        $column_search = array('studentId','first_name','last_name','email','phone','student_type');
        $column_order = array(null,'first_name','email','phone','student_type',null,null);
		
        $getstudents = $this->Iifl_info->getRows($_GET,'studentuser',$column_search,$column_order,$order); 

        $data = array();

        $i = 0;
        foreach($getstudents as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = '<a href="' . base_url('admin/student/' . $rowData->studentId) . '" style="text-decoration: none;"><span class="text-primary">' . ucfirst($rowData->first_name) . " " . ucfirst($rowData->last_name) . '</span></a>';
            $row[] = $rowData->email;
            $row[] = $rowData->phone;
            $row[] = $rowData->student_type;
			$checked = '';
			if($rowData->status == 1){
				$checked = 'checked';
			}
            $row[] = '<input type="checkbox" class="status-switch" id="status-switch-'.$rowData->studentId.'" ' . $checked . ' onchange="changestatus(' . $rowData->studentId . ',this);" /><label for="status-switch-'.$rowData->studentId.'" class="toggle-label">Status</label>';
            $row[] = '<div class="btn-group dropdown table-actions">
						<a href="javascript:void(0);" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right border py-0"
							aria-labelledby="order-dropdown-0">
							<div class="py-2">
								<a class="dropdown-item" href="' . base_url('admin/addstudent/' . $rowData->studentId) . '">Edit Student</a>
								<a class="dropdown-item" href="' . base_url('admin/student/' . $rowData->studentId) . '">Profile</a>
								<a class="dropdown-item" href="javascript:void(0);" onclick="deletestudent(' . $rowData->studentId . ');">Delete</a>
							</div>
						</div>
					</div>';

			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('studentuser');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'studentuser',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
	}
	public function getpackagelist(){
        $order = array('packageid' => 'desc'); // default order 
        $column_search = array('package_name','packageid','cost');
        $column_order = array(null,'package_name','cost','duration_type', 'usage_type' ,'is_purchaseable',null,'created_on',null);
		
        $getstudents = $this->Iifl_info->getRows($_GET,'packages',$column_search,$column_order,$order); 

        $data = array();

        $i = 0;
        foreach($getstudents as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = '<a href="' . base_url('package/createPackage/'.$rowData->packageid) . '" style="text-decoration: none;"><span class="text-primary">' . $rowData->package_name . '</span></a>';
            $row[] = $rowData->cost;
            $row[] = $rowData->duration." ".$rowData->duration_type;
			$row[] = $rowData->usage." ".$rowData->usage_type;
            $row[] = $rowData->is_purchaseable == 1 ? 'Yes':'No'; 
			$checked = '';
			if($rowData->status == 1){
				$checked = 'checked';
			}
            $row[] = '<input type="checkbox" class="status-switch" id="status-switch-'.$rowData->packageid.'" ' . $checked . ' onchange="changestatus(' . $rowData->packageid . ',this);" /><label for="status-switch-'.$rowData->packageid.'" class="toggle-label text-center">Status</label>'; 
            $created_on = new DateTime($rowData->created_on);
			$row[] = $created_on->format("M d, Y g:i A");
            $row[] = '<div class="btn-group dropdown table-actions">
						<a href="javascript:void(0);" class="btn-transparent dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-ellipsis-v"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right border py-0"
							aria-labelledby="order-dropdown-0">
							<div class="py-2">
								<a class="dropdown-item" href="'.base_url().'package/createPackage/'.$rowData->packageid.'">Edit</a>
								<a class="dropdown-item" href="javascript:void(0);" onclick="deletePackage('.$rowData->packageid.');">Delete</a>
							</div>
						</div>
					</div>';

			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('packages');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'packages',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
	}

	public function getmocktestlist(){
        $order = array('id' => 'desc'); // default order 
        $column_search = array('id','title','pte_type','test_type');
        $column_order = array(null,'title','pte_type','test_type','create_date',null);
		
        $mocktestlist = $this->Iifl_info->getRows($_GET,'mock_test',$column_search,$column_order,$order); 

        $data = array();

        $i = 0;
        foreach($mocktestlist as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
			$mock_test_type = explode('-',$rowData->test_type);
            $row[] = '<a href="' . base_url('admin/createmocktest/'.$mock_test_type[0].'/'.$rowData->id) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($rowData->title) . '</span></a>';
			$row[] = ucfirst($rowData->pte_type);
            $row[] = ucfirst($mock_test_type[0]);
            $created_on = new DateTime($rowData->create_date);
			$row[] = $created_on->format("M d, Y g:i A");
            $row[] = '<a href="'.base_url('admin/createmocktest/'.$mock_test_type[0].'/'.$rowData->id).'" class="btn-transparent btn-sm text-primary"><i class="fa fa-edit"></i></a>
			<a class="btn-transparent btn-sm text-primary" javascript:void(0); onclick="deletemocktest('.$rowData->id.');"><i class="fa fa-trash"></i></a>';
			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('mock_test');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'mock_test',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
	}

	public function toggle(){

		$this->is_logged_in();
		
		$selectedId = $_POST['studentId'];
		if(strlen($selectedId) > 0){
			$whereClause = array('studentId' => $selectedId);
			$getstudent = $this->Iifl_info->getdata('studentuser',$whereClause);
			$updatedata = array( 'status ' => $getstudent[0]->status == 1 ? 0 : 1);
			$this->Iifl_info->update('studentuser',$updatedata,$whereClause);
        }
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function student($studentId = "")
	{

		$this->is_logged_in();
		$whereClause = array('studentId' => $studentId);
		$studentList = $this->Iifl_info->getdata('studentuser', $whereClause);
		if ($studentList && count($studentList) > 0) {

			$getMockTest = $this->Iifl_info->getdata('mock_test');
			$this->data['mock_test'] = $getMockTest;

			$whereClause = " (status = 2 or status = 1 or status = 3) and user_id = " . $studentId . " group by mock_test_id order by id desc";
			$getMockTestAnswers = $this->Iifl_info->selectresult('mock_test_answers', $whereClause);
			$this->data['mock_history'] = $getMockTestAnswers;

			$this->data['studentList'] = $studentList;
			$this->data['subview'] = "admin/studentProfile";
			$this->load->view('layout/adminlayout', $this->data);
		} else {
			redirect(base_url() . 'admin/students');
		}


	}

	public function home(){

		$this->is_logged_in();

		$this->data['subview'] = "admin/home";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function addspeakingquestions($questionId = ""){

		$this->is_logged_in();

		$this->data = array();

		if(isset($questionId) && strlen($questionId) > 0){
			$whereClause = array('id'=>$questionId);
			$getSpeakingData = $this->Iifl_info->getdata('speaking_questions',$whereClause);
			$this->data['getSpeakingData'] = $getSpeakingData;
		}
		
		// echo '<pre>';var_dump($this->input->post());exit;
		$whereTypeClause = array('question_category' => 'Speaking');
		$getQuestionType = $this->Iifl_info->getdata('question_categories',$whereTypeClause);
		$this->data['getQuestionType'] = $getQuestionType;

		$this->form_validation->set_rules('setTimerMin', 'Timer','required');
		$this->form_validation->set_rules('setTimerSec', 'Timer','required');
		$this->form_validation->set_rules('questionTitle', 'Title','required');
		$this->form_validation->set_rules('questionType', 'Form type','required');

		if ($this->form_validation->run() == true ){
			// var_dump(strlen($_FILES['resourcePath']['name']) > 0);exit;
			if(strlen($_FILES['resourcePath']['name']) > 0){
				$fileExt = pathinfo($_FILES['resourcePath']['name'], PATHINFO_EXTENSION);
				$fileName = $this->input->post('questionType').'-'.uniqid().'.'.$fileExt;
				$labelname ='resourcePath';  
				$resourcePath = 'uploads/Speaking/'.$this->input->post('questionType').'/admin/';
				$resource_file_location = $this->do_upload_file($resourcePath,$labelname,$fileName);
			}
			if(isset($resource_file_location['error'])){
				// var_dump($resource_file_location['error']);exit;
				$this->session->set_userdata('error',$resource_file_location['error']);
				redirect(base_url().'admin/addspeakingquestions');
			}else{
				$question_type = $this->input->post('questionType');
				$title = $this->input->post('questionTitle');
				$resourcePath = $resource_file_location[0];
				$originalFileName = $_FILES['resourcePath']['name'];
				$transcript = $this->input->post('transcript');
				$question = $this->input->post('question');
				$answer = $this->input->post('answer');				
				$exam_duration = $this->input->post('setTimerMin').":".$this->input->post('setTimerSec');

				// var_dump(count(array_filter($answer)));exit;
				if(strlen($_FILES['resourcePath']['name']) > 0){
					$data = array(
						'title' => $title, 
						'resourcePath' => $resourcePath, 
						'original_file_name' => $originalFileName,
						'transcript' => (strlen($transcript) > 0 ) ? $transcript : NULL, 
						'question' => (strlen($question) > 0 ) ? $question : NULL, 
						'answer' => (strlen($answer) > 0 ) ? $answer : NULL, 
						'keywords' => strtolower($this->input->post('keywords')),
						'exam_duration' => $exam_duration, 
						'question_type' => $question_type, 
					);
				}else{
					$data = array(
						'title' => $title,  
						'transcript' => (strlen($transcript) > 0 ) ? $transcript : NULL, 
						'question' => (strlen($question) > 0 ) ? $question : NULL, 
						'answer' => (strlen($answer) > 0 ) ? $answer : NULL, 
						'keywords' => strtolower($this->input->post('keywords')),
						'exam_duration' => $exam_duration, 
						'question_type' => $question_type, 
					);

				}
				// $data = $this->security->xss_clean($data);

				if(isset($questionId) && strlen($questionId) > 0){
					$data['update_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->update('speaking_questions',$data, $whereClause);
					$this->session->set_userdata('success','Question Updated successfully');
					redirect(base_url().'admin/addspeakingquestions');
				}else{
					$data['create_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->insert('speaking_questions',$data);
					$this->session->set_userdata('success','Question added successfully');
					redirect(base_url().'admin/addspeakingquestions');
				}
			}
		}else{
			$this->data['active_bar'] = "addspeakingquestions";
			$this->data['subview'] = "admin/speaking/addSpeakingQuestions";
			$this->load->view('layout/adminlayout',$this->data);
		}
	}
	
	public function addlisteningquestions($questionId = ""){

		$this->is_logged_in();

		$this->data = array();

		if(isset($questionId) && strlen($questionId) > 0){
			$whereClause = array('id'=>$questionId);
			$getListeningData = $this->Iifl_info->getdata('listening_questions',$whereClause);
			$this->data['getListeningData'] = $getListeningData;
		}
		
		// echo '<pre>';var_dump($this->input->post());exit;
		$whereTypeClause = array('question_category' => 'Listening');
		$getQuestionType = $this->Iifl_info->getdata('question_categories',$whereTypeClause);
		$this->data['getQuestionType'] = $getQuestionType;

		// $this->form_validation->set_rules('transcript', 'Transcript','required');
		$this->form_validation->set_rules('setTimerMin', 'Timer','required');
		$this->form_validation->set_rules('setTimerSec', 'Timer','required');
		$this->form_validation->set_rules('questionTitle', 'Title','required');
		$this->form_validation->set_rules('questionType', 'Form type','required');

		if ($this->form_validation->run() == true ){
			if(strlen($_FILES['audioPath']['name']) > 0){
				$fileExt = pathinfo($_FILES['audioPath']['name'], PATHINFO_EXTENSION);
				$fileName = $this->input->post('questionType').'-'.uniqid().'.'.$fileExt;
				$labelname ='audioPath';  
				$audiopath = 'uploads/Listening/'.$this->input->post('questionType').'/';
				$audio_file_location = $this->do_upload_file($audiopath,$labelname,$fileName);
			}
			
			if(isset($audio_file_location['error'])){
				// var_dump($audio_file_location['error']);exit;
				$this->session->set_userdata('error',$audio_file_location['error']);
				redirect(base_url().'admin/addlisteningquestions');
			}else{

				$question_type = $this->input->post('questionType');
				$title = $this->input->post('questionTitle');
				$audioPath = $audio_file_location[0];
				$originalAudioName = $_FILES['audioPath']['name'];
				$transcript = $this->input->post('transcript');
				$question = $this->input->post('question');
				$explanation = $this->input->post('explanation');

				if($question_type == 'l_mcm'){
					$options = (count($this->input->post('checkOptionQuestion')) > 0 ) ? $this->input->post('checkOptionQuestion') : NULL;
					$answer = (count($this->input->post('checkstatus')) > 0 ) ? $this->input->post('checkstatus') : NULL;
				}
				
				if($question_type == 'l_mcs' || $question_type == 'l_smw' || $question_type == 'l_hcs'){
					$options = (count($this->input->post('singleOptionQuestion')) > 0 ) ? $this->input->post('singleOptionQuestion') : NULL;
					$answer = (count($this->input->post('selectStatus')) > 0 ) ? $this->input->post('selectStatus') : NULL;
				}
				
				if($question_type == 'l_fib'){
					$question = (strlen($this->input->post('fitb')) > 0 ) ? $this->input->post('fitb') : NULL;
					preg_match_all('/{(.*?)}/', $question, $substrings);
					$answer = (strlen($this->input->post('fitb')) > 0 ) ? $substrings[1] : NULL;
				}
				
				if($question_type == 'hiws'){
					$question = $this->input->post('hiws');
					$words = (strlen($this->input->post('hiws')) > 0 ) ? $this->input->post('hiws') : NULL;
					preg_match_all('/{(.*?)}/', $words, $wrongWords);

					$words = (strlen($this->input->post('transcript')) > 0 ) ? $this->input->post('transcript') : NULL;
					preg_match_all('/{(.*?)}/', $words, $correctWords);
					
					$answer = array();
					if(count($wrongWords[1]) == count($correctWords[1])){
						foreach($wrongWords[1] as $key => $value){
							$answer[$wrongWords[1][$key]] = $correctWords[1][$key];
						}
					}else{
						$this->session->set_userdata('error','Please check the answers again!');
						redirect(base_url().'admin/addlisteningquestions');
					}
					// echo '<pre>';var_dump($answer);exit;
				}
				$exam_duration = $this->input->post('setTimerMin').":".$this->input->post('setTimerSec');

				if($answer && is_array($answer)){
					$answer = (count(array_filter($answer)) > 0 ) ? json_encode($answer) : NULL;
				}else{
					$answer = $this->input->post('answer');
				}
				// var_dump(count(array_filter($answer)));exit;
				if(strlen($_FILES['audioPath']['name']) > 0){
					$data = array(
						'title' => $title, 
						'audioPath' => $audioPath, 
						'original_file_name' => $originalAudioName, 
						'transcript' => (strlen($transcript) > 0 ) ? $transcript : NULL,
						'question' => (strlen($question) > 0 ) ? $question : NULL, 
						'options' =>  (count(array_filter($options)) > 0 ) ? json_encode($options) : NULL, 
						'answer' =>  $answer ? $answer : NULL, 
						'explanation' => (strlen($explanation) > 0 ) ? $explanation : NULL,
						'keywords' => strtolower($this->input->post('keywords')),
						'exam_duration' => $exam_duration, 
						'question_type' => $question_type, 
					);
				}else{
					$data = array(
						'title' => $title, 
						'transcript' => (strlen($transcript) > 0 ) ? $transcript : NULL,
						'question' => (strlen($question) > 0 ) ? $question : NULL, 
						'options' =>  (count(array_filter($options)) > 0 ) ? json_encode($options) : NULL, 
						'answer' =>  $answer ? $answer : NULL, 
						'explanation' => (strlen($explanation) > 0 ) ? $explanation : NULL,
						'keywords' => strtolower($this->input->post('keywords')),
						'exam_duration' => $exam_duration, 
						'question_type' => $question_type, 
					);
				}
				// $data = $this->security->xss_clean($data);

				if(isset($questionId) && strlen($questionId) > 0){
					$data['update_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->update('listening_questions',$data, $whereClause);
					$this->session->set_userdata('success','Question Updated successfully');
					redirect(base_url().'admin/addlisteningquestions');
				}else{
					$data['create_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->insert('listening_questions',$data);
					$this->session->set_userdata('success','Question added successfully');
					redirect(base_url().'admin/addlisteningquestions');
				}
			}
		}else{
			// echo '<pre>';var_dump($this->data);exit;
			$this->data['active_bar'] = "addlisteningquestions";
			$this->data['subview'] = "admin/listening/addListeningQuestions";
			$this->load->view('layout/adminlayout',$this->data);
		}
	}
	
	public function addreadingquestions($questionId = ""){

		$this->is_logged_in();

		$this->data = array();

		if(isset($questionId) && strlen($questionId) > 0){
			$whereClause = array('id'=>$questionId);
			$getReadingData = $this->Iifl_info->getdata('reading_questions',$whereClause);
			$this->data['getReadingData'] = $getReadingData;
		}
		
		// echo '<pre>';var_dump($getReadingData);exit;
		$whereTypeClause = array('question_category' => 'Reading');
		$getQuestionType = $this->Iifl_info->getdata('question_categories',$whereTypeClause);
		$this->data['getQuestionType'] = $getQuestionType;

		// $this->form_validation->set_rules('transcript', 'Transcript','required');
		$this->form_validation->set_rules('setTimerMin', 'Timer','required');
		$this->form_validation->set_rules('setTimerSec', 'Timer','required');
		$this->form_validation->set_rules('questionTitle', 'Title','required');
		$this->form_validation->set_rules('questionType', 'Form type','required');

		if ($this->form_validation->run() == true ){
			// echo '<pre>';var_dump($_POST);
				$question_type = $this->input->post('questionType');
				$title = $this->input->post('questionTitle');
				$question = $this->input->post('question');
				
				if($question_type == 'r_mcm'){
					$options = (count($this->input->post('checkOptionQuestion')) > 0 ) ? $this->input->post('checkOptionQuestion') : NULL;
					$answer = (count($this->input->post('checkstatus')) > 0 ) ? $this->input->post('checkstatus') : NULL;
				}
				
				if($question_type == 'r_mcs'){
					$options = (count($this->input->post('singleOptionQuestion')) > 0 ) ? $this->input->post('singleOptionQuestion') : NULL;
					$answer = (count($this->input->post('selectStatus')) > 0 ) ? $this->input->post('selectStatus') : NULL;
				}
				
				if($question_type == 'fib_wr'){
					$question = (strlen($this->input->post('fitb')) > 0 ) ? $this->input->post('fitb') : NULL;
					preg_match_all('/{(.*?)}/', $question, $substrings);
					$answer = (strlen($this->input->post('fitb')) > 0 ) ? $substrings[1] : NULL;

					// var_dump($answer);exit;
					$options = array();
					if(count($this->input->post('optionValues')) == count($answer)){
						foreach($this->input->post('optionValues') as $key => $value){
							$temp = array();
							if(!strlen($value) > 0){
								$this->session->set_userdata('error','Invalid value provided!');
								redirect(base_url().'admin/addreadingquestions/'.$questionId);
							}
							$temp = explode(',',$value);
							$options[] = array_map('trim', $temp);
						}
					}else{
						$this->session->set_userdata('error','Options mismatch!');
						redirect(base_url().'admin/addreadingquestions/'.$questionId);
					}
					// echo '<pre>';var_dump($options);exit;
				}
				
				if($question_type == 'fib_rd'){
					$question = (strlen($this->input->post('fitb')) > 0 ) ? $this->input->post('fitb') : NULL;
					preg_match_all('/{(.*?)}/', $question, $substrings);
					$answer = (strlen($this->input->post('fitb')) > 0 ) ? $substrings[1] : NULL;

					if(!strlen($_POST['optionValue']) > 0){
						$this->session->set_userdata('error','Invalid value provided!');
						redirect(base_url().'admin/addreadingquestions/'.$questionId);
					}
					$options = explode(',',$_POST['optionValue']);
					$options = array_map('trim', $options);
					// echo '<pre>';var_dump($answer);exit;
				}
				
				if($question_type == 'ro'){
					$options = array_map('trim', $this->input->post('paragraph'));
					$answer = array_map('trim', explode(',',$this->input->post('ro-answer')));

					if(count($options) != count($answer)){
						$this->session->set_userdata('error','Invalid value provided!');
						redirect(base_url().'admin/addreadingquestions/'.$questionId);
					}
					// $answer = implode(',',$answer);
					// echo '<pre>';var_dump($options);var_dump($answer);exit;
				}

				$exam_duration = $this->input->post('setTimerMin').":".$this->input->post('setTimerSec');

				// var_dump(count(array_filter($answer)));exit;
				$data = array(
					'title' => $title, 
					'question' => (strlen($question) > 0 ) ? $question : NULL, 
					'options' =>  (count(array_filter($options)) > 0 ) ? json_encode($options) : NULL, 
					'answer' =>  (count(array_filter($answer)) > 0 ) ? json_encode($answer) : NULL, 
					'exam_duration' => $exam_duration, 
					'question_type' => $question_type,
				);
				// echo '<pre>';var_dump($data);exit;
				// $data = $this->security->xss_clean($data);

				if(isset($questionId) && strlen($questionId) > 0){
					$data['update_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->update('reading_questions',$data, $whereClause);
					$this->session->set_userdata('success','Question Updated successfully');
					redirect(base_url().'admin/addreadingquestions');
				}else{
					$data['create_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->insert('reading_questions',$data);
					$this->session->set_userdata('success','Question added successfully');
					redirect(base_url().'admin/addreadingquestions');
				}
		}else{
			$this->data['active_bar'] = "addreadingquestions";
			$this->data['subview'] = "admin/reading/addReadingQuestions";
			$this->load->view('layout/adminlayout',$this->data);
		}
	}

	public function addwritingquestions($questionId = ""){
		
		$this->is_logged_in();

		$this->data = array();
		if(isset($questionId) && strlen($questionId) > 0){
			$whereClause = array('id'=>$questionId, 'status' => 1);
			$getWritingData = $this->Iifl_info->getdata('writing_questions',$whereClause);
			$this->data['getWritingData'] = $getWritingData;
		}
		
		// echo '<pre>';var_dump($this->input->post());exit;
		$whereTypeClause = array('question_category' => 'Writing');
		$getQuestionType = $this->Iifl_info->getdata('question_categories',$whereTypeClause);
		$this->data['getQuestionType'] = $getQuestionType;


		$this->form_validation->set_rules('question', 'Question','required');
		$this->form_validation->set_rules('setTimerMin', 'Timer','required');
		$this->form_validation->set_rules('setTimerSec', 'Timer','required');
		$this->form_validation->set_rules('questionTitle', 'Title','required');
		$this->form_validation->set_rules('questionType', 'Form type','required');
		
		if ($this->form_validation->run() == true ){

			$title = $this->input->post('questionTitle');
			$question = $this->input->post('question');
			$answer = $this->input->post('answer');
			$explanation = $this->input->post('explanation');
			$exam_duration = $this->input->post('setTimerMin').":".$this->input->post('setTimerSec');
			$question_type = $this->input->post('questionType');
			$emailreasons = $this->input->post('emailreasons');
			$additional_data = "";

			if($question_type == 'email'){
				$reasons = explode(",",$emailreasons);
				$reasons = array_map('trim', $reasons);
				$additional_data = array(
					'reasons' => $reasons
				);
			}

			// var_dump($_POST);exit;
				$data = array(
					'title' => $title, 
					'question' => $question, 
					'answer' => (strlen($answer) > 0 ) ? $answer : NULL,
					'explanation' => (strlen($explanation) > 0 ) ? $explanation : NULL,
					'keywords' => strtolower($this->input->post('keywords')),
					'additional_json' => count($additional_data) > 0 ? json_encode($additional_data) : null,
					'exam_duration' => $exam_duration, 
					'question_type' => $question_type,
				);

					// echo '<pre>';var_dump($data);exit;
				// $data = $this->security->xss_clean($data);

				if(isset($questionId) && strlen($questionId) > 0){
					$data['update_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->update('writing_questions',$data, $whereClause);
					$this->session->set_userdata('success','Question Updated successfully');
					redirect(base_url().'admin/addwritingquestions');
				}else{
					$data['create_date'] = date('Y-m-d h:i:s');
					$this->Iifl_info->insert('writing_questions',$data);
					$this->session->set_userdata('success','Question added successfully');
					redirect(base_url().'admin/addwritingquestions');
				}
		}else{
			$this->data['active_bar'] = "addwritingquestions";
			$this->data['subview'] = "admin/writing/addWritingQuestions";
			$this->load->view('layout/adminlayout',$this->data);
		}
	}

	public function speakingquestions(){

		$this->is_logged_in();

		$this->data['active_bar'] = "speakingquestions";
		$this->data['subview'] = "admin/speaking/questions";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function listeningquestions(){

		$this->is_logged_in();

		$this->data['active_bar'] = "listeningquestions";
		$this->data['subview'] = "admin/listening/questions";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function writingquestions(){

		$this->is_logged_in();

		$this->data['active_bar'] = "writingquestions";
		$this->data['subview'] = "admin/writing/questions";
		$this->load->view('layout/adminlayout',$this->data);
	}
	
	public function readingquestions(){

		$this->is_logged_in();

		$this->data['active_bar'] = "readingquestions";
		$this->data['subview'] = "admin/reading/questions";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function createmocktest($mock_test_type, $mockId = ""){
		$this->is_logged_in();

		$section_duration ='';
		$speaking_duration = '';
		$writing_duration = '';
		$reading_duration = '';
		$listening_duration = '';

		$whereClause = "1 ORDER BY id DESC LIMIT 500";

		if($mock_test_type == 'section'){
			$this->data['mock_test_type'] = "section";
		}else if($mock_test_type == 'question'){
			$this->data['mock_test_type'] = "question";
		}else{
			$this->data['mock_test_type'] = "full";
		}

		$getReading = $this->Iifl_info->selectresult('reading_questions',$whereClause);
		$this->data['getReading'] = $getReading;

		$getWriting = $this->Iifl_info->selectresult('writing_questions',$whereClause);
		$this->data['getWriting'] = $getWriting;
		
		$getListening = $this->Iifl_info->selectresult('listening_questions',$whereClause);
		$this->data['getListening'] = $getListening;

		$getSpeaking = $this->Iifl_info->selectresult('speaking_questions',$whereClause);
		$this->data['getSpeaking'] = $getSpeaking;
		$getCatData = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();

		if(isset($mockId) && strlen($mockId)  > 0){
			$whereClause = array('id' => $mockId);
			$getMockTest = $this->Iifl_info->getdata('mock_test',$whereClause);
			$this->data['getMockTest'] = $getMockTest;
		}

		foreach($getCatData as $categories => $rowCategories){
			$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
		}

		$this->data['getCatData'] = $categoriesArr;

		$this->form_validation->set_rules('test-name', 'Name','required');
		
		if ($this->form_validation->run() == true ){
			$title = $this->input->post('test-name');
			$pte_type = $this->input->post('pteType');
			$test_type = $this->input->post('test-type');
			$test_sub_type = $this->input->post('test-sub-type');

			if($test_type == 'section-test' || $test_type == 'question-test' ){
				$section_duration = $this->input->post('section-duration');
			}else{

			$speaking_duration = $this->input->post('speaking-duration');
			$writing_duration = $this->input->post('writing-duration');
			$reading_duration = $this->input->post('reading-duration');
			$listening_duration = $this->input->post('listening-duration');

			}

			$listening_questions = $this->input->post('listening_questions');
			$reading_questions = $this->input->post('reading_questions');
			$writing_questions = $this->input->post('writing_questions');
			$speaking_questions = $this->input->post('speaking_questions');

			$data = array(
				'title' => $title, 
				'pte_type' => $pte_type,
				'test_type' => $test_type, 
				'test_sub_type' => $test_sub_type, 
				'listening' => $listening_questions, 
				'reading' => $reading_questions,
				'writing' => $writing_questions,
				'speaking' => $speaking_questions, 
				'section_duration' => $section_duration,
				'speaking_duration' => $speaking_duration, 
				'writing_duration' => $writing_duration, 
				'reading_duration' => $reading_duration, 
				'listening_duration' => $listening_duration, 
				'create_date' => date('Y-m-d h:i:s'));

				// $data = $this->security->xss_clean($data);

			if(isset($mockId) && strlen($mockId) > 0){
				$this->Iifl_info->update('mock_test',$data, $whereClause);
				$this->session->set_userdata('success','Mock Test Updated successfully');
				redirect(base_url().'admin/createmocktest/'.$mock_test_type.'/'.$mockId);
			}else{
				$this->Iifl_info->insert('mock_test',$data);
				$this->session->set_userdata('success','Mock Test Created successfully');
				redirect(base_url().'admin/createmocktest/'.$mock_test_type);
			}
		}

		$this->data['active_bar'] = "createmocktest";
		$this->data['subview'] = "admin/createMockTest";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function getquestiontypes(){

		$getstatus=0;
		$getquestiontypes = $this->Iifl_info->getdata('question_categories');
		$data['getquestiontypes'] = $getquestiontypes;

		if(count($getquestiontypes) > 0){
			$getstatus=1;
		}
		
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['status'] = $getstatus;
		echo json_encode($data);
		exit;
	}

	public function getquestionslist(){
        
		$category_table = $_GET['category'];
		$sub_category = $_GET['sub_category'];
		$mock_test_id = $_GET['mock_test_id'];
		$with_actions = $_GET['with_actions'];
        $order = array('id' => 'desc'); // default order 
        $column_search = array('id','title','question_type');
        $column_order = array(null,'id','title','question_type','create_date','update_date',null);
		
		if(strlen($sub_category) > 0){
			$whereClause = array('question_type'=> $sub_category);
		}
        $getquestions = $this->Iifl_info->getRows($_GET,$category_table.'_questions',$column_search,$column_order,$order,'','',$whereClause); 
        
		$getMockTest = false;
		$category_ids = array();
		if($mock_test_id){
			$whereClause = array('id' => $mock_test_id);
			$getMockTest = $this->Iifl_info->getdata('mock_test',$whereClause);
			$category_ids = explode(',',$getMockTest[0]->$category_table);
		}

        $data = $row = array();

        $i = 0;
        
        foreach($getquestions as $rowData){
            $i++;
            $row = array();

			$category_data = $this->Iifl_info->getdata('question_categories');
			$categoriesArr = array();
		
			foreach ($category_data as $key => $rowCategories) {
				$categoriesArr[$rowCategories->question_code] = $rowCategories->type_name;
			}
			if($with_actions){

				$row[] = $i;
				$row[] = '<a href="' . base_url('admin/add'.$category_table.'questions/'.$rowData->id) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($rowData->title) . '</span></a>';
				$row[] = ucwords($categoriesArr[$rowData->question_type]);

				$created_on = new DateTime($rowData->create_date);
				$last_updated = new DateTime($rowData->update_date);
				$row[] = $created_on->format("M d, Y g:i A");
				$row[] = $last_updated->format("M d, Y g:i A");
				$row[] = '<a href="'.base_url('admin/add'.$category_table.'questions/'.$rowData->id).'" class="btn-transparent btn-sm text-primary"><i class="fa fa-edit"></i></a>
				<a class="btn-transparent btn-sm text-primary" javascript:void(0); onclick="deleteQuestion('.$rowData->id.');"><i class="fa fa-trash"></i></a>';
			}else{
				$checked = '';
				if(in_array($rowData->id,$category_ids)){
					$checked = 'checked';
				}
				$row[] = '<input class="checked-box" type="checkbox" name="selected_'.strtolower(mb_substr($category_table, 0, 1)).'[]" value="'.$rowData->id.'" '.$checked.' data-parsley-multiple="check">';
				$row[] = $rowData->id;
				$row[] = $rowData->title;
				$row[] = ucwords($categoriesArr[$rowData->question_type]);
			}
            $data[] = $row;
        }
        $question_count = $this->Iifl_info->countAll($category_table.'_questions');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,$category_table.'_questions',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function viewmocktest($mockId = ""){
		$this->is_logged_in();

		$getMockTest = $this->Iifl_info->getdata('mock_test');
		$this->data['getMockTest'] = $getMockTest;

		$this->data['active_bar'] = "viewmocktest";
		$this->data['subview'] = "admin/viewMockTest";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function getmocktestname(){

		$name = $_POST['test-name'];

		$whereclause = array('title'=>$name);
		$result = $this->Iifl_info->getdata('mock_test',$whereclause); 
		$getstatus=0;

		if(count($result) > 0){
			$getstatus=1;
		}

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['status'] = $getstatus;
		echo json_encode($data);
		exit;
	}

	public function deletequestion(){

		$this->is_logged_in();

		$category = $_POST['category'];
		$categoryid = $_POST['categoryid'];

		$whereClause = array('id' => $categoryid);
    	$this->Iifl_info->delete($category.'_questions',$whereClause);

		// $this->session->set_userdata('error','Question deleted successfully');
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['categoryid'] = $categoryid;
		echo json_encode($data);
		exit;
	  }
	
	public function upload($folder = ""){
		$status = 0;
		if(strlen($_FILES['file']['name']) > 0){
			$status = 1;
			$fileExt = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$fileName = uniqid().'.'.$fileExt;
			$labelname ='file';  
			$audiopath = strlen($folder) > 0 ? 'uploads/materials/'.$folder."/" : 'uploads/materials/';
			$audio_file_location = $this->do_upload_file($audiopath,$labelname,$fileName);
			if(isset($audio_file_location['error'])){
				$status = 0;
			}
		}

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['status'] = $status;
		$data['result'] = $audio_file_location;
		echo json_encode($data);
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
	//   var_dump($config);
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

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url().'admin/signin');
	}

	public function packageSale(){

		$this->is_logged_in();

		$this->data['active_bar'] = "packageSale";
		$this->data['subview'] = "admin/packageSale";
		$this->load->view('layout/adminlayout', $this->data);
	}

	public function packagesalelist() {

		$order = array('purchaseid' => 'desc'); // default order 
        $column_search = array('purchaseid','product','studentid');
        $column_order = array(null,'product',null,'create_date','expire_date');
		
        $purchase_sales = $this->Iifl_info->getRows($_GET,'purchases',$column_search,$column_order,$order); 
		$studentList = $this->Iifl_info->getdata('studentuser');

		$studentNameArr = array();
		foreach ($studentList as $key => $row) {
			$studentNameArr[$row->studentId] = ucwords($row->first_name . ' ' . $row->last_name);
		}

        $data = array();

        $i = 0;
        foreach($purchase_sales as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = '<a href="' . base_url('package/createPackage/'.$rowData->productid) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($rowData->product) . '</span></a>';
            $row[] = $studentNameArr[$rowData->studentid];

            $created_on = new DateTime($rowData->create_date);
            $expire_date = new DateTime($rowData->expire_date);

			$row[] = $created_on->format("M d, Y g:i A");
			$row[] = $expire_date->format("M d, Y g:i A");
			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('purchases');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'purchases',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function studentResults(){

		$this->is_logged_in();

		$this->data['active_bar'] = "studentResults";
		$this->data['subview'] = "admin/studentResults";
		$this->load->view('layout/adminlayout', $this->data);
	}

	public function studentResultslist() {

		$order = array('id' => 'desc'); // default order 
        $column_order = array('id',null,null,null,null,null,null,null,null,null);

		// $getMockTestAnswers = $this->Iifl_info->selectresult('mock_test_answers',$whereClause);
		
        $test_results = $this->Iifl_info->getRows($_GET,'mock_test_results',null,$column_order,$order); 
		$studentList = $this->Iifl_info->getdata('studentuser');
		$mocktestList = $this->Iifl_info->getdata('mock_test');

		$studentArr = array();
		foreach ($studentList as $key => $row) {
			$studentArr[$row->studentId] = $row;
		}

		$mockNameArr = array();
		foreach ($mocktestList as $key => $row) {
			$mockNameArr[$row->id] = $row->title;
		}

        $data = array();

        $i = 0;
        foreach($test_results as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = $mockNameArr[$rowData->mock_series];
			$outputStr = '<a href="' . base_url('admin/student/' . $rowData->studentId) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($studentArr[$rowData->studentId]->first_name . ' ' . $studentArr[$rowData->studentId]->last_name) . '</span></a>';

			if($studentArr[$rowData->studentId]->validity && strlen($studentArr[$rowData->studentId]->validity) > 0){
				$expire_on = new DateTime($studentArr[$rowData->studentId]->validity);
				$expire_on = $expire_on->format("M d, Y");
				$outputStr .= '<br/><small>Expiry: ' . $expire_on . '</small>';
			}

            $row[] = $outputStr;

            $created_on = new DateTime($rowData->create_date);

			$row[] = $created_on->format("M d, Y g:i A");
			$row[] = $rowData->writing_score;
			$row[] = $rowData->reading_score;
			$row[] = $rowData->listening_score;
			$row[] = $rowData->speaking_score;
			$row[] = $rowData->overall_score;
			$row[] = $rowData->overall_score;
			
			$data[] = $row;		
        }
		
        $results_count = $this->Iifl_info->countAll('mock_test_results');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $results_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'mock_test_results',null,$column_order,$order),
            "data" => $data,
            "results_count" => $results_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function orderHistory(){

		$this->is_logged_in();

		$this->data['active_bar'] = "orderHistory";
		$this->data['subview'] = "admin/orderHistory";
		$this->load->view('layout/adminlayout', $this->data);

	 }

	 public function orderhistorylist() {
        $order = array('id' => 'desc'); // default order 
        $column_search = array('id','product','amount');
        $column_order = array(null,'product',null,'amount','status','create_date','last_updated');
		
        $order_history = $this->Iifl_info->getRows($_GET,'payments',$column_search,$column_order,$order); 

		$studentList = $this->Iifl_info->getdata('studentuser');

		$studentNameArr = array();
		foreach ($studentList as $key => $row) {
			$studentNameArr[$row->studentId] = ucwords($row->first_name . ' ' . $row->last_name);
		}

        $data = array();

        $i = 0;
        foreach($order_history as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = '<a href="' . base_url('package/createPackage/'.$rowData->productid) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($rowData->product) . '</span></a>';
            $row[] = $studentNameArr[$rowData->buyerid];
            $row[] = $rowData->amount;

			if($rowData->status == 1){
				$row[] = '<span class="badge badge-success ml-1">Paid</span>';
			}else{
				$row[] = '<span class="badge badge-warning ml-1">Pending</span>';
			}

            $created_on = new DateTime($rowData->create_date);
            $last_updated = new DateTime($rowData->last_updated);

			$row[] = $created_on->format("M d, Y g:i A");
			$row[] = $last_updated->format("M d, Y g:i A");
			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('payments');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'payments',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function feedbacks(){

		$this->is_logged_in();

		$this->data['active_bar'] = "feedbacks";
		$this->data['subview'] = "admin/feedbacks";
		$this->load->view('layout/adminlayout', $this->data);
	}

	public function material(){

		if($this->input->post()){
			$insertdata = array(
				"pte_type"=> $this->input->post('pteType'),
				"type" => $this->input->post('doc_type'),
				"category" => $this->input->post('category'),
				"language" => $this->input->post('language'),
				"status" => $this->input->post('status'),
				"label_name" => $this->input->post('label_name'),
				'last_updated' => date('Y-m-d h:i:s'),
				'create_date' => date('Y-m-d h:i:s'),
			);

			if($this->input->post('doc_type') == "document"){
				$insertdata['path'] = $this->input->post('uploaded_file');
			}elseif($this->input->post('doc_type') == "class_link"){
				$insertdata['path'] = json_encode($this->input->post('class_link'));
			}else{
				if($this->input->post('doc_type') == "video"){
					$insertdata['thumbnail'] = $this->input->post('uploaded_file');
				}
				$insertdata['path'] = $this->input->post('video_link');
			}

			$this->Iifl_info->insert('materials',$insertdata);
			$this->session->set_userdata('success','Material added succesfully');
		}
		$this->data['active_bar'] = "material";
		$this->data['subview'] = "admin/addMaterial";
		$this->load->view('layout/adminlayout', $this->data);
	}
	
	public function materials(){
		$this->is_logged_in();
		$this->data['active_bar'] = "materials";
		$this->data['subview'] = "admin/materialList";
		$this->load->view('layout/adminlayout',$this->data);
	}

	public function getmaterialslist(){
        
		$category = $_GET['type'];
        $order = array('id' => 'desc'); 
        $column_search = array('id','label_name','type','path','category','language');
        $column_order = array();
		if($category == "document"){
			$column_order = array(null,null,"label_name",null,"create_date",null);
		}elseif($category == "video"){
			$column_order = array(null,null,"label_name","category","language",null,"create_date",null);
		}elseif($category == "link"){
			$column_order = array(null,null,"label_name",null,"create_date",null);
		}elseif($category == "class_link"){
			$column_order = array(null,null,null,null,"create_date",null);
		}
		$whereClause = array('type' => $category);
        $materials = $this->Iifl_info->getRows($_GET,'materials',$column_search,$column_order,$order,'','',$whereClause);

        $data = $row = array();

        $i = 0;
        
        foreach($materials as $rowData){
            $i++;
            $row = array();
		

			$row[] = $i;
			
			if($category == "document"){
				$row[] = get_material_file_link_by_ext($rowData->path);
			}elseif($category == "video"){
				$row[] = '<a class="btn-transparent btn-sm text-primary" href="'.$rowData->path.'" target="_blank"><img src="'.base_url("assets/images/extensions/youtube.png").'" width="50px"></a>';
			}elseif($category == "link"){
				$row[] = '<a class="btn-transparent btn-sm text-primary font-20" href="'.$rowData->path.'" target="_blank"><i class="fa fa-link"></i></a>';
			}
			$row[] = $rowData->label_name;

			if($category == "video"){
				$row[] = ucwords($rowData->category);
				$row[] = $rowData->language == "PB" ? "Punjabi" : "English";
			}
			if($category == "class_link"){
				$row[] = json_decode($rowData->path);
			}

			$checked = '';
			if($rowData->status == 1){
				$checked = 'checked';
			}
            $row[] = '<input type="checkbox" class="status-switch" id="status-switch-'.$rowData->id.'" ' . $checked . ' onchange="changestatus(' . $rowData->id . ',this);" /><label for="status-switch-'.$rowData->id.'" class="toggle-label text-center">Status</label>'; 
            $created_on = new DateTime($rowData->create_date);
			$row[] = $created_on->format("M d, Y g:i A");

			$row[] = '<a class="btn-transparent btn-sm text-primary" javascript:void(0); onclick="deletematerial('.$rowData->id.');"><i class="fa fa-trash"></i></a>';
		    $data[] = $row;
		}

        $question_count = $this->Iifl_info->countAll('materials');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'materials',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function changematerialstatus(){
		$materialId = $_POST['material'];
		$status = $_POST['status'];

		$whereclause = array('id'=>$materialId);
		$this->Iifl_info->update('materials',array('status' => $status),$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function deletematerial(){
		$materialId = $_POST['material'];

		$whereclause = array('id'=>$materialId);
		$this->Iifl_info->delete('materials',$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function deletestudent(){
		$studentId = $_POST['student'];

		$whereclause = array('studentId'=>$studentId);
		$this->Iifl_info->delete('studentuser',$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}
	
	public function deletemocktest(){
		$id = $_POST['series'];

		$whereclause = array('id'=>$id);
		$this->Iifl_info->delete('mock_test',$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}
	
	public function checkedstudentstatus(){
		$studentId = $_POST['student'];
		$status = $_POST['status'];

		$whereclause = array('studentId'=>$studentId);
		$this->Iifl_info->update('studentuser',array('status' => $status),$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function extendStudentValidity(){
		$status = 0;
		$studentId = $_POST['studentId'];
		$newValidity = $_POST['newValidity'];

		$validity = extendAccountValidity($studentId, $newValidity);
		if($validity){
			$status = 1;
		}else{
			$status = 0;
		}
		$data['status'] = $status;
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function studentLogin(){

		//$this->session->unset_userdata('authId');
		$studentId = $_GET['studentId'];

		$whereclause = array('studentId'=>$studentId);
		$result = $this->Iifl_info->getdata('studentuser',$whereclause);

		$studentTests = get_test_and_video_by_studentid($result[0]->studentId, true, true);
		$studentTestIds = join(",",$studentTests['testIds']);
		$validity = new DateTime($result[0]->validity);

		$studentId =$this->encryption->encrypt($result[0]->studentId);
		$email =$this->encryption->encrypt($result[0]->email);
		$data = array(
			'name' => $result[0]->first_name.' '.$result[0]->last_name,
			'studentId' => $studentId,
			'email' =>$email,
			'profile_picture' => strlen($result[0]->profile_picture) > 0 ? $result[0]->profile_picture : false,
			'studentlogged' => true,
			'lastLogin'=>$result[0]->last_login,
			'studentTestIds'=>$studentTestIds,
			'show_videos'=>$studentTests['show_videos'],
			'addon_languages'=>$studentTests['addon_languages'],
			'show_materials'=>$studentTests['show_materials'],
			'show_class_links'=>$studentTests['show_class_links'],
			'validity'=> $validity->format("d M Y"),
			'actual_validity'=> $result[0]->validity,
			'profile_completed'=> $result[0]->profile_completed,
			'pte_core_access'=> $result[0]->pte_core_access,
		);

		// print_r($data);exit;
		$this->session->set_userdata($data);
		$status = 1;
		echo json_encode($status);
		exit;
	}

	public function updateStudentProfile(){

		$this->is_logged_in();

		$this->form_validation->set_rules('first_name', 'First Name','required');
		$this->form_validation->set_rules('last_name', 'Last Name','required');
		$this->form_validation->set_rules('email', 'Email','required');
		// $this->form_validation->set_rules('password', 'Password','required');

		$studentId = $this->input->post('studentId');
		if ($this->form_validation->run() == true ){
			$first_name 				= $this->input->post('first_name');
			$last_name 					= $this->input->post('last_name');
			$email 						= $this->input->post('email');
			$password 					= $this->input->post('password');
			$phone 						= $this->input->post('phone');


			$db_data = array(
				'first_name' 	=> $first_name,
				'last_name' 	=> $last_name,
				'email'	 		=> $email,
				'auth_password' => md5($password),
				'phone' 		=> $phone,
				'last_updated' 	=> date('Y-m-d h:i:s')
			);
			$this->session->set_userdata('success','Student Updated Successfully');
			$this->Iifl_info->update('studentuser', $db_data, array('studentId' => $studentId));
		}
		$token = $this->security->get_csrf_hash();
		redirect(base_url().'admin/student/'.$studentId);
	}

	public function sendApplykartReminderEmail(){
		$emails = $this->Iifl_info->selectdata("*",'scheduled_emails'," scheduled_at <= NOW()");
		if($emails && count($emails) > 0){
			foreach ($emails as $key => $email) {
				$this->db->where('studentid', $email->student_id);
            	$student = $this->db->get('studentuser')->row();
				$mail_data = array(
					'student_name' => ucwords(trim(strtolower($student->first_name . ' ' .$student->last_name))), 
					'base_url' => base_url('user'),
					'email_signature' => MAIL_SIGNATURE
				);
				send_applykart_reminder_cron_mail($student->email, $mail_data);
				$this->db->where('student_id', $email->student_id);
            	$this->db->delete('scheduled_emails');
			}
			echo "Scheduled Email Excecuted";
		}
	}
}
