<?php

defined('BASEPATH') or exit('No direct script access allowed');

function getUserPackagesWithExpireDate($studentId){

    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $packages = [];
    if($studentId){
        $getUserPackages = $CI->Iifl_info->getdata('purchases', array('studentid' => $studentId));
		
        foreach($getUserPackages as $key => $package){
            $packages[$package->productid] = $package->expire_date;
        }
    }
    return $packages;
}

function extendAccountValidityWithPackageExpiry($studentid, $package_expiry, $update_session = false){
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $where = array('studentId' => $studentid);
    $student_data = $CI->Iifl_info->getdata('studentuser', $where);

    if($student_data && count($student_data) > 0){
        if($package_expiry > date('Y-m-d h:i:s', strtotime($student_data[0]->validity))){
            $update_data = array('validity' => $package_expiry);
            $where = array('studentId' => $studentid);
            $CI->Iifl_info->update('studentuser', $update_data, $where);

            if($update_session){
                $CI->load->library('session');
                $validity = new DateTime($package_expiry);
                $CI->session->set_userdata('validity', $validity->format("d M Y"));
            }
        }
    }

    return true;
}

function get_package_expiry($package){
    if ($package && count($package) == 0) return false;

    $package_validity = $package[0]->duration . " " . $package[0]->duration_type . "s";
    $expire_on = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $package_validity));
    return $expire_on;
}