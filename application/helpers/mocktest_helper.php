<?php
defined('BASEPATH') or exit('No direct script access allowed');

function mark_mock_as_completed($mocktestid, $mockseries, $studentId, $student_name = "")
{
    if (!$mocktestid || !$mockseries || !$studentId)
        return false;

    $CI = &get_instance();
    $CI->load->library('user_agent');
    $CI->load->model('Iifl_info');

    $whereClause = array(
        'mock_test_id' => $mocktestid,
        'mock_series' => $mockseries,
        'user_id' => $studentId
    );
    $updateData = array(
        'status' => 2,
        'update_date' => date('Y-m-d h:i:s'),
        'saved' => 1
    );

    $log_data = array(
        "studentId" => $studentId,
        "student_name" => strlen($student_name) != 0 ? $student_name : "MOCKMASTER_SYSTEM",
        "mock_series" => $mockseries,
        "mock_test_id" => $mocktestid,
        "user_agent" => $_SERVER['HTTP_USER_AGENT'],
        "browser" => $CI->agent->browser(),
        "platform" => $CI->agent->platform(),
        'create_date' => date('Y-m-d h:i:s')
    );

    try {
        $log_data["meta_status"] = "COMPLETED";
        $CI->Iifl_info->update('mock_test_answers', $updateData, $whereClause);
        $CI->Iifl_info->insert('mock_test_logs', $log_data);
    } catch (Exception $e) {
        $log_data["meta_status"] = "ERROR";
        $log_data["description"] = $e->getMessage();
        $CI->Iifl_info->insert('mock_test_logs', $log_data);
    }

    return true;
}