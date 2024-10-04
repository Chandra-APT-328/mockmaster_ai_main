<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_Autologin extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Check if autologin found
     * @param  mixed $user_id studentid
     * @param  string $key     key from cookie to retrieve from database
     * @return mixed
     */
    public function get($user_id, $key)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('key_id', $key);
        $user = $this->db->get('user_auto_login')->row();
        if (!$user) {
            return null;
        }
        $table = 'studentuser';
        $this->db->select($table . '.studentId as id');
        $this->db->from($table);
        $this->db->join('user_auto_login', 'user_auto_login.user_id = ' . $table . '.studentId');
        $this->db->where('user_auto_login.user_id', $user_id);
        $this->db->where('user_auto_login.key_id', $key);
        $query = $this->db->get();
        if ($query) {
            if ($query->num_rows() == 1) {
                $user        = $query->row();

                return $user;
            }
        }

        return null;
    }

    /**
     * Set new autologin if user have clicked remember me
     * @param mixed $user_id userid
     * @param string $key     cookie key
     */
    public function set($user_id, $key)
    {
        return $this->db->insert('user_auto_login', [
            'user_id'    => $user_id,
            'key_id'     => $key,
            'user_agent' => substr($this->input->user_agent(), 0, 149),
            'last_ip'    => $this->input->ip_address()
        ]);
    }

    /**
     * Delete user autologin
     * @param  mixed $user_id userid
     * @param  string $key     cookie key
     */
    public function delete($user_id, $key)
    {
        $this->db->where('user_id', $user_id);
        $this->db->where('key_id', $key);
        $this->db->delete('user_auto_login');
    }
}
