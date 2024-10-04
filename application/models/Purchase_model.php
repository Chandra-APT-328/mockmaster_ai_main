<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_model extends CI_Model
{
    public function get($id = '', $where = [])
    {
        $this->db->where($where);

        if (is_numeric($id)) {
            $this->db->where('purchaseid', $id);
            $package = $this->db->get('purchases')->row();
            return $package;
        }
        $this->db->order_by('purchaseid', 'desc');

        return $this->db->get('purchases')->result_array();
    }

    public function create($data)
    {
        $this->db->insert('purchases', array_merge($data, [
            'create_date'      => date('Y-m-d H:i:s'),
        ]));

        log_activity("New Purchase. Student:[" . $data['studentid'] . "] Package:[". $data['product'] ."]");

        return $this->db->insert_id();
    }
}
