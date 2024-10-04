<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Get option value
 * @param  string $name Option name
 * @return mixed
 */
function get_option($name)
{
    $val = '';
    $name = trim($name);
    $CI = &get_instance();

    // is not auto loaded
    $CI->db->select('value');
    $CI->db->where('name', $name);
    $row = $CI->db->get('options')->row();
    if ($row) {
        return $row->value;
    }

    return false;
}

if (!function_exists('get_user_device')) {
    function get_user_device(){
        $CI = &get_instance();
        $CI->load->library('user_agent');
        return $CI->agent->browser();
    }
}