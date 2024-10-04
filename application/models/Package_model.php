<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Package_model extends CI_Model
{
    public function get($id = '', $where = [])
    {
        $this->db->where($where);

        if (is_numeric($id)) {
            $this->db->where('packageid', $id);
            $package = $this->db->get('packages')->row();
            return $package;
        }
        $this->db->order_by('package_name', 'desc');

        return $this->db->get('packages')->result_array();
    }
}
