<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mock extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->library('encryption');
		$this->load->helper('security');
		$this->load->helper('score_api_helper');
		$this->load->helper('student_helper');
		$this->load->model('package_model');

		$studentId = $this->session->userdata('studentId');
		$student_name = $this->session->userdata('name');
     	$studentId =  $this->encryption->decrypt($studentId);
      	$this->studentId = $studentId;
      	$this->student_name = $student_name;

		$this->speaking_types = array('read_alouds','repeat_sentences','describe_images','retell_lectures','respond_situation','answer_questions');
		$this->reading_types = array('fib_wr','fib_rd','r_mcm','r_mcs','ro');
		$this->writing_types = array('swtx','essays','email');
		$this->listening_types = array('ssts','wfds','l_mcm','l_mcs','l_hcs','l_smw','l_fib','hiws');
		$this->all_test_types = array('read_alouds','repeat_sentences','describe_images','retell_lectures','respond_situation','answer_questions','fib_wr','fib_rd','r_mcm','r_mcs','ro','swtx','essays','email','ssts','wfds','l_mcm','l_mcs','l_hcs','l_smw','l_fib','hiws');
    }

	private function is_logged_in() {
		if (!$this->session->userdata('studentId')) {
			redirect(base_url().'user/signin');
		}
		return true;
	}

    public function test($mockseries, $mock_test_id = ''){

		// $mockseries = $this->encryption->decrypt(urldecode($mockseries));
		
        $this->is_logged_in();

		if(strpos($this->session->userdata('studentTestIds'),$mockseries) !== false){
		
		$whereSeriesClause = array('id' => $mockseries, "pte_type" => $this->session->userdata('pte_type'));
		$mockdata = $this->Iifl_info->getdata('mock_test',$whereSeriesClause);

		if(count($mockdata) == 0){ redirect(base_url().'user/home'); }

		$mocktestId = strlen($mock_test_id) != 0 ? $mock_test_id : $this->generateRandomString();
		
		$this->session->set_userdata('mocktestid',$mocktestId);
		$this->session->set_userdata('mockseries',$mockseries);

		$this->data['mockdata'] = $mockdata;
		$this->data['mocktestid'] = $mocktestId;
		$this->data['subview'] = "student/mocktest/mocktest";
		$this->load->view ("student/mocktest/mocklayout",$this->data);
	}else{
		redirect(base_url().'user/home'); 
	}
	}

	public function getresources(){
		$mockseries = $this->session->userdata('mockseries');
		$mocktestId = $this->session->userdata('mocktestid');
		
		$whereSeriesClause = array('id' => $mockseries, "pte_type" => $this->session->userdata('pte_type'));
		$mockdata = $this->Iifl_info->getdata('mock_test',$whereSeriesClause);

		$mock_test_type = $mockdata[0]->test_type;
		$mock_test_sub_type = $mockdata[0]->test_sub_type;

		if($mock_test_type == 'section-test' || stripos($mock_test_type, 'section')){
			$mock_test_sub_type = $mockdata[0]->test_sub_type;
			if($mock_test_sub_type == 'speaking')
				$mockdata[0]->speaking_duration = $mockdata[0]->section_duration;
			if($mock_test_sub_type == 'writing')
				$mockdata[0]->writing_duration = $mockdata[0]->section_duration;
			if($mock_test_sub_type == 'listening')
				$mockdata[0]->listening_duration = $mockdata[0]->section_duration;
			if($mock_test_sub_type == 'reading')
				$mockdata[0]->reading_duration = $mockdata[0]->section_duration;
		}
		
		if($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')){
			$mock_test_sub_type = $mockdata[0]->test_sub_type;
			$sub_category_data = getCategoryDataByCode($mock_test_sub_type);
			if($sub_category_data['category'] == 'speaking')
				$mockdata[0]->speaking_duration = $mockdata[0]->section_duration;
			if($sub_category_data['category'] == 'writing')
				$mockdata[0]->writing_duration = $mockdata[0]->section_duration;
			if($sub_category_data['category'] == 'listening')
				$mockdata[0]->listening_duration = $mockdata[0]->section_duration;
			if($sub_category_data['category'] == 'reading')
				$mockdata[0]->reading_duration = $mockdata[0]->section_duration;
		}

		$speaking_questions = explode(',',$mockdata[0]->speaking);
		$reading_questions = explode(',',$mockdata[0]->reading);
		$writing_questions = explode(',',$mockdata[0]->writing);
		$listening_questions = explode(',',$mockdata[0]->listening);
		$questionData['counts'] = [];
		$questionData['counts']['speaking'] = count($speaking_questions);
		$questionData['counts']['reading'] = count($reading_questions);
		$questionData['counts']['writing'] = count($writing_questions);
		$questionData['counts']['listening'] = count($listening_questions);

		// if user tries to continue test | start
		$whereResumeClause = array('mock_test_id' => $mocktestId, 'user_id' => $this->studentId);
		// remove unsaved answer responses
		// $this->Iifl_info->delete('mock_test_answers',array('mock_test_id' => $mocktestId, 'user_id' => $this->studentId, "status" => NULL));
		$user_responses = $this->Iifl_info->getdata('mock_test_answers',$whereResumeClause,array(),'id','desc');

		if(count($user_responses) > 0){

			$last_timestamp = (int)$user_responses[0]->timestamp;
			$last_question_type = $user_responses[0]->question_type;
			$questionData['resume'] = true;

			if(in_array($last_question_type,$this->speaking_types)){
				$last_question_type_category = 'speaking';
			}
			if(in_array($last_question_type,$this->writing_types)){
				$last_question_type_category = 'writing';
			}
			if(in_array($last_question_type,$this->reading_types)){
				$last_question_type_category = 'reading';
			}
			if(in_array($last_question_type,$this->listening_types)){
				$last_question_type_category = 'listening';
			}

			foreach($user_responses as $key => $rowdata){
				if(in_array($rowdata->question_type,$this->speaking_types) && $rowdata->status == 3){
					$key = array_search($rowdata->question_id, $speaking_questions);
					if($key !== false){
						array_splice($speaking_questions, $key, 1);
					}
				}

				if(in_array($rowdata->question_type,$this->writing_types) && $rowdata->status == 3){
					$key = array_search($rowdata->question_id, $writing_questions);
					if($key !== false){
						array_splice($writing_questions, $key, 1);
					}
				}

				if(in_array($rowdata->question_type,$this->reading_types) && $rowdata->status == 3){
					$key = array_search($rowdata->question_id, $reading_questions);
					if($key !== false){
						array_splice($reading_questions, $key, 1);
					}
				}

				if(in_array($rowdata->question_type,$this->listening_types) && $rowdata->status == 3){
					$key = array_search($rowdata->question_id, $listening_questions);
					if($key !== false){
						array_splice($listening_questions, $key, 1);
					}
				}
			}
		}

 		if(count(array_filter($listening_questions)) > 0){
			$startCategory = 'listening';
		}
		if(count(array_filter($reading_questions)) > 0){
			$startCategory = 'reading';
		}
 		if(count(array_filter($writing_questions)) > 0){
			$startCategory = 'writing';
		}
 		if(count(array_filter($speaking_questions)) > 0){
			$startCategory = 'speaking';
		}

		$questionData['speaking'] = array_filter($speaking_questions);
		$questionData['reading'] = array_filter($reading_questions);
		$questionData['writing'] = array_filter($writing_questions);
		$questionData['listening'] = array_filter($listening_questions);

		/* check if no questions are left but status is marked as not completed*/
		if(
			count($questionData['speaking']) == 0 &&
			count($questionData['reading']) == 0 &&
			count($questionData['writing']) == 0 &&
			count($questionData['listening']) == 0
		){
			if(mark_mock_as_completed($mocktestId, $mockseries, $this->studentId))
				redirect(base_url().'mock/myattempts');
		}

		$questionData['speakingDuration'] = (count($user_responses) > 0 && $last_question_type_category == 'speaking') ? $last_timestamp : $mockdata[0]->speaking_duration * 60 + $mockdata[0]->writing_duration * 60;
		$questionData['readingDuration'] = (count($user_responses) > 0 && $last_question_type_category == 'reading') ? $last_timestamp : $mockdata[0]->reading_duration * 60;
		$questionData['writingDuration'] = (count($user_responses) > 0 && $last_question_type_category == 'writing') ? $last_timestamp : $mockdata[0]->writing_duration * 60;
		$questionData['listeningDuration'] = (count($user_responses) > 0 && $last_question_type_category == 'listening') ? $last_timestamp : $mockdata[0]->listening_duration * 60;
		
		$questionData['startCategory'] = $startCategory;
		$questionData['series'] = $mockseries;
		$questionData['mock_test_id'] = $mocktestId;
		$questionData['mock_test_type'] = $mock_test_type;

		$data['questionData'] = $questionData;

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
     	$data['series'] = $mockseries;
     	$data['mock_test_id'] = $mocktestId;
    	echo json_encode($data);
    	exit;
	}

	public function next(){
		$mockseries = $this->session->userdata('mockseries');
		$mocktestId = $this->session->userdata('mocktestid');
		$this->load->library('user_agent');
		
		$category = $_POST['category'];
		$questionId = $_POST['modelId'];

		$whereClause = array('id' => $questionId, 'status' => 1);
		$questionData = $this->Iifl_info->getdata($category.'_questions',$whereClause);
		$whereClause = array('question_code' => $questionData[0]->question_type);
		$questionCate = $this->Iifl_info->getdata('question_categories',$whereClause);
		
		// var_dump($questionCate);
		$this->data['question'] = $questionData;
		$this->data['category'] = $questionCate;
		$this->data['model'] = $questionData[0]->question_type;
		$this->data['modelcategory'] = $category;

		$modelview = $this->load->view('student/mocktest/mocktest', $this->data,true);

		$log_data = array(
			"studentId" => $this->studentId,
			"student_name" => $this->student_name,
			"mock_series" => $mockseries,
			"mock_test_id" => $mocktestId,
			"user_agent" => $_SERVER['HTTP_USER_AGENT'],
			"browser" => $this->agent->browser(),
			"platform" => $this->agent->platform(),
			'create_date' => date('Y-m-d h:i:s'),
			"meta_status" => "NEXT_QUESTION",
			"description" => $questionData[0]->question_type
		);
		$this->Iifl_info->insert('mock_test_logs',$log_data);
		
		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
		$data['view'] = $modelview;
		$data['series'] = $mockseries;
		$data['mock_test_id'] = $mocktestId;
    	echo json_encode($data);
    	exit;
	}

	public function submitresponse(){
		$mockseries = $this->session->userdata('mockseries');
		$mocktestId = $this->session->userdata('mocktestid');

		$category = $_POST['category'];
		$questionId = $_POST['modelId'];
		$response = $_POST['response'];
		$model = $_POST['model'];
		$timestamp = $_POST['timestamp'];
		$this->load->library('user_agent');

		try{
			$insertData = array(
				'user_id' => $this->studentId,
				'mock_series' => $mockseries,
				'mock_test_id' => $mocktestId,
				'question_id' => $questionId,
				'question_type' => $model,
				'answer' => $response,
				'timestamp' => $timestamp,
				'user_agent' => $_SERVER['HTTP_USER_AGENT'],
				'browser' => $this->agent->browser(),
				'platform' => $this->agent->platform(),
				'status' => 3, 
				'create_date' => date('Y-m-d h:i:s')
			);

			$log_data = array(
				"studentId" => $this->studentId,
				"student_name" => $this->student_name,
				"mock_series" => $mockseries,
				"mock_test_id" => $mocktestId,
				"user_agent" => $_SERVER['HTTP_USER_AGENT'],
				"browser" => $this->agent->browser(),
				"platform" => $this->agent->platform(),
				'create_date' => date('Y-m-d h:i:s'),
				"meta_status" => "RESPONSE_RECORDED",
				"description" => $model
			);
			
			$this->Iifl_info->insert('mock_test_answers',$insertData);
			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}catch(Exception $e){
			$log_data = array(
				"studentId" => $this->studentId,
				"student_name" => $this->student_name,
				"mock_series" => $mockseries,
				"mock_test_id" => $mocktestId,
				"meta_status" => "ERROR_WHILE_SUBMITTING_RESPONSE",
				"description" => $e->getMessage(),
				"user_agent" => $_SERVER['HTTP_USER_AGENT'],
				"browser" => $this->agent->browser(),
				"platform" => $this->agent->platform(),
				'create_date' => date('Y-m-d h:i:s')
			);

			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
		$data['mock_test_id'] = $mocktestId;
    	echo json_encode($data);
    	exit;
	}

	public function submittest(){
		$mockseries = $this->session->userdata('mockseries');
		$mocktestId = $this->session->userdata('mocktestid');
		$this->load->library('user_agent');

		$whereClause = array(
			'mock_test_id' => $mocktestId, 
			'mock_series' => $mockseries, 
			'user_id' => $this->studentId
		);
		$updateData = array(
			'status' => 2, 
			'update_date' => date('Y-m-d h:i:s'),
			'saved' => 1
		);

		$log_data = array(
			"studentId" => $this->studentId,
			"student_name" => $this->student_name,
			"mock_series" => $mockseries,
			"mock_test_id" => $mocktestId,
			"user_agent" => $_SERVER['HTTP_USER_AGENT'],
			"browser" => $this->agent->browser(),
			"platform" => $this->agent->platform(),
			'create_date' => date('Y-m-d h:i:s')
		);

		try{
			$log_data["meta_status"] = "COMPLETED";
			$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}catch (Exception $e){
			$log_data["meta_status"] = "ERROR";
			$log_data["description"] = $e->getMessage();
			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
    	echo json_encode($data);
    	exit;
	}
	
	public function savetest(){
		$mockseries = $this->session->userdata('mockseries');
		$mocktestId = $this->session->userdata('mocktestid');
		$this->load->library('user_agent');

		$whereClause = array(
			'mock_test_id' => $mocktestId, 
			'mock_series' => $mockseries, 
			'user_id' => $this->studentId
		);
		$updateData = array(
			'status' => 3, 
			'update_date' => date('Y-m-d h:i:s'),
			'saved' => 1
		);

		$log_data = array(
			"studentId" => $this->studentId,
			"student_name" => $this->student_name,
			"mock_series" => $mockseries,
			"mock_test_id" => $mocktestId,
			"user_agent" => $_SERVER['HTTP_USER_AGENT'],
			"browser" => $this->agent->browser(),
			"platform" => $this->agent->platform(),
			'create_date' => date('Y-m-d h:i:s')
		);

		try{
			$log_data["meta_status"] = "SAVED";
			$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}catch (Exception $e){
			$log_data["meta_status"] = "ERROR";
			$log_data["description"] = $e->getMessage();
			$this->Iifl_info->insert('mock_test_logs',$log_data);
		}

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
    	echo json_encode($data);
    	exit;
	}

	public function deleteattempt(){
		$mocktestId = $this->input->post('mocktestid');

		$whereClause = array('mock_test_id' => $mocktestId, 'user_id' => $this->studentId);
		$this->Iifl_info->delete('mock_test_answers',$whereClause);

		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
    	echo json_encode($data);
    	exit;
	}

	public function getresult(){
		$mockTestId = $this->input->post('mockTestId');
		$series = $this->input->post('series');

		$whereClause = array('id' => $series, "pte_type" => $this->session->userdata('pte_type'));
		$mocktestdata = $this->Iifl_info->getdata('mock_test',$whereClause);

		$whereTestClause = array('mock_test_id' => $mockTestId, 'mock_series' => $series, 'user_id' => $this->studentId, 'status'=>2);
		$useranswers = $this->Iifl_info->getdata('mock_test_answers',$whereTestClause);

		if(strlen($mocktestdata[0]->speaking) > 0){
			$speaking_test_types = array('read_alouds','repeat_sentences','describe_images','retell_lectures','answer_questions','respond_situation');
			
			// foreach
			$whereClause = " id in (".$mocktestdata[0]->speaking.")";
			$speaking = $this->Iifl_info->selectresult('speaking_questions',$whereClause);
		}

		if(strlen($mocktestdata[0]->writing) > 0){
			$writing_test_types = array('swtx','essays','email');

			$whereClause = " id in (".$mocktestdata[0]->writing.")";
			$writing = $this->Iifl_info->selectresult('writing_questions',$whereClause);
		}

		if(strlen($mocktestdata[0]->reading) > 0){
			$reading_test_types = array('fib_wr','r_mcm','r_mcs','fib_rd','ro');

			$whereClause = " id in (".$mocktestdata[0]->reading.")";
			$reading = $this->Iifl_info->selectresult('reading_questions',$whereClause);
		}

		if(strlen($mocktestdata[0]->listening) > 0){
			$listening_test_types = array('ssts','wfds','l_mcm','l_mcs','l_hcs','l_smw','l_fib','hiws');

			$whereClause = " id in (".$mocktestdata[0]->listening.")";
			$listening = $this->Iifl_info->selectresult('listening_questions',$whereClause);
		}
		$this->db->trans_start();
		foreach($useranswers as $row => $response){
			try{
			//speaking scoring

			if(in_array($response->question_type,$speaking_test_types) && $response->status == 2){
				foreach($speaking as $skey => $rowspeak){
					if($response->question_id == $rowspeak->id){
						switch($response->question_type){
							case 'read_alouds':
								$apiresponse = getSpeakingScores( base_url().$response->answer, $rowspeak->question);

								$componentScore = array();

								if(!isset($apiresponse['result'])){
									$componentScore['pronunciation'] = 0;
									$componentScore['fluency'] = 0;
									$componentScore['content'] = 0;
								}else{
									$componentScore['pronunciation'] = $apiresponse['result']['pronunciation'];
									$componentScore['fluency'] = $apiresponse['result']['fluency'];
									$componentScore['content'] = $apiresponse['result']['overall'];
								}


									$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
									$points['content'] = $componentScore['content'] / 90 * 5;
									$points['pronunciation'] = $componentScore['pronunciation'] / 90 * 5;
									$points['fluency'] = $componentScore['fluency'] / 90 * 5;

									$data = array(
										'user_id' => $this->studentId,
										'question_id' => $response->question_id, 
										'question_type' => 'read_alouds', 
										'answer' => $response->answer, 
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('speaking_answers',$data);

									$updateData = array(
										'status' => 1,
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'points' => round(array_sum($points)),
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'repeat_sentences':
								$apiresponse = getSpeakingScores( base_url().$response->answer, $rowspeak->transcript);

								$componentScore = array();

								if(!isset($apiresponse['result'])){
									$componentScore['pronunciation'] = 0;
									$componentScore['fluency'] = 0;
									$componentScore['content'] = 0;
								}else{
									$componentScore['pronunciation'] = $apiresponse['result']['pronunciation'];
									$componentScore['fluency'] = $apiresponse['result']['fluency'];
									$componentScore['content'] = $apiresponse['result']['overall'];
								}

									$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;

									$points['content'] = $componentScore['content'] / 90 * 5;
									$points['pronunciation'] = $componentScore['pronunciation'] / 90 * 5;
									$points['fluency'] = $componentScore['fluency'] / 90 * 3;

									$data = array(
										'user_id' => $this->studentId,
										'question_id' => $response->question_id, 
										'question_type' => 'repeat_sentences', 
										'answer' => $response->answer, 
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('speaking_answers',$data);

									$updateData = array(
										'status' => 1,
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'points' => round(array_sum($points)),
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'describe_images':
								$apiresponse = get_describe_image_scores(base_url().$response->answer, $rowspeak->keywords);

								$componentScore = array();

								if(!isset($apiresponse['result'])){
									$componentScore['pronunciation'] = 0;
									$componentScore['fluency'] = 0;
									$componentScore['content'] = 0;
								}else{
									$componentScore['pronunciation'] = $apiresponse['result']['pronunciation'];
									$componentScore['fluency'] = $apiresponse['result']['fluency'];
									$componentScore['content'] = $apiresponse['result']['overall'];
								}

									$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;

									$points['content'] = $componentScore['content'] / 90 * 5;
									$points['pronunciation'] = $componentScore['pronunciation'] / 90 * 5;
									$points['fluency'] = $componentScore['fluency'] / 90 * 5;

									$data = array(
										'user_id' => $this->studentId,
										'question_id' => $response->question_id, 
										'question_type' => 'describe_images', 
										'answer' => $response->answer, 
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('speaking_answers',$data);

									$updateData = array(
										'status' => 1,
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'points' => round(array_sum($points)),
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
								break;

							case 'retell_lectures':
								$apiresponse = get_retell_lecture_scores(base_url().$response->answer, $rowspeak->keywords);

								$componentScore = array();

								if(!isset($apiresponse['result'])){
									$componentScore['pronunciation'] = 0;
									$componentScore['fluency'] = 0;
									$componentScore['content'] = 0;
								}else{
									$componentScore['pronunciation'] = $apiresponse['result']['pronunciation'];
									$componentScore['fluency'] = $apiresponse['result']['fluency'];
									$componentScore['content'] = $apiresponse['result']['overall'];
								}

									$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;

									$points['content'] = $componentScore['content'] / 90 * 5;
									$points['pronunciation'] = $componentScore['pronunciation'] / 90 * 5;
									$points['fluency'] = $componentScore['fluency'] / 90 * 5;

									$data = array(
										'user_id' => $this->studentId,
										'question_id' => $response->question_id, 
										'question_type' => 'retell_lectures', 
										'answer' => $response->answer, 
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('speaking_answers',$data);

									$updateData = array(
										'status' => 1,
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'points' => round(array_sum($points)),
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
								break;

								case 'respond_situation':
									$apiresponse = get_respond_situation_scores(base_url().$response->answer, $rowspeak->keywords);
	
									$componentScore = array();
	
									if(!isset($apiresponse['result'])){
										$componentScore['pronunciation'] = 0;
										$componentScore['fluency'] = 0;
										$componentScore['content'] = 0;
									}else{
										$componentScore['pronunciation'] = $apiresponse['result']['pronunciation'];
										$componentScore['fluency'] = $apiresponse['result']['fluency'];
										$componentScore['content'] = $apiresponse['result']['overall'];
									}
	
										$score = ($componentScore['pronunciation']+$componentScore['fluency']+$componentScore['content']) / 3;
	
										$points['content'] = $componentScore['content'] / 90 * 5;
										$points['pronunciation'] = $componentScore['pronunciation'] / 90 * 5;
										$points['fluency'] = $componentScore['fluency'] / 90 * 5;
	
										$data = array(
											'user_id' => $this->studentId,
											'question_id' => $response->question_id, 
											'question_type' => 'respond_situation', 
											'answer' => $response->answer, 
											'score' => floor($score),
											'component_score' => json_encode($componentScore),
											'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
											'create_date' => date('Y-m-d h:i:s')
										);
										$answer_id = $this->Iifl_info->insert('speaking_answers',$data);
	
										$updateData = array(
											'status' => 1,
											'score' => floor($score),
											'component_score' => json_encode($componentScore),
											'points' => round(array_sum($points)),
											'answer_id' => $answer_id
										);
										$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
										$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
									break;
		
							case 'answer_questions':
								$apiresponse = getSpeakingScores( base_url().$response->answer, $rowspeak->answer, "strict");

								$componentScore = array();

								if(!isset($apiresponse['result'])){
									$componentScore['content'] = 0;
								}else{
									$componentScore['content'] = $apiresponse['result']['content-asq'];
								}

								$score = $componentScore['content'];

									$data = array(
										'user_id' => $this->studentId,
										'question_id' => $response->question_id, 
										'question_type' => 'answer_questions', 
										'answer' => $response->answer, 
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'answer_transcript' => $apiresponse['result'] && $apiresponse['result']['mistakes'] ? $apiresponse['result']['mistakes'] : "",
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('speaking_answers',$data);

									$updateData = array(
										'status' => 1,
										'score' => floor($score),
										'component_score' => json_encode($componentScore),
										'points' => $componentScore['content'],
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
								break;
						}
						break;
					}
				}
			}

			// writing scoring
			
			if(in_array($response->question_type,$writing_test_types) && $response->status == 2){
				foreach($writing as $wkey => $rowwriting){
					if($response->question_id == $rowwriting->id){
						switch($response->question_type){
							case 'swtx':
								$sample_input = $response->question;
								$apiResponse = getswtxscores($response->answer, $rowwriting->keywords, $sample_input);
								
								if(!isset($apiResponse['scores'])){
									$apiResponse['scores'] = array('content' => 0, 'grammar' => 0, 'vocabulary' => 0, 'form' => 0);
									$apiResponse['mistakes'] = "";
								}

								$score = array_sum($apiResponse['scores']);

								$data = array(
									'user_id' => $this->studentId ,
									'question_id' => $response->question_id, 
									'question_type' => 'swtx', 
									'answer' => $response->answer, 
									'score' => $score,
									'component_score' => json_encode($apiResponse['scores']),
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('writing_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'component_score' => json_encode($apiResponse['scores']),
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'essays':
								$paragraphs = explode("\r\n", $response->answer);
								$paragraphs = array_filter($paragraphs,'trim');
								$response->answer = implode($paragraphs," \n");

								$apiResponse = getessayscores($response->answer, $rowwriting->keywords);
								
								if(!isset($apiResponse['scores'])){
									$apiResponse['scores'] = array('content' => 0, 'grammar' => 0, 'spelling' => 0, 'vocabulary' => 0, 'form' => 0, 'structure' => 0, 'linguistic' => 0);
									$apiResponse['mistakes'] = "";
								}

								$score = array_sum($apiResponse['scores']);

								$data = array(
									'user_id' => $this->studentId ,
									'question_id' => $response->question_id, 
									'question_type' => 'essays', 
									'answer' => $response->answer, 
									'score' => $score,
									'component_score' => json_encode($apiResponse['scores']),
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('writing_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'component_score' => json_encode($apiResponse['scores']),
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

								case 'email':
									// $paragraphs = explode("\n", $response->answer);
									// $paragraphs = array_filter($paragraphs,'trim');
									// $response->answer = implode($paragraphs,"\n\n");
	
									$additional_data = json_decode($rowwriting->additional_json);
									$apiResponse = getemailscores($response->answer, $rowwriting->keywords, $additional_data->reason);
									
									if(!isset($apiResponse['scores'])){
										$apiResponse['scores'] = array('content' => 0, 'grammar' => 0, 'spelling' => 0, 'vocabulary' => 0, 'form' => 0, 'structure' => 0, 'linguistic' => 0);
										$apiResponse['mistakes'] = "";
									}
									
									$score = array_sum($apiResponse['scores']);

									$data = array(
										'user_id' => $this->studentId ,
										'question_id' => $response->question_id, 
										'question_type' => 'email', 
										'answer' => $response->answer, 
										'score' => $score,
										'component_score' => json_encode($apiResponse['scores']),
										'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
										'create_date' => date('Y-m-d h:i:s')
									);
									$answer_id = $this->Iifl_info->insert('writing_answers',$data);
	
									$updateData = array(
										'status' => 1,
										'score' => $score,
										'points' => $score,
										'component_score' => json_encode($apiResponse['scores']),
										'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
										'answer_id' => $answer_id
									);
									$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
									$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);
									break;
						}
						break;
					}
				}
			}
			
			
			// reading scoring

			if(in_array($response->question_type,$reading_test_types) && $response->status == 2){
				foreach($reading as $rkey => $rowreading){
					if($response->question_id == $rowreading->id){
						switch($response->question_type){
							case 'r_mcm':
								$originalAnswer = json_decode($rowreading->answer);
								$userScoreResponse = json_decode($response->answer);
								$userAnswer = array();

								$originalAnswerCount = 0;
								foreach ($originalAnswer as $value) {
									if ($value == "1") {
										$originalAnswerCount++;
									}
								}

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										array_push($userAnswer,chr($key + 65));
									}
								}

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
									'question_id' => $response->question_id, 
									'question_type' => 'r_mcm', 
									'answer' => json_encode($userAnswer), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('reading_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / $originalAnswerCount * 2),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);	
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'r_mcs':
								$score = 0;
								$originalAnswer = json_decode($rowreading->answer);
								$userScoreResponse = json_decode($response->answer);

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										$userAnswer = chr($key + 65);
									}
								}

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
									'question_id' => $response->question_id, 
									'question_type' => 'r_mcs', 
									'answer' => $userAnswer, 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('reading_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);

								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;
								
							case 'fib_wr':
								$score = 0;
								$originalAnswer = json_decode($rowreading->answer);
								$userAnswer = json_decode($response->answer);
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
									'question_id' => $response->question_id, 
									'question_type' => 'fib_wr', 
									'answer' => json_encode($userAnswerArr), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);					
								$answer_id = $this->Iifl_info->insert('reading_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswer) * 6),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;
								
							case 'fib_rd':
								$score = 0;
								$originalAnswer = json_decode($rowreading->answer);
								$userAnswer = json_decode($response->answer);
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
									'question_id' => $response->question_id, 
									'question_type' => 'fib_rd', 
									'answer' => json_encode($userAnswerArr), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);					
								$answer_id = $this->Iifl_info->insert('reading_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswer) * 5),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'ro':
								$score = 0;
								$originalAnswer = json_decode($rowreading->answer);
								$userAnswer = json_decode($response->answer);

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
									'question_id' => $response->question_id, 
									'question_type' => 'ro', 
									'answer' => implode(', ',$userAnswer), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);					
								$answer_id = $this->Iifl_info->insert('reading_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswer) * 4),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;
						}
						break;
					}
				}
			}

			// listening scoring
			
			if(in_array($response->question_type,$listening_test_types) && $response->status == 2){
				foreach($listening as $lkey => $rowlistening){
					if($response->question_id == $rowlistening->id){
						switch($response->question_type){
							case 'ssts':
								$apiResponse = getsstsscores($response->answer, $rowlistening->keywords);

								if(!isset($apiResponse['scores'])){
									$apiResponse['scores'] = array('content' => 0, 'grammar' => 0, 'spelling' => 0, 'vocabulary' => 0, 'form' => 0);
									$apiResponse['mistakes'] = "";
								}

								$score = array_sum($apiResponse['scores']);

								$data = array(
									'user_id' => $this->studentId,
									'question_id' =>$response->question_id, 
									'question_type' => 'ssts', 
									'answer' => $response->answer, 
									'score' => $score,
									'component_score' => json_encode($apiResponse['scores']),
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'component_score' => json_encode($apiResponse['scores']),
									'score' => $score,
									'points' => $score,
									'mistakes' => strlen($apiResponse['mistakes']) > 0 ? json_encode($apiResponse['mistakes']) : null,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'l_mcm':
								$originalAnswer = json_decode($rowlistening->answer);
								$userScoreResponse = json_decode($response->answer);
								$userAnswer = array();

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										array_push($userAnswer,chr($key + 65));
									}
								}

								$score = 0;
								$count_of_correct_answers = 0;

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
									'question_id' => $response->question_id, 
									'question_type' => 'l_mcm', 
									'answer' => json_encode($userAnswer), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);
								
								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'l_mcs':
								$originalAnswer = json_decode($rowlistening->answer);
								$userScoreResponse = json_decode($response->answer);

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										$userAnswer = chr($key + 65);
									}
								}

								$score = 0;

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
									'question_id' => $response->question_id, 
									'question_type' => 'l_mcs', 
									'answer' => $userAnswer, 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);

								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'l_hcs':
								$originalAnswer = json_decode($rowlistening->answer);
								$userScoreResponse = json_decode($response->answer);

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										$userAnswer = chr($key + 65);
									}
								}

								$score = 0;

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
									'question_id' => $response->question_id, 
									'question_type' => 'l_hcs', 
									'answer' => $userAnswer, 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);

								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'l_smw':
								$originalAnswer = json_decode($rowlistening->answer);
								$userScoreResponse = json_decode($response->answer);

								foreach($userScoreResponse as $key => $rowanswer){
									if($rowanswer == '1'){
										$userAnswer = chr($key + 65);
									}
								}

								$score = 0;

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
									'question_id' => $response->question_id, 
									'question_type' => 'l_smw', 
									'answer' => $userAnswer, 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => $score,
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);

								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'wfds':
								$originalAnswerArr = explode(' ',strtolower(trim(preg_replace('/\p{P}/', '',$rowlistening->transcript))));
								$userAnswer = preg_replace('/\p{P}/', '',strtolower($response->answer));
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
									'question_id' => $response->question_id, 
									'question_type' => 'wfds', 
									'answer' => ucfirst($userAnswer), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswerArr) * 12),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'l_fib':
								$score = 0;
								$originalAnswer = json_decode($rowlistening->answer);
								$userAnswer = json_decode($response->answer);
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
									$suggestion = "Target 79: max 1 mistake. Target 65: max 2 mistakes. Target 50: max 2 mistakes.";
								}else{
									$suggestion = "Excellent";
								}

								$data = array(
									'user_id' => $this->studentId ,
									'question_id' => $response->question_id, 
									'question_type' => 'l_fib', 
									'answer' => json_encode($userAnswerArr), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);

								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswer) * 5),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);
								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;

							case 'hiws':
								$originalAnswer = json_decode($rowlistening->answer,true);
								$originalAnswer = array_map(function($string) { return preg_replace('/\p{P}/', '', $string); }, $originalAnswer);
								$userAnswerArr = json_decode($response->answer);
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
									'question_id' => $response->question_id, 
									'question_type' => 'hiws', 
									'answer' => json_encode($userAnswerArr), 
									'score' => $score, 
									'suggestion' => $suggestion,
									'create_date' => date('Y-m-d h:i:s')
								);				
								$answer_id = $this->Iifl_info->insert('listening_answers',$data);
							
								$updateData = array(
									'status' => 1,
									'score' => $score,
									'points' => round($score / count($originalAnswer) * 6),
									'suggestion' => $suggestion,
									'answer_id' => $answer_id
								);

								$whereClause = array('mock_test_id' => $mockTestId, 'id' => $response->id);
								$this->Iifl_info->update('mock_test_answers',$updateData,$whereClause);

								break;
						}
						break;
					}
				}
			}
			} catch (Exception $e){}
		}
		$this->db->trans_complete();
		
		// var_dump($speaking);
		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
     	$data['data'] = $token;
    	echo json_encode($data);
    	exit;
	}


	
	public function myattempts(){
		$this->is_logged_in();
		$where = "pte_type = '".$this->session->userdata('pte_type')."'";
		$getMockTest = $this->Iifl_info->getdata('mock_test', $where);
		$this->data['getMockTest'] = $getMockTest;
		
		$getQuestionCategory = $this->Iifl_info->getdata('question_categories');
		$this->data['getQuestionCategory'] = $getQuestionCategory;

		$whereClause = " (status = 2 or status = 1 or status = 3) and user_id = ".$this->studentId." group by mock_test_id order by id desc";
		$getMockTestAnswers = $this->Iifl_info->selectresult('mock_test_answers',$whereClause);
		$this->data['getMockTestAnswers'] = $getMockTestAnswers;

		// echo '<pre>';var_dump($getMockTestAnswers);exit;
		$this->data['subview'] = "student/mocktest/myattempts";
		$this->data['active_bar'] = "myattempts";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function mocktestlist(){
		$this->is_logged_in();

		$where = "pte_type = '".$this->session->userdata('pte_type')."'";
		$getMockTest = $this->Iifl_info->getdata('mock_test', $where);
		$this->data['getMockTest'] = $getMockTest;
		
		$getQuestionCategory = $this->Iifl_info->getdata('question_categories');
		$this->data['getQuestionCategory'] = $getQuestionCategory;

		$whereClause = " (status = 2 or status = 1 or status = 3) and user_id = ".$this->studentId." group by mock_test_id order by id desc";
		$getMockTestAnswers = $this->Iifl_info->selectresult('mock_test_answers',$whereClause);
		$this->data['getMockTestAnswers'] = $getMockTestAnswers;

		// echo '<pre>';var_dump($getMockTestAnswers);exit;
		$this->data['subview'] = "student/mocktest/listmocktest";
		$this->data['active_bar'] = "mocktestlist";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function getlist(){
        
		$custom_order = "";
		$category = $_GET['category'];
		$sub_category = $_GET['sub_category'];
        $order = array('id' => 'ASC'); // default order 
        $column_search = array('test_type');
        $column_order = array(null,'id','title');
		$where_clause = array('test_type' => $category ,"pte_type" => $this->session->userdata('pte_type'));

		$applykartLogo = base_url("assets/images/apply-logo.svg");
		$ak_package = $this->package_model->get("", ['usage_type' => PACKAGE_APPLYKART, 'status' => 1]);
		
		// custom ordering
		$then = 0;
		$custom_order .= 'CASE';
		if ($this->session->userdata('studentTestIds')) {
			$custom_order .= ' WHEN id IN (' . $this->session->userdata('studentTestIds') . ') THEN ' . $then;
			$then++;
		}
		if ($ak_package) {
			$ak_test_ids = explode(",", $ak_package[0]['category_type_ids']);
			$custom_order .= ' WHEN id IN (' . join($ak_test_ids, ",") . ') THEN ' . $then;
			$then++;
		}
		$custom_order .= ' ELSE ' . $then . ' END,id ASC';

		// $whereIn = 'FIND_IN_SET(id, "'.$this->session->userdata('studentTestIds').'")';

		if(strlen($sub_category) > 0){
			$where_clause = array('test_type' => $category,'test_sub_type' => $sub_category ,"pte_type" => $this->session->userdata('pte_type'));
		}
		$getquestions = $this->Iifl_info->getRows($_GET,'mock_test',$column_search,$column_order,null,null,null,$where_clause,null,$custom_order); 
        // $getquestions = $this->Iifl_info->getdata('mock_test',$whereClause); 
		// echo '<pre>'; print_r($whereClause);exit;

        $data = $row = array();

        $i = $_GET['start'];
        
		$test = $this->session->userdata('studentTestIds');
		$testIds = explode(",",$test);

		// print_r($test);
        foreach($getquestions as $rowData){
            $i++;
			// print_r($test);
			// echo '<br/>';
			if(in_array($rowData->id,$testIds)){
				$btn = '<button class="btn btn-sm edit" onclick="taketest(' . $rowData->id . ');">Take Test</button>';
			}else{
				if(in_array($rowData->id, $ak_test_ids)){
					$btn = '<a href="javascript:void(0);" onClick="redeemcoupon();">Unlock with <img class="appylogo" src="'.$applykartLogo.'"/></a>';
				}else{
					$btn = '<a href="'.base_url('user/package').'"><i class="fa fa-lock"></i></a>';
				}
			}
            $row = array();

            $row[] = $i;
            $row[] = $rowData->title;

			$encoded_mock_id = urlencode($this->encryption->encrypt($rowData->id));
            $row[] = $btn;
            $data[] = $row;
        }
        $question_count = $this->Iifl_info->countAll('mock_test');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'mock_test',$column_search,$column_order,$order,null,null,$where_clause,null,$custom_order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

	public function mocktestresult($mockTestId){
		$this->is_logged_in();

		$this->data['gettype'] = 'speaking';

		$whereClause = array('mock_test_id' => $mockTestId, 'status' => 1, 'user_id' => $this->studentId);
		$getMockTestAnswers = $this->Iifl_info->getdata('mock_test_answers',$whereClause);
		$this->data['getMockTestAnswers'] = $getMockTestAnswers;
		
		$whereClause = array('id' => $getMockTestAnswers[0]->mock_series, "pte_type" => $this->session->userdata('pte_type'));
		$getMockTest = $this->Iifl_info->getdata('mock_test',$whereClause);
		
		$this->data['getMockTest'] = $getMockTest;

		// active tab
		$active_tab = 'speaking';
		$mock_test_type = $getMockTest[0]->test_type;

		if($mock_test_type == 'section-test' || stripos($mock_test_type, 'section')){
			$active_tab = $getMockTest[0]->test_sub_type;
		}
		
		if($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')){
			$mock_test_sub_type = $getMockTest[0]->test_sub_type;
			$sub_category_data = getCategoryDataByCode($mock_test_sub_type);
			$active_tab = $sub_category_data['category'];
		}

		$this->data['active_tab'] = $active_tab;
		// end

		// answers and response code
		if(strlen($getMockTest[0]->speaking) > 0){
			$whereClause = " id in (".$getMockTest[0]->speaking.") order by question_type desc";
			$speaking = $this->Iifl_info->selectresult('speaking_questions',$whereClause);
		}

		if(strlen($getMockTest[0]->writing) > 0){
			$whereClause = " id in (".$getMockTest[0]->writing.") order by question_type desc";
			$writing = $this->Iifl_info->selectresult('writing_questions',$whereClause);
		}

		if(strlen($getMockTest[0]->reading) > 0){
			$whereClause = " id in (".$getMockTest[0]->reading.") order by question_type desc";
			$reading = $this->Iifl_info->selectresult('reading_questions',$whereClause);
		}

		if(strlen($getMockTest[0]->listening) > 0){
			$whereClause = " id in (".$getMockTest[0]->listening.") order by question_type desc";
			$listening = $this->Iifl_info->selectresult('listening_questions',$whereClause);
		}

		$whereClause = array('mock_test_id' => $mockTestId);
		$getMockTestResult = $this->Iifl_info->getdata('mock_test_results',$whereClause);
		// end

		// setting chart data
		$chart_label = [];
		$chart_dataset = [];
		$chart_bgcolor = [];
		if(count($getMockTestResult) > 0){
			if($mock_test_type == 'full-test' || ($mock_test_type != 'full-test' && $active_tab == 'speaking')){
				$chart_label[] = ($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')) ? getCategoryDataByCode($getMockTest[0]->test_sub_type)['code_name'] : ucwords('speaking');
				$chart_dataset[] = $getMockTestResult[0]->speaking_score;
				$chart_bgcolor[] = get_section_color_code('speaking');
			}
			if($mock_test_type == 'full-test' || ($mock_test_type != 'full-test' && $active_tab == 'writing')){
				$chart_dataset[] =  $getMockTestResult[0]->writing_score;
				$chart_label[] = ($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')) ? getCategoryDataByCode($getMockTest[0]->test_sub_type)['code_name'] : ucwords('writing');
				$chart_bgcolor[] = get_section_color_code('writing');
			}
			if($mock_test_type == 'full-test' || ($mock_test_type != 'full-test' && $active_tab == 'reading')){
				$chart_dataset[] = $getMockTestResult[0]->reading_score;
				$chart_label[] = ($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')) ? getCategoryDataByCode($getMockTest[0]->test_sub_type)['code_name'] : ucwords('reading');
				$chart_bgcolor[] = get_section_color_code('reading');
			}
			if($mock_test_type == 'full-test' || ($mock_test_type != 'full-test' && $active_tab == 'listening')){
				$chart_dataset[] = $getMockTestResult[0]->listening_score;
				$chart_label[] = ($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')) ? getCategoryDataByCode($getMockTest[0]->test_sub_type)['code_name'] : ucwords('listening');
				$chart_bgcolor[] = get_section_color_code('listening');
			}
	
			$this->data['overall_score'] 	= $getMockTestResult[0]->overall_score;
			$this->data['max_bar_length']   = $mock_test_type == 'question-test' ? 100 : 90;

		}else{
			$insertData = array(
				'studentId' 	=> $this->studentId,
				'mock_series' 	=> $getMockTestAnswers[0]->mock_series,
				'mock_test_id' 	=> $mockTestId,
				'create_date' 	=> date('Y-m-d h:i:s')
			);
			
			if($mock_test_type == 'full-test'){
				$overall_scores = $this->getoverallscores($getMockTestAnswers);
				// echo '<pre>';var_dump( $overall_scores );exit;

				$chart_dataset[] 	= $overall_scores['speaking'];
				$chart_dataset[] 	= $overall_scores['writing'];
				$chart_dataset[] 	= $overall_scores['reading'];
				$chart_dataset[] 	= $overall_scores['listening'];
				$chart_label 		= array('Speaking','Writing','Reading','Listening');
				$chart_bgcolor 		= array_map('get_section_color_code',$chart_label);
				
				$insertData['overall_score'] 	= $this->data['overall_score'] = $overall_scores['overall'];
				$insertData['speaking_score'] 	= $overall_scores['speaking'];
				$insertData['writing_score'] 	= $overall_scores['writing'];
				$insertData['reading_score'] 	= $overall_scores['reading'];
				$insertData['listening_score'] 	= $overall_scores['listening'];
				$this->data['max_bar_length']   = $overall_scores['score_out_of'];
			}elseif($mock_test_type != 'full-test'){
				
				if($mock_test_type == 'section-test' || stripos($mock_test_type, 'section')){
					$overall_scores = $this->getsectionalscores($getMockTestAnswers, $mock_test_type, $active_tab);
					// echo '<pre>';var_dump( $overall_scores );exit;
				}
				
				if($mock_test_type == 'question-test' || stripos($mock_test_type, 'question')){
					$mock_test_sub_type = $getMockTest[0]->test_sub_type;
					$overall_scores = $this->getsectionalscores($getMockTestAnswers, $mock_test_type, $active_tab, $mock_test_sub_type);
					// echo '<pre>';var_dump( $overall_scores );exit;
				}
				
				$this->data['max_bar_length']   = $overall_scores['score_out_of'];

				switch($active_tab){
					case 'speaking':
						$insertData['speaking_score'] 	= $overall_scores['sectional_score'];
						$insertData['overall_score'] 	= $this->data['overall_score'] = $overall_scores['overall'];
						$chart_label[] 					= $overall_scores['chart_label'];
						$chart_dataset[] 				= $overall_scores['sectional_score'];
						$chart_bgcolor[] 				= get_section_color_code($active_tab);
						break;
					case 'writing':
						$insertData['writing_score'] 	= $overall_scores['sectional_score'];
						$insertData['overall_score'] 	= $this->data['overall_score'] = $overall_scores['overall'];
						$chart_label[] 					= $overall_scores['chart_label'];
						$chart_dataset[] 				= $overall_scores['sectional_score'];
						$chart_bgcolor[] 				= get_section_color_code($active_tab);
						break;
					case 'reading':
						$insertData['reading_score'] 	= $overall_scores['sectional_score'];
						$insertData['overall_score'] 	= $this->data['overall_score'] = $overall_scores['overall'];
						$chart_label[] 					= $overall_scores['chart_label'];
						$chart_dataset[] 				= $overall_scores['sectional_score'];
						$chart_bgcolor[] 				= get_section_color_code($active_tab);
						break;
					case 'listening':
						$insertData['listening_score'] 	= $overall_scores['sectional_score'];
						$insertData['overall_score'] 	= $this->data['overall_score'] = $overall_scores['overall'];
						$chart_label[] 					= $overall_scores['chart_label'];
						$chart_dataset[] 				= $overall_scores['sectional_score'];
						$chart_bgcolor[] 				= get_section_color_code($active_tab);
						break;
				}
			}

			$this->Iifl_info->insert('mock_test_results',$insertData);
		}
		// end

		$this->data['chart_label'] = $chart_label;
		$this->data['chart_dataset'] = $chart_dataset;
		$this->data['chart_bgcolor'] = $chart_bgcolor;
		$this->data['speaking'] = $speaking;
		$this->data['writing'] = $writing;
		$this->data['reading'] = $reading;
		$this->data['listening'] = $listening;
		$this->data['active_tab'] = $active_tab;

		
		$this->data['subview'] = "student/mocktest/mocktestresult";
		$this->load->view('layout/userlayout',$this->data);
	}

	public function getoverallscores($answers){

		$points_scored = array();
		
		foreach($answers as $data => $answer){
			$points_scored[$answer->question_type][] = $answer->points;
		}
		
		// echo '<pre>';print_r($points_scored);
		// $points_scored = array(
		// 	'repeat_sentences' => array(10,10,9,9,10,8,4,6,8,10),
		// 	'wfds' => array(10,10,9),
		// 	'fib_wr' => array(5,5,5,4,6),
		// 	'read_alouds' => array(10,12,9,8,6,12),
		// 	'ssts' => array(10,12),
		// 	'describe_images' => array(10,12,13,14,12,11),
		// 	'retell_lectures' => array(10,12,13),
		// 	'swtx' => array(5,7),
		// 	'hiws' => array(5,6),
		// 	'fib_rd' => array(5,5,4,5),
		// 	'l_fib' => array(5,5),
		// 	'essays' => array(13),
		// 	'answer_questions' => array(1,1,1,1,0,1,0,0,1,1),
		// 	'ro' => array(3,4),
		// 	'r_mcm' => array(2,2),
		// 	'l_hcs' => array(1,1),
		// 	'l_mcm' => array(1,2),
		// 	'r_mcs' => array(1,1),
		// 	'l_mcs' => array(1,1),
		// 	'l_smw' => array(1,1),
		// );

		$individual_task_scoring_data = $this->Iifl_info->getdata('individual_task_scoring');
		$task_data_arr = array();

		foreach($individual_task_scoring_data as $types => $rowtask){
			$task_data_arr[$rowtask->tasks_code] = $rowtask;
		}

		$speaking = 0;
		$reading = 0;
		$writing = 0;
		$listening = 0;
		$score = [];
		$sub_category_wise_total_score = array();
		foreach($this->all_test_types as $types => $row_type){

			//  task wise category score = (average points scored * category score) / per category points
			$per_task_speaking 	= $points_scored[$row_type] != null ? ((array_sum($points_scored[$row_type]) / count($points_scored[$row_type])) * $task_data_arr[$row_type]->speaking) / $task_data_arr[$row_type]->points : 0;
			$per_task_reading 	= $points_scored[$row_type] != null ? ((array_sum($points_scored[$row_type]) / count($points_scored[$row_type])) * $task_data_arr[$row_type]->reading) / $task_data_arr[$row_type]->points : 0;
			$per_task_writing 	= $points_scored[$row_type] != null ? ((array_sum($points_scored[$row_type]) / count($points_scored[$row_type])) * $task_data_arr[$row_type]->writing) / $task_data_arr[$row_type]->points : 0;
			$per_task_listening = $points_scored[$row_type] != null ? ((array_sum($points_scored[$row_type]) / count($points_scored[$row_type])) * $task_data_arr[$row_type]->listening) / $task_data_arr[$row_type]->points : 0;

			// category total = task wise category score
			$speaking 	+= $per_task_speaking;
			$reading 	+= $per_task_reading;
			$writing 	+= $per_task_writing;
			$listening 	+= $per_task_listening;
			// end

			$sub_category_wise_total_score[$row_type] = $per_task_speaking + $per_task_listening + $per_task_writing + $per_task_reading;
		}

		// change by abhishek only for speaking and listening just add 6 and 5 respectively rather than actual approach like others | 16-Apr-24
		// change by lacolm only for reading just add 8 rather than actual approach like others | 20-Sep-24
		$speaking += 6;
		$listening += 5;
		$reading += 8;

		$score['speaking'] 	= round(($speaking 	> 10 ? $speaking : 10));
		$score['writing'] 	= round(($writing 	> 10 ? $writing : 10));
		$score['reading'] 	= round(($reading 	> 10 ? $reading : 10));
		$score['listening']	= round(($listening > 10 ? $listening : 10));

		return array(
			'speaking' 						=> $score['speaking'], 
			'writing' 						=> $score['writing'], 
			'reading'						=> $score['reading'], 
			'listening' 					=> $score['listening'], 
			'overall' 						=> array_sum($score) / count($score), 
			'sub_category_wise_total_score' => $sub_category_wise_total_score, 
			'sub_category_total_score' 		=> array_sum($sub_category_wise_total_score),
			'score_out_of' 					=> 90
		);
	}
	
	public function getsectionalscores($answers, $type = "", $category = "", $sub_category = ""){

		$points_scored = array();
		
		foreach($answers as $data => $answer){
			$points_scored[$answer->question_type][] = $answer->points;
		}

		$individual_task_scoring_data = $this->Iifl_info->getdata('individual_task_scoring');
		$task_data_arr = array();

		foreach($individual_task_scoring_data as $types => $rowtask){
			$task_data_arr[$rowtask->tasks_code] = $rowtask;
		}

		$sectional_score = 0;
		$sub_category_wise_total_score = array();
		$section_actual_total = 0;
		if(($type == 'section-test' || stripos($type, 'section')) && strlen($category) > 0){
			$section_test_types = get_category_sub_categories($category);
			foreach($section_test_types as $types => $row_type){
				//  task wise category score = (average points scored * category score) / per category points
				$per_task_category = $points_scored[$row_type] != null ? ((array_sum($points_scored[$row_type]) / count($points_scored[$row_type])) * $task_data_arr[$row_type]->$category) / $task_data_arr[$row_type]->points : 0;

				// category total = task wise category score
				$sectional_score += $per_task_category;
				// end

				$sub_category_wise_total_score[$row_type] = $per_task_category;

				// category actual total
				$section_actual_total += $task_data_arr[$row_type]->$category;
				// end
			}

			// // change by abhishek only for reading just add 42.7 rather than actual approach like others | 05-Feb-24
			// if($category == 'reading'){
			// 	$score = round($sectional_score) + 42.7;
			// }elseif($category == 'speaking'){
			// 	// change by abhishek only for speaking and listening just add 6 and 5 respectively rather than actual approach like others | 16-Apr-24
			// 	$score = round($sectional_score) + 6;
			// }elseif($category == 'listening'){
			// 	// change by abhishek only for speaking and listening just add 6 and 5 respectively rather than actual approach like others | 16-Apr-24
			// 	$score = round($sectional_score) + 5;
			// }else{
			// 	$score = round($sectional_score > 0 ? ($sectional_score / $section_actual_total) * 90 : 10);
			// }

			// change by abhishek just add $section_actual_total rather than actual approach like previously | 24-June-24
			$score = round($sectional_score) + (90 - $section_actual_total);
		}elseif(($type == 'question-test' || stripos($type, 'question')) && strlen($category) > 0 &&  strlen($sub_category) > 0){
			//  task wise category score = (average points scored * category score) / per category points
			$per_task_category = $points_scored[$sub_category] != null ? ((array_sum($points_scored[$sub_category]) / count($points_scored[$sub_category])) * $task_data_arr[$sub_category]->$category) / $task_data_arr[$sub_category]->points : 0;

			// category total = task wise category score
			$sectional_score += $per_task_category;
			// end

			$sub_category_wise_total_score[$sub_category] = $per_task_category;

			// category actual total
			$section_actual_total += $task_data_arr[$sub_category]->$category;
			// end

			// change by abhishek only for reading just add 42.7 rather than actual approach like others
			if($category == 'reading'){
				$score = round($sectional_score) + 52.7;
			}else{
				$score = round($sectional_score > 0 ? ($sectional_score / $section_actual_total) * 100 : 10);
			}
		}

		return array(
			'sectional_score' 			=> $score, 
			'sub_category_wise_total' 	=> $sub_category_wise_total_score, 
			'sub_category_total' 		=> array_sum($sub_category_wise_total_score),
			'overall' 					=> $score,
			'chart_label'			 	=> ($type == 'section-test' || stripos($type, 'section')) ? ucwords($category) : getCategoryDataByCode($sub_category)['code_name'],
			'score_out_of'			 	=> ($type == 'section-test' || stripos($type, 'section')) ? 90 : 100
		);
	}

	public function checkpurchaseattempt($mockseries){
		// $mockseries = $this->encryption->decrypt(urldecode($mockseries));

		$status = 1;

		$student_packages = getStudentPackagePurchasesNotExpired($this->studentId, true);
		$package_data = $this->Iifl_info->selectresult('packages','packageid IN ('.implode(',',$student_packages).') AND FIND_IN_SET('.$mockseries.', category_type_ids) > 0');
		// echo $this->db->last_query();
		// echo '<pre>';var_dump($package_data);
	
		if($package_data && count($package_data) > 0){
			$unlimited = false;
			$limit = 1;

			foreach ($package_data as $key => $package) {
				if($package->attempt_limit == 0){
					$unlimited = true;
					break;
				}
				if($package->attempt_limit > $limit){
					$limit = $package->attempt_limit;
				}
			}

			if($unlimited){
				$status = 0;
			}else{
				$whereClause = " (status = 2 or status = 1 or status = 3) and user_id = ".$this->studentId." group by mock_test_id order by id desc";
				$user_mock_test_attempts = $this->Iifl_info->selectresult('mock_test_answers',$whereClause);

				if($user_mock_test_attempts && count($user_mock_test_attempts) >= $limit){
					$status = 1;
				}else{
					$status = 0;
				}
			}
		}
		$token = $this->security->get_csrf_hash();
     	$data['token'] = $token;
     	$data['status'] = $status;
     	$data['credit_remaining'] = $limit - count($user_mock_test_attempts);
    	echo json_encode($data);
    	exit;
	}

	private function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    } //end
}