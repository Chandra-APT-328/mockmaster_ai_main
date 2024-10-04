<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->library('encryption');
		$this->load->helper('security');
    }

    public function getmocktests(){

		$this->is_logged_in();

		$selectedValue = $_POST['selectedValue'];
		$selectedValue = join(",",$selectedValue);
		
		// $whereclause = array('test_type'=>$selectedValue);
		$whereclause = 'FIND_IN_SET(test_type, "'.$selectedValue.'")';
		// var_dump($whereclause); exit;
		$result = $this->Iifl_info->getdata('mock_test',[],[],"","",$whereclause); 

		// var_dump($this->db->last_query());
		// exit;
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		$data['result'] = $result;
		echo json_encode($data);
        exit;
	}

	public function createPackage($id = ""){
		
		$this->is_logged_in();
        if(strlen($id) > 0){
			$whereClause = array('packageid' => $id);
			$getpackage = $this->Iifl_info->getdata('packages',$whereClause);
			$this->data['getpackage'] = $getpackage;
        }

		$this->data['active_bar'] = "createPackage";
        $this->data['subview'] = "package/addPackage";
		$this->load->view('layout/adminlayout',$this->data);
	}

    private function is_logged_in() {
		if (!$this->session->userdata('authId')) {
			redirect(base_url().'admin/signin');
		}
		return true;
	}
	public function storePackage(){
		
		$this->is_logged_in();

        // var_dump($this->input->post());exit;
        $packageid = $this->input->post('packageid');
        $package_name = $this->input->post('package_name');
		$pte_type = $this->input->post('pteType');
        $cost = $this->input->post('cost');
        $duration = $this->input->post('duration');
        $duration_type = $this->input->post('duration_type');
        $package_category = $this->input->post('package_category');
        $usage_type = $this->input->post('usage_type');
        $is_purchaseable = $this->input->post('is_purchaseable');
        $show_videos = $this->input->post('show_videos');
        $addon_language = $this->input->post('addon_language');
        $show_materials = $this->input->post('show_materials');
        $show_class_links = $this->input->post('show_class_links');
        $desc = $this->input->post('desc');
        $attempt_limit = $this->input->post('attempt_limit');
        $category_type_ids = $this->input->post('category_type_ids');
		$authId =$this->encryption->decrypt($this->session->userdata('authId'));

        $insertdata = array(
            // 'packageid ' => $this->packageid ,
            'package_name' => $package_name,
			'pte_type' => $pte_type,
            'cost' => $cost,
            'duration' => $duration,
            'duration_type' => $duration_type,
            'package_category' => implode(",", $package_category),
            'usage_type' => $usage_type,
            'is_purchaseable' => $is_purchaseable,
            'show_videos' => $show_videos,
            'addon_language' => $addon_language,
            'show_materials' => $show_materials,
            'show_class_links' => $show_class_links,
            'description' => $desc,
            'attempt_limit' => $attempt_limit,
            'category_type_ids' => implode(",", $category_type_ids),
            'created_on' => date('Y-m-d H:i:s'),
			'created_by' => $authId
        );
		if($packageid != ''){
			$updatedata = array(
				 'packageid ' => $packageid ,
				'package_name' => $package_name,
				'cost' => $cost,
				'duration' => $duration,
            	'duration_type' => $duration_type,
				'package_category' => implode(",", $package_category),
				'usage_type' => $usage_type,
				'is_purchaseable' => $is_purchaseable,
				'show_videos' => $show_videos,
				'addon_language' => $addon_language,
				'show_materials' => $show_materials,
				'show_class_links' => $show_class_links,
				'description' => $desc,
				'attempt_limit' => $attempt_limit,
				'category_type_ids' => implode(",", $category_type_ids),
				'last_updated' => date('Y-m-d H:i:s')
			);
			
            $whereclause = array('packageid'=>$packageid);
			$this->Iifl_info->update('packages',$updatedata,$whereclause);
		}else{

			$insertdata = $this->security->xss_clean($insertdata);
			$this->Iifl_info->insert('packages',$insertdata);
			// $a = $this->db->last_query();
			// print_r($a);
			// exit;
		}
        $this->session->set_userdata('success','Submited');
        redirect(base_url().'package/createPackage');
	}

	public function listPackage(){
		
		$this->is_logged_in();

        $getpackage = $this->Iifl_info->getdata('packages');
		$this->data['getpackage'] = $getpackage;

		$this->data['active_bar'] = "listPackage";
        $this->data['subview'] = "package/listPackage";
		$this->load->view('layout/adminlayout',$this->data);
	}

    public function deletePackage(){

		$this->is_logged_in();

		$packageId = $_POST['package'];

		$whereClause = array('packageId' => $packageId);
    	$this->Iifl_info->delete('packages',$whereClause);

		$data = array(        
			'deletedPackageId' => $packageId,
		  );
		echo json_encode($data);
	  }

	  public function toggle(){

		$this->is_logged_in();
		
		$selectedId = $_POST['packageid'];
		if(strlen($selectedId) > 0){
			$whereClause = array('packageid' => $selectedId);
			$getpackage = $this->Iifl_info->getdata('packages',$whereClause);
			$updatedata = array( 'status ' => $getpackage[0]->status == 1 ? 0 : 1);
			$this->Iifl_info->update('packages',$updatedata,$whereClause);
        }
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	  }

	public function purchase($packageid){
		
		$this->load->library('stripe');

		$getpackage = $this->Iifl_info->getdata('packages',array('packageid' => $packageid,'status'=>1));
		$amount = $getpackage[0]->cost.'00';
		$priceId = $this->stripe->create_price(PRODUCT_ID,$amount,STRIPE_CURRENCY);

		if($priceId->id){
			$data['result'] = $sessionid = $this->stripe->checkout($priceId->id, 1);
			$studentId = $this->session->userdata('studentId');
     		$studentId =  $this->encryption->decrypt($studentId);
			if($sessionid){
				$insertData= array(
					'productid' 		=> 	$packageid,
					'product' 			=> 	$getpackage[0]->package_name,
					'stripe_sessionid' 	=>	$sessionid,
					'stripe_productid'	=> 	PRODUCT_ID,
					'stripe_priceid'	=> 	$priceId->id,
					'status'			=> 	0,
					'amount'			=> 	$getpackage[0]->cost,
					'buyerid'			=> 	$studentId,
					'create_date' 		=> 	date('Y-m-d h:i:s')
				);
				$this->Iifl_info->insert('payments',$insertData);
			}
		}
		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}

	public function success($session_id){

		$this->load->library('stripe');
		$status = $this->stripe->paymentstatus($session_id);

		if($status == "paid"){
			$updatestatus = array('status' =>  1,'last_updated' => date('Y-m-d h:i:s'));
			$whereclause = array('stripe_sessionid' => $session_id);
			$this->Iifl_info->update('payments',$updatestatus,$whereclause);

			$getpayment = $this->Iifl_info->getdata('payments',$whereclause);
			$getpackage = $this->Iifl_info->getdata('packages',array('packageid' => $getpayment[0]->productid));

			$studentId = $this->session->userdata('studentId');
     		$studentId =  $this->encryption->decrypt($studentId);

			$package_validity = $getpackage[0]->duration . " " . $getpackage[0]->duration_type . "s";
			$expire_on = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $package_validity));

			$insertData= array(
				'paymentid' 		=> 	$getpayment[0]->id,
				'product' 			=> 	$getpayment[0]->product,
				'productid' 		=> 	$getpayment[0]->productid,
				'studentid'			=> 	$studentId,
				'expire_date'		=> 	$expire_on,
				'create_date' 		=> 	date('Y-m-d h:i:s')
			);
			$this->Iifl_info->insert('purchases',$insertData);

			// updating account validity if purchased package expiry is greater than account validity
			extendAccountValidityWithPackageExpiry($studentId, $expire_on, true);

			$start_date = new DateTime(date('Y-m-d h:i:s'));
			$expiry_date = new DateTime($expire_on);

			$mail_data = array(
				'student_name' 		=> ucwords(trim(strtolower($this->session->userdata('name')))), 
				'package_name' 		=> $getpayment[0]->product,
				'package_duration' 	=> $package_validity,
				'cost' 				=> $getpackage[0]->cost,
				'start_date' 		=> $start_date->format("M d, Y g:i A"),
				'expiry_date' 		=> $expiry_date->format("M d, Y g:i A"),
				'email_signature' 	=> MAIL_SIGNATURE
			);
			send_package_purchase_success_mail($this->encryption->decrypt($this->session->userdata('email')), $mail_data);

			$this->session->set_userdata('success','Payment Successful');
			redirect(base_url().'user/package');
		}
		$this->session->set_userdata('error','Something bad occured');
		redirect(base_url().'user/package');
    }
		
	  public function cancel(){
		$this->session->set_userdata('error','Payment Unsuccessful');
		redirect(base_url().'user/package');
	  }

	  public function checkedpackagestatus(){
		$packageId = $_POST['package'];
		$status = $_POST['status'];

		$whereclause = array('packageid'=>$packageId);
		$this->Iifl_info->update('packages',array('status' => $status),$whereclause); 

		$token = $this->security->get_csrf_hash();
		$data['token'] = $token;
		echo json_encode($data);
		exit;
	}
}