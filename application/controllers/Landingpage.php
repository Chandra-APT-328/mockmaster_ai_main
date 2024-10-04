<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Landingpage extends CI_Controller { 
    public function __construct() {
        parent::__construct();
    }

    public function reading_mock_test(){
		$this->load->view('layout/reading_mock_test');
	}
    public function listening_mock_test(){
		$this->load->view('layout/listening_mock_test');
	}
    public function speaking_mock_test(){
		$this->load->view('layout/speaking_mock_test');
	}
    public function writing_mock_test(){
		$this->load->view('layout/writing_mock_test');
	}
    public function free_pte_mock_test(){
		$this->load->view('layout/free_pte_mock_test');
	}
}