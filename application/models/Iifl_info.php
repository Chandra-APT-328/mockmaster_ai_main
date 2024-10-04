<?php 

/**
* 
*/
class Iifl_info extends CI_Model
{

    function __construct() {
      parent :: __construct(); 
      $this->load->helper('url');
    }

    function roleingetdata($table_name,$column_name='',$where_clause=array(),$where_clause3=""){

    $this->db->select('*'); 

    $this->db->from($table_name);
      if(count($where_clause) > 0){
        $this->db->where_in($column_name,$where_clause);
      }

         if(strlen($where_clause3) > 0){
        $this->db->where($where_clause3);
      }

    $query = $this->db->get();
     
    return $query->result();

  }
 
function getroleAccess(){
   
   $role = explode(",",$this->role);
   
   $getaccess = $this->roleingetdata('role_access','group_id',$role);
   $data=array();
        if(count($getaccess) > 0){
    foreach ($getaccess as $ky => $rowrole) {
      $where_clause = array('type'=>$rowrole->function_id);
     $getfunctionName = $this->rolegetdata('app_function',$where_clause);  
        foreach ($getfunctionName as $key => $rowfunct) {   
      $data['roledata'][$rowfunct->function_name] = array('full'=>$rowrole->full_role,'edit'=>$rowrole->edit_role,'add'=>$rowrole->add_role,'delete'=>$rowrole->delete_role,'print'=>$rowrole->print_role);
      $data['function_name'][] = $rowfunct->function_name;
    }
    $data['layout_name'][] = $rowrole->function_id;
     }
   }
        return $data;           

  }


   function rolegetdata($table_name,$where_clause=array(),$or_where_clause=array(),$fieldname='',$ordertype=''){
        
        $this->db->select('*'); 

        $this->db->from($table_name);
          if(count($where_clause) > 0){
            $this->db->where($where_clause);
          }
          if(count($or_where_clause) > 0){
            $this->db->or_where($or_where_clause);
          }
         
            if($fieldname!=''){
            $this->db->order_by($fieldname,$ordertype);
          }
          
        $query = $this->db->get();
        return $query->result();

 }

  function getdata($table_name,$where_clause=array(),$or_where_clause=array(),$fieldname='',$ordertype='',$whereInField='',$whereInArr = array(), $limit = "", $offset = "",$groupBY=array(),$whereNotInField='', $whereNotIn =array()){
        
        $this->db->select('*'); 

        $this->db->from($table_name);

          if(strlen($whereInField) > 0 && count($whereInArr) == 0){
            $this->db->where($whereInField);
          }

          if(strlen($whereInField) > 0 && count($whereInArr) > 0){
            $this->db->where_in($whereInField, $whereInArr);
          }

          if(strlen($whereNotInField) > 0 && count($whereNotIn) > 0){
            $this->db->where_not_in($whereNotInField, $whereNotIn);
          }
          
          if(count($where_clause) > 0){
            $this->db->where($where_clause);
          }

          if(count($or_where_clause) > 0){
            $this->db->or_where($or_where_clause);
          }

          if (count($groupBY) > 0){
            $this->db->group_by($groupBY); 
           }

          if($fieldname!=''){
            $this->db->order_by($fieldname,$ordertype);
          }
          
          if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
          }

        $query = $this->db->get();
        return $query->result();

 }



 function getfindinset($table_name,$searchterm,$columnName,$where_clause=array()){

        $this->db->select('*');
        $this->db->from($table_name);
        $where = "FIND_IN_SET('".$searchterm."',".$columnName." )>0";  
        $this->db->where($where); 
          if(count($where_clause) > 0){
            $this->db->where($where_clause); 
          }

        $query = $this->db->get();
        return $query->result();

 }

  function get_dropdown_value($table,$field1,$field2,$condition = ''){

      $value = array();

      $sql = 'Select '.$field1.', '.$field2.' From '.$table;

      $sql .= (strlen($condition) > 0) ? ' where '.$condition : ''; 

      $data = $this->db->query($sql);

      if($data->num_rows() > 0){

          foreach($data->result_array() as $r){

              $value[$r[$field1]] = $r[$field2];

          }
      }
     
      return $value;
  }


  function insert($table_name,$data){

    $this->db->insert($table_name,$data);
    $insertid = $this->db->insert_id();
    return $insertid;
  }

  function update($table_name,$data,$where_clause=array(),$labelId='',$getalldata=array()){

    if(count($where_clause) > 0){
      $this->db->where($where_clause);
    }
      if(strlen($labelId) > 0 && count($getalldata) > 0){
    $this->db->where_in($labelId,$getalldata);
  }

    $this->db->update($table_name, $data);
  }

  function delete($table_name,$where_clause=array()){
    if(count($where_clause) > 0){
      $this->db->where($where_clause);
    }
    $this->db->delete($table_name);
  }

    function select($table, $where = 1) {
        $result = array();
        $query = "SELECT * FROM $table WHERE $where";
           $data = $this->db->query($query);
             if($data && !empty($data)){
              $result = $data->result_array();
             }
           return $result;
    }

       function selectresult($table, $where = 1) {
        $result = array();
        $query = "SELECT * FROM $table WHERE $where";
           $data = $this->db->query($query);
             if($data && !empty($data)){
              $result = $data->result();
             }
           return $result;
    }

      function selectdata($fieldname="*",$table, $where = 1) {
        $result = array();
        $query = "SELECT $fieldname FROM $table WHERE $where";
           $data = $this->db->query($query);
             if($data && !empty($data)){
              $result = $data->result();
             }
           return $result;
    }


  function sendmail($subject, $receiver, $message, $arr_attach = '')
  {

    $this->load->library('phpmailer_lib');

    // PHPMailer object
    $mail = $this->phpmailer_lib->load();
    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = SMTP_EMAIL;
    $mail->Password = SMTP_PASSWORD;
    $mail->SMTPSecure = 'tls';

    $mail->Port = 587;
    $mail->SMTPAutoTLS = false;

    $mail->setFrom(SMTP_EMAIL, MAIL_SIGNATURE);

    // Add a recipient
    $mail->addAddress($receiver);

    // Email subject
    $mail->Subject = $subject;

    // Set email format to HTML
    $mail->isHTML(true);

    // Email body content
    $mailContent = get_option('email_header') . $message . get_option('email_footer');
    $mail->Body = $mailContent;

    if (!$mail->send()) {
      $maillog = $mail->ErrorInfo;
      $this->systemsendmail($maillog);
    } else {
      $maillog = 'Sent';
    }
    return true;
  }

  function systemsendmail($message){
    $this->load->library('phpmailer_lib');
    $mail = $this->phpmailer_lib->load();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = DEV_SMTP_EMAIL;
    $mail->Password = DEV_SMTP_PASSWORD;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->SMTPAutoTLS = false;
    $mail->setFrom(DEV_SMTP_EMAIL, "Mockmaster.ai Devlogs");
    $mail->addAddress(DEV_SMTP_EMAIL);
    $mail->Subject = "Mockmaster Email Services Failure";
    $mail->isHTML(true);
    $mailContent = get_option('email_header') . $message . get_option('email_footer');
    $mail->Body = $mailContent;
    if (!$mail->send()) {
      $maillog = $mail->ErrorInfo;
    } else {
      $maillog = 'Sent';
    }
    return true;
  }

  public function url($ten_url_summery){
    $newurltendersum = strtolower(substr($this->strfromdb($ten_url_summery), 0, 100));
    $newurltendersum = str_replace("<br/>", "", $newurltendersum);
    $newurltendersum = preg_replace('/[^A-Za-z0-9 -]/', '', $newurltendersum);
    $newurltendersum = trim(preg_replace('/\s+/', ' ', $newurltendersum));
    $newurltendersum = str_replace(" ", "-", $newurltendersum);
    return $newurltendersum = $newurltendersum ;
  }

  public function StrFromDb($str) {
    $str = str_replace("&#39;", "'", $str);
    $str = str_replace("&#34;", '"', $str);
    $str = str_replace("&#nl;", "\n", $str);
    $str = str_replace("&#rl;", "\r", $str);
    $str = str_replace("&#nl", "\n", $str);
    $str = str_replace("&#rl", "\r", $str);
    return $str;
  }





    public function getRows($postData,$tablename,$column_search,$orderfield,$orderby,$fromdate='',$todate='',$where_clause=array(),$whereIn='',$custom_order=''){
        
        $this->_get_datatables_query($postData,$tablename,$column_search,$orderfield,$orderby,$fromdate,$todate,$where_clause,$whereIn,$custom_order);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    /*
     * Count all records
     */
    public function countAll($tablename,$fromdate='',$todate='',$where_clause = array() ){
        $this->db->from($tablename);

            if(strlen($fromdate) > 0){
         $this->db->where("TIMESTAMPDIFF(DAY , STR_TO_DATE(create_date, '%Y-%m-%d' ) , '$todate') >=0");
       
         $this->db->where("TIMESTAMPDIFF(DAY ,'$fromdate',STR_TO_DATE(create_date,'%Y-%m-%d' )) >=0");
       }    

       if(count($where_clause) > 0){
        $this->db->where($where_clause);
      }
      
        return $this->db->count_all_results();
    }
    
    /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData,$tablename,$column_search,$orderfield,$orderby,$fromdate='',$todate='',$where_clause=array(),$whereIn='',$custom_order=''){
        $this->_get_datatables_query($postData,$tablename,$column_search,$orderfield,$orderby,$fromdate,$todate,$where_clause,$whereIn,$custom_order);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    /*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData,$tablename,$column_search,$orderfield,$orderby='',$fromdate='',$todate='',$where_clause=array(),$whereIn='',$custom_order=''){    
        $this->db->from($tablename);
        if(!$postData['search']['value']){
          if(strlen($fromdate) > 0){
            $this->db->where("TIMESTAMPDIFF(DAY , STR_TO_DATE(create_date, '%Y-%m-%d' ) , '$todate') >=0");
            $this->db->where("TIMESTAMPDIFF(DAY ,'$fromdate',STR_TO_DATE(create_date,'%Y-%m-%d' )) >=0");
          }
          if(count($where_clause) > 0){
            $this->db->where($where_clause);
          }
          if(strlen($whereIn) > 0){
            $this->db->where($whereIn);
          }
        }

        $i = 0;
        // loop searchable columns 
        foreach($column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }


       if(isset($postData['order'])){
          $this->db->order_by($orderfield[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(strlen($custom_order) > 0){
          $this->db->order_by($custom_order);
        }else if(isset($orderby)){
          $order = $orderby;
          $this->db->order_by(key($order), $order[key($order)]);
        } 
    }
} //End Class

?>