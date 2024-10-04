<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{
    public function get($id = '', $where = [])
    {
        $select_str = '*,CONCAT(first_name,\' \',last_name) as full_name';

        $this->db->select($select_str);
        $this->db->where($where);

        if (is_numeric($id)) {
            $this->db->where('studentid', $id);
            $student = $this->db->get('studentuser')->row();

            return $student;
        }
        $this->db->order_by('first_name', 'asc');

        return $this->db->get('studentuser')->result_array();
    }

    public function update($data, $id)
    {
        $affectedRows = 0;

        $this->db->where('studentId', $id);
        $this->db->update('studentuser', $data);

        if ($this->db->affected_rows() > 0) {
            $affectedRows++;
        }


        if ($affectedRows > 0) {
            return true;
        }

        return false;
    }
}
