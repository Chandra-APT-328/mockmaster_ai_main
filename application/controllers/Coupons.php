<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Coupons extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Iifl_info');
        $this->load->library('encryption');
        $this->load->helper('security');
    }

    private function is_student_logged_in()
    {
        if (!$this->session->userdata('studentId')) {
            redirect(base_url() . 'user/signin');
        }
        return true;
    }

    public function redeem()
    {
        $this->is_student_logged_in();

        $studentId = $this->session->userdata('studentId');
        $studentId =  $this->encryption->decrypt($studentId);

        $coupon_code = $_POST['coupon'];
        $response = ["success" => false];

        if(strlen($coupon_code) == 0){
            $response["success"] = false;
            $response["msg"] = "Coupon is required";
        }else{
            if(is_coupon_exists($coupon_code, $studentId)){
                if(is_coupon_used($coupon_code)) {
                    $response["success"] = false;
                    $response["msg"] = "Coupon already used";
                } else {
                    $success = assign_applykart_package_to_student($studentId, $coupon_code);
                    $response["success"] = $success;
                }
            }else{
                $response["success"] = false;
                $response["msg"] = "Invalid coupon";
            }
        }

        $token = $this->security->get_csrf_hash();
        $response['token'] = $token;
        die(json_encode($response));
    }
}