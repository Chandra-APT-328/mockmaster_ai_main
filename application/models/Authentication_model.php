<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Authentication_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_autologin');
        $this->load->library('session');
		$this->load->helper('url');
		$this->load->model('Iifl_info');
		$this->load->library('encryption');
		$this->load->helper('security');
        $this->autologin();
    }

    private function is_logged_in() {
        return $this->session->has_userdata('studentId');
	}

    /**
     * @param  string Email address for login
     * @param  string User Password
     * @param  boolean Set cookies for user if remember me is checked
     * @return boolean if not redirect url found, if found redirect to the url
     */
    public function login($email, $password, $remember)
    {
        if ((!empty($email)) and (!empty($password))) {

            $whereclause = array('email'=>$email, 'auth_password'=>md5($password));
			$result = $this->Iifl_info->getdata('studentuser',$whereclause);
            if(count($result) == 1){
				if($result[0]->status == 0){
					$this->session->set_userdata('error','Account Expired: Contact Institute');
					return false;
				}else{
					if(isAccountExpired($result[0]->studentId, $result[0]->validity)){
						$expired_on = new DateTime($result[0]->validity);
						$this->session->set_userdata('error','Your account got expired on ' . $expired_on->format("M d, Y g:i A"));
						return false;
					} else{
						$first_name =$this->encryption->encrypt($result[0]->first_name);
						$last_name =$this->encryption->encrypt($result[0]->last_name);
						$studentId =$this->encryption->encrypt($result[0]->studentId);
						$email =$this->encryption->encrypt($result[0]->email);
		
						$studentTests = get_test_and_video_by_studentid($result[0]->studentId, true, true);
						$studentTestIds = join(",",$studentTests['testIds']);
						$validity = new DateTime($result[0]->validity);
		
						$data = array(
							'name' => $result[0]->first_name.' '.$result[0]->last_name,
							'studentId' => $studentId,
							'email' =>$email,
							'profile_picture' => strlen($result[0]->profile_picture) > 0 ? $result[0]->profile_picture : false,
							'studentlogged' => true,
							'lastLogin'=>$result[0]->last_login,
							'studentTestIds'=>$studentTestIds,
							'show_videos'=>$studentTests['show_videos'],
							'show_materials'=>$studentTests['show_materials'],
							'show_class_links'=>$studentTests['show_class_links'],
							'validity'=> $validity->format("d M Y"),
							'actual_validity'=> $result[0]->validity,
							'profile_completed'=> $result[0]->profile_completed
						);
					
						$this->session->set_userdata($data);
					}
				}
				
			}else{
				$this->session->set_userdata('error','Invalid email or password.');
				return false;
			}

            if ($remember) {
                $this->create_autologin($result[0]->studentId);
            }

            $this->update_login_info($result[0]->studentId);

            return true;
        }

        return false;
    }

    /**
     * @param  string Email address for login
     * @param  boolean Set cookies for user if remember me is checked
     * @return boolean if not redirect url found, if found redirect to the url
     */
    public function google_auth_login($email, $remember)
    {
        if (!empty($email)) {
            $whereclause = array('email'=>$email);
			$result = $this->Iifl_info->getdata('studentuser',$whereclause);
            if(count($result) == 1){
				if($result[0]->status == 0){
					$this->session->set_userdata('error','Account Expired: Contact Institute');
					return false;
				}else{
					if(isAccountExpired($result[0]->studentId, $result[0]->validity)){
						$expired_on = new DateTime($result[0]->validity);
						$this->session->set_userdata('error','Your account got expired on ' . $expired_on->format("M d, Y g:i A"));
						return false;
					} else{
						$first_name =$this->encryption->encrypt($result[0]->first_name);
						$last_name =$this->encryption->encrypt($result[0]->last_name);
						$studentId =$this->encryption->encrypt($result[0]->studentId);
						$email =$this->encryption->encrypt($result[0]->email);
		
						$studentTests = get_test_and_video_by_studentid($result[0]->studentId, true, true);
						$studentTestIds = join(",",$studentTests['testIds']);
						$validity = new DateTime($result[0]->validity);
		
						$data = array(
							'name' => $result[0]->first_name.' '.$result[0]->last_name,
							'studentId' => $studentId,
							'email' =>$email,
							'profile_picture' => strlen($result[0]->profile_picture) > 0 ? $result[0]->profile_picture : false,
							'studentlogged' => true,
							'lastLogin'=>$result[0]->last_login,
							'studentTestIds'=>$studentTestIds,
							'show_videos'=>$studentTests['show_videos'],
							'show_materials'=>$studentTests['show_materials'],
							'show_class_links'=>$studentTests['show_class_links'],
							'validity'=> $validity->format("d M Y"),
							'actual_validity'=> $result[0]->validity,
							'profile_completed'=> $result[0]->profile_completed
						);
					
						$this->session->set_userdata($data);
					}
				}
				
			}else{
				$this->session->set_userdata('error','Invalid email.');
				return false;
			}

            if ($remember) {
                $this->create_autologin($result[0]->studentId);
            }

            $this->update_login_info($result[0]->studentId);

            return true;
        }

        return false;
    }

    /**
     * @return none
     */
    public function logout()
    {
        $this->delete_autologin();
        $this->session->sess_destroy();
    }

    /**
     * @param  integer ID to create autologin
     * @return boolean
     */
    private function create_autologin($user_id)
    {
        $this->load->helper('cookie');
        $key = substr(md5(uniqid(rand() . get_cookie($this->config->item('sess_cookie_name')))), 0, 16);
        $this->user_autologin->delete($user_id, $key);
        if ($this->user_autologin->set($user_id, md5($key))) {
            set_cookie([
                'name'  => 'autologin',
                'value' => serialize([
                    'user_id' => $user_id,
                    'key'     => $key,
                ]),
                'expire' => 60 * 60 * 24 * 31 * 2, // 2 months
            ]);

            return true;
        }

        return false;
    }

    /**
     * @return none
     */
    private function delete_autologin()
    {
        $this->load->helper('cookie');
        if ($cookie = get_cookie('autologin', true)) {
            $data = unserialize($cookie);
            $this->user_autologin->delete($data['user_id'], md5($data['key']));
            delete_cookie('autologin', 'aal');
        }
    }

    /**
     * @return boolean
     * Check if autologin found
     */
    public function autologin()
    {
        if (!$this->is_logged_in()) {
            $this->load->helper('cookie');
            if ($cookie = get_cookie('autologin', true)) {
                $data = unserialize($cookie);
                if (isset($data['key']) and isset($data['user_id'])) {
                    if (!is_null($user = $this->user_autologin->get($data['user_id'], md5($data['key'])))) {
                        // Get the student id
                        $this->db->where('studentId', $user->id);
                        $student = $this->db->get('studentuser')->row();

                        if($student->status == 0){
                            $this->session->set_userdata('error','Account Expired: Contact Institute');
                            return false;
                        }else{
                            if(isAccountExpired($student->studentId, $student->validity)){
                                $expired_on = new DateTime($student->validity);
                                $this->session->set_userdata('error','Your account got expired on ' . $expired_on->format("M d, Y g:i A"));
                                return false;
                            } else{
                                $first_name = $this->encryption->encrypt($student->first_name);
                                $last_name = $this->encryption->encrypt($student->last_name);
                                $studentId = $this->encryption->encrypt($student->studentId);
                                $email = $this->encryption->encrypt($student->email);
                
                                $studentTests = get_test_and_video_by_studentid($student->studentId, true, true);
                                $studentTestIds = join(",",$studentTests['testIds']);
                                $validity = new DateTime($student->validity);
                
                                $data = array(
                                    'name' => $student->first_name.' '.$student->last_name,
                                    'studentId' => $studentId,
                                    'email' =>$email,
                                    'profile_picture' => strlen($student->profile_picture) > 0 ? $student->profile_picture : false,
                                    'studentlogged' => true,
                                    'lastLogin'=>$student->last_login,
                                    'studentTestIds'=>$studentTestIds,
                                    'show_videos'=>$studentTests['show_videos'],
                                    'show_materials'=>$studentTests['show_materials'],
                                    'show_class_links'=>$studentTests['show_class_links'],
                                    'validity'=> $validity->format("d M Y"),
                                    'actual_validity'=> $student->validity,
                                    'profile_completed'=> $student->profile_completed
                                );
                            
                                $this->session->set_userdata($data);
                            }
                        }
                        // Renew users cookie to prevent it from expiring
                        set_cookie([
                            'name'   => 'autologin',
                            'value'  => $cookie,
                            'expire' => 60 * 60 * 24 * 31 * 2, // 2 months
                        ]);
                        $this->update_login_info($user->id);

                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * @param  integer ID
     * @return none
     * Update login info on autologin
     */
    private function update_login_info($user_id)
    {
        $table = 'studentuser';
        $_id   = 'studentId';
        // $this->db->set('last_ip', $this->input->ip_address());
        $this->db->set('last_login', date('Y-m-d h:i:s'));
        $this->db->where($_id, $user_id);
        $this->db->update($table);
    }

    /**
     * @param  string Email from the user
     * @param  Is Client or Staff
     * @return boolean
     * Generate new password key for the user to reset the password.
     */
    // public function forgot_password($email, $staff = false)
    // {
    //     $table = db_prefix() . 'contacts';
    //     $_id   = 'id';
    //     if ($staff == true) {
    //         $table = db_prefix() . 'staff';
    //         $_id   = 'staffid';
    //     }
    //     $this->db->where('email', $email);
    //     $user = $this->db->get($table)->row();

    //     if ($user) {
    //         if ($user->active == 0) {
    //             log_activity('Inactive User Tried Password Reset [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

    //             return [
    //                 'memberinactive' => true,
    //             ];
    //         }

    //         $new_pass_key = app_generate_hash();
    //         $this->db->where($_id, $user->$_id);
    //         $this->db->update($table, [
    //             'new_pass_key'           => $new_pass_key,
    //             'new_pass_key_requested' => date('Y-m-d H:i:s'),
    //         ]);

    //         if ($this->db->affected_rows() > 0) {
    //             $data['new_pass_key'] = $new_pass_key;
    //             $data['staff']        = $staff;
    //             $data['userid']       = $user->$_id;
    //             $merge_fields         = [];

    //             if ($staff == false) {
    //                 $sent = send_mail_template('customer_contact_forgot_password', $user->email, $user->userid, $user->$_id, $data);
    //             } else {
    //                 $sent = send_mail_template('staff_forgot_password', $user->email, $user->$_id, $data);
    //             }

    //             if ($sent) {
    //                 log_activity('Password Reset Email sent [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

    //                 hooks()->do_action('forgot_password_email_sent', ['is_staff_member' => $staff, 'user' => $user]);

    //                 return true;
    //             }

    //             return false;
    //         }

    //         return false;
    //     }
    //     log_activity('Non Existing User Tried Password Reset [Email: ' . $email . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');

    //     return false;
    // }

    /**
     * Update user password from forgot password feature or set password
     * @param boolean $staff        is staff or contact
     * @param mixed $userid
     * @param string $new_pass_key the password generate key
     * @param string $password     new password
     */
    // public function set_password($staff, $userid, $new_pass_key, $password)
    // {
    //     if (!$this->can_set_password($staff, $userid, $new_pass_key)) {
    //         return [
    //             'expired' => true,
    //         ];
    //     }

    //     $password = app_hash_password($password);
    //     $table    = db_prefix() . 'contacts';
    //     $_id      = 'id';
    //     if ($staff == true) {
    //         $table = db_prefix() . 'staff';
    //         $_id   = 'staffid';
    //     }
    //     $this->db->where($_id, $userid);
    //     $this->db->where('new_pass_key', $new_pass_key);
    //     $this->db->update($table, [
    //         'password' => $password,
    //     ]);
    //     if ($this->db->affected_rows() > 0) {
    //         log_activity('User Set Password [User ID: ' . $userid . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');
    //         $this->db->set('new_pass_key', null);
    //         $this->db->set('new_pass_key_requested', null);
    //         $this->db->set('last_password_change', date('Y-m-d H:i:s'));
    //         $this->db->where($_id, $userid);
    //         $this->db->where('new_pass_key', $new_pass_key);
    //         $this->db->update($table);

    //         return true;
    //     }

    //     return null;
    // }

    /**
     * @param  boolean Is Client or Staff
     * @param  integer ID
     * @param  string
     * @param  string
     * @return boolean
     * User reset password after successful validation of the key
     */
    // public function reset_password($staff, $userid, $new_pass_key, $password)
    // {
    //     if (!$this->can_reset_password($staff, $userid, $new_pass_key)) {
    //         return [
    //             'expired' => true,
    //         ];
    //     }
    //     $password = app_hash_password($password);
    //     $table    = db_prefix() . 'contacts';
    //     $_id      = 'id';
    //     if ($staff == true) {
    //         $table = db_prefix() . 'staff';
    //         $_id   = 'staffid';
    //     }

    //     $this->db->where($_id, $userid);
    //     $this->db->where('new_pass_key', $new_pass_key);
    //     $this->db->update($table, [
    //         'password' => $password,
    //     ]);
    //     if ($this->db->affected_rows() > 0) {
    //         log_activity('User Reseted Password [User ID: ' . $userid . ', Is Staff Member: ' . ($staff == true ? 'Yes' : 'No') . ', IP: ' . $this->input->ip_address() . ']');
    //         $this->db->set('new_pass_key', null);
    //         $this->db->set('new_pass_key_requested', null);
    //         $this->db->set('last_password_change', date('Y-m-d H:i:s'));
    //         $this->db->where($_id, $userid);
    //         $this->db->where('new_pass_key', $new_pass_key);
    //         $this->db->update($table);
    //         $this->db->where($_id, $userid);
    //         $user = $this->db->get($table)->row();

    //         $merge_fields = [];
    //         if ($staff == false) {
    //             $sent = send_mail_template('customer_contact_password_resetted', $user->email, $user->userid, $user->$_id);
    //         } else {
    //             $sent = send_mail_template('staff_password_resetted', $user->email, $user->$_id);
    //         }

    //         if ($sent) {
    //             return true;
    //         }
    //     }

    //     return null;
    // }

    /**
     * @param  integer Is Client or Staff
     * @param  integer ID
     * @param  string Password reset key
     * @return boolean
     * Check if the key is not expired or not exists in database
     */
    // public function can_reset_password($staff, $userid, $new_pass_key)
    // {
    //     $table = db_prefix() . 'contacts';
    //     $_id   = 'id';
    //     if ($staff == true) {
    //         $table = db_prefix() . 'staff';
    //         $_id   = 'staffid';
    //     }

    //     $this->db->where($_id, $userid);
    //     $this->db->where('new_pass_key', $new_pass_key);
    //     $user = $this->db->get($table)->row();

    //     if ($user) {
    //         $timestamp_now_minus_1_hour = time() - (60 * 60);
    //         $new_pass_key_requested     = strtotime($user->new_pass_key_requested);
    //         if ($timestamp_now_minus_1_hour > $new_pass_key_requested) {
    //             return false;
    //         }

    //         return true;
    //     }

    //     return false;
    // }

    /**
     * @param  integer Is Client or Staff
     * @param  integer ID
     * @param  string Password reset key
     * @return boolean
     * Check if the key is not expired or not exists in database
     */
    // public function can_set_password($staff, $userid, $new_pass_key)
    // {
    //     $table = db_prefix() . 'contacts';
    //     $_id   = 'id';
    //     if ($staff == true) {
    //         $table = db_prefix() . 'staff';
    //         $_id   = 'staffid';
    //     }
    //     $this->db->where($_id, $userid);
    //     $this->db->where('new_pass_key', $new_pass_key);
    //     $user = $this->db->get($table)->row();
    //     if ($user) {
    //         $timestamp_now_minus_48_hour = time() - (3600 * 48);
    //         $new_pass_key_requested      = strtotime($user->new_pass_key_requested);
    //         if ($timestamp_now_minus_48_hour > $new_pass_key_requested) {
    //             return false;
    //         }

    //         return true;
    //     }

    //     return false;
    // }
}
