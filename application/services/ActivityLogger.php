<?php

namespace App\Services;

defined('BASEPATH') or exit('No direct script access allowed');

class ActivityLogger
{
    public static function log($description)
    {
        $CI  = & get_instance();
        $log = [
        'description' => $description,
        'date'        => date('Y-m-d H:i:s'),
        ];
        
        if(get_user_full_name()){
            $log['userid'] = get_user_full_name();
        }else{
            $log['userid'] = "[SYSTEM]";
        }

        $CI->db->insert('activity_log', $log);
    }

    public static function getLast()
    {
        $CI = &get_instance();
        $CI->db->select('id');
        $CI->db->order_by('id', 'desc');
        $CI->db->limit(1);

        return $CI->db->get('activity_log')->row();
    }
}
