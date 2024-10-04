<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->library('encryption');
		$this->load->helper('security');
        
        $this->studentId = false;
        if($this->session->userdata('studentId')){
            $studentId = $this->session->userdata('studentId');
            $this->studentId =  $this->encryption->decrypt($studentId);
        }
    }

	public function add(){
        if ($this->input->post() && $this->studentId) {
            if(strlen($this->input->post('feedback')) > 0){
                $insertdata = array(
					'user_id' => $this->studentId,
					'question_type' => $this->input->post('category') ? $this->input->post('category') : null,
					'question_id' => $this->input->post('questionid') ? $this->input->post('questionid') : null,
					'feedback' => $this->input->post('feedback'),
					'create_date' => date('Y-m-d h:i:s')
				);
				$insertdata = $this->security->xss_clean($insertdata);
				if($this->security->xss_clean($insertdata)){
					$this->Iifl_info->insert('feedbacks',$insertdata);
                }
            }
        }
        
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
        exit;
	}

	public function list() {

		$order = array('create_date' => 'desc'); // default order 
        $column_search = array('id','feedback','question_type');
        $column_order = array(null,'user_id','feedback','question_type','create_date');
		
        $feedbacks = $this->Iifl_info->getRows($_GET,'feedbacks',$column_search,$column_order,$order); 
		$studentList = $this->Iifl_info->getdata('studentuser');

		$studentNameArr = array();
		foreach ($studentList as $key => $row) {
			$studentNameArr[$row->studentId] = ucwords($row->first_name . ' ' . $row->last_name);
		}

		$category_data = $this->Iifl_info->getdata('question_categories');
		$categoriesArr = array();
	
		foreach ($category_data as $key => $rowCategories) {
			$categoriesArr[$rowCategories->question_code] = $rowCategories;
		}

        $data = array();

        $i = 0;
        foreach($feedbacks as $key => $rowData){
            $i++;
            $row = array();

            $row[] = $i;
            $row[] = '<a href="' . base_url('admin/student/' . $rowData->user_id) . '" style="text-decoration: none;"><span class="text-primary">' . $studentNameArr[$rowData->user_id] . '</span></a>';

			$row[] = $rowData->feedback;


			$_category_page = "";
			if($categoriesArr[$rowData->question_type]->question_category == "Listening" || $categoriesArr[$rowData->question_type]->question_category == "listening"){
				$_category_page = "addlisteningquestions";
			}
			if($categoriesArr[$rowData->question_type]->question_category == "Writing" || $categoriesArr[$rowData->question_type]->question_category == "writing"){
				$_category_page = "addwritingquestions";
			}
			if($categoriesArr[$rowData->question_type]->question_category == "Reading" || $categoriesArr[$rowData->question_type]->question_category == "reading"){
				$_category_page = "addreadingquestions";
			}
			if($categoriesArr[$rowData->question_type]->question_category == "Speaking" || $categoriesArr[$rowData->question_type]->question_category == "speaking"){
				$_category_page = "addspeakingquestions";
			}

			$row[] = '<a href="' . base_url('admin/'.$_category_page.'/' . $rowData->question_id) . '" style="text-decoration: none;"><span class="text-primary">' . ucwords($categoriesArr[$rowData->question_type]->type_name) . '</span></a>';
			
            $created_on = new DateTime($rowData->create_date);
			$row[] = $created_on->format("M d, Y g:i A");
			$data[] = $row;		
        }
		
        $question_count = $this->Iifl_info->countAll('feedbacks');

        $output = array(
            "draw" => $_GET['draw'],
            "recordsTotal" => $question_count,
            "recordsFiltered" => $this->Iifl_info->countFiltered($_GET,'feedbacks',$column_search,$column_order,$order),
            "data" => $data,
            "question_count" => $question_count
        );

        // Output to JSON format
        echo json_encode($output);
    }

}
