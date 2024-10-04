<?php 
defined('BASEPATH') or exit('No direct script access allowed');

function generate_coupon_code($length = 7) {
    // Define the characters to be used in the coupon code
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charactersLength = strlen($characters);
    $couponCode = '';

    // Loop to generate a random string of the desired length
    for ($i = 0; $i < $length; $i++) {
        $couponCode .= $characters[rand(0, $charactersLength - 1)];
    }

    return $couponCode;
}

function is_coupon_exists($coupon, $studentid = ""){
    $CI = &get_instance();

    $CI->load->model('student_model');
    $used_codes = $CI->student_model->get($studentid, ["ak_coupon_code" => $coupon]);
    
    if(count($used_codes) != 0){
        return true;
    }

    return false;
}

function is_coupon_used($coupon){

    if(strlen($coupon) == 0) return false;
    
    $CI = &get_instance();

    $CI->db->where('coupon_code', $coupon);
    $usage = $CI->db->get('coupon_usage')->row();
    
    if(count($usage) != 0){
        return true;
    }

    return false;
}

function get_new_coupon_applykart(){

    $couponCode = generate_coupon_code();

    if(is_coupon_exists($couponCode)){
        return get_new_coupon_applykart();
    }else{
        return $couponCode;
    }
}