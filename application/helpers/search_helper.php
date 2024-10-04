<?php

defined('BASEPATH') or exit('No direct script access allowed');

function perform_search($get){
    
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $string = trim($get['text']);
    $category = trim($get['type']);
    $status = trim($get['status']);
    $orderby = trim($get['order']) == 'new' ? 'DESC' : 'ASC';
    $prac_status = trim($get['practicestatus']);
    $u_id =  $CI->encryption->decrypt($CI->session->userdata("studentId"));
    $table_search = getCategoryDataByCode($category);
    $result = [];
    $limit = 20;
    
    if(isset($get['list_only']) && $get['list_only']){
        if($category){
            if($prac_status=='practiced'){
                $CI->db->select('question_id');
                $CI->db->from($table_search['category'].'_answers');
                $CI->db->where("user_id", $u_id);
                $CI->db->where("question_type",$category);
                $CI->db->group_by("question_id");
                $practiced_questions = $CI->db->get()->result_array();
                //get question ids in array
                $ids = [];
                foreach($practiced_questions as $practiced_question){
                    $ids[] = $practiced_question["question_id"];
                }
                $CI->db->select('*');
                $CI->db->from($table_search['category'].'_questions');
                $CI->db->where_in("id",$ids);
                $CI->db->where("question_type",$category);
            }else if($prac_status== 'unpracticed'){
                $CI->db->select('question_id');
                $CI->db->from($table_search['category'].'_answers');
                $CI->db->where("user_id",$u_id);
                $CI->db->where("question_type",$category);
                $CI->db->group_by("question_id");
                $unpracticed_questions = $CI->db->get()->result_array();
                //get question ids in array
                $ids = [];
                foreach($unpracticed_questions as $unpracticed_question){
                    $ids[] = $unpracticed_question["question_id"];
                }
                $CI->db->select('*');
                $CI->db->from($table_search['category'].'_questions');
                if(count($ids) > 0){
                    $CI->db->where_not_in("id",$ids);
                }
                $CI->db->where("question_type",$category);
            }else{
                $CI->db->select('*');
                $CI->db->from($table_search['category'].'_questions');
                $CI->db->where("question_type",$category);
            }
            $CI->db->order_by('id', $orderby);
            
            if($get['length'] != -1){
                $CI->db->limit($get['length'], $get['start']);
            }

            $query = $CI->db->get();
            // echo $CI->db->last_query();
            if($query){
                $result['data'] = $query->result_array();
                $result['count'] = $query->num_rows();
                $result['total_count'] = search_count_all($get);
            }else{
                $result['data'] = [];
                $result['count'] = 0;
                $result['total_count'] = 0;
            }
        }else{
            $result['data'] = [];
            $result['count'] = 0;
            $result['total_count'] = 0;
        }
    }else{
        if(strlen($string) > 0 && $category){
            $CI->db->select();
            $CI->db->from($table_search['category'].'_questions');
            if($table_search['category'] == 'speaking' || $table_search['category'] == "listening"){
                $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR transcript LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR keywords LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    )');
            }elseif($table_search['category'] == 'reading'){
                $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    )');
            }else{
                $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    OR keywords LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                    )');
            }
        
            $CI->db->where("question_type",$category);
        
            $CI->db->order_by('id', $orderby);
            
            if($get['length'] != -1){
                $CI->db->limit($get['length'], $get['start']);
            }
            $query = $CI->db->get();
            $result['data'] = $query->result_array();
            $result['count'] = $query->num_rows();
            $result['total_count'] = search_count_all($get);
        }else{
            $result['data'] = [];
            $result['count'] = 0;
            $result['total_count'] = 0;
        }
    }
    

    return $result;
}

function search_count_all($get){
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $string = trim($get['text']);
    $category = trim($get['type']);
    $status = trim($get['status']);
    $table_search = getCategoryDataByCode($category);
    $prac_status = trim($get['practicestatus']);
    $u_id =  $CI->encryption->decrypt($CI->session->userdata("studentId"));
    
    if(isset($get['list_only']) && $get['list_only']){
        if($prac_status=='practiced'){
            $CI->db->select('question_id');
            $CI->db->from($table_search['category'].'_answers');
            $CI->db->where("user_id", $u_id);
            $CI->db->where("question_type",$category);
            $CI->db->group_by("question_id");
            $practiced_questions = $CI->db->get()->result_array();
            //get question ids in array
            $ids = [];
            foreach($practiced_questions as $practiced_question){
                $ids[] = $practiced_question["question_id"];
            }
            $CI->db->select('*');
            $CI->db->from($table_search['category'].'_questions');
            $CI->db->where_in("id",$ids);
            $CI->db->where("question_type",$category);
        }else if($prac_status== 'unpracticed'){
            $CI->db->select('question_id');
            $CI->db->from($table_search['category'].'_answers');
            $CI->db->where("user_id",$u_id);
            $CI->db->where("question_type",$category);
            $CI->db->group_by("question_id");
            $unpracticed_questions = $CI->db->get()->result_array();
            //get question ids in array
            $ids = [];
            foreach($unpracticed_questions as $unpracticed_question){
                $ids[] = $unpracticed_question["question_id"];
            }
            $CI->db->select('*');
            $CI->db->from($table_search['category'].'_questions');
            if(count($ids) > 0){
                $CI->db->where_not_in("id",$ids);
            }
            $CI->db->where("question_type",$category);
        }else{
            $CI->db->select('*');
            $CI->db->from($table_search['category'].'_questions');
            $CI->db->where("question_type",$category);
        }
    }else{
        $CI->db->select();
        $CI->db->from($table_search['category'].'_questions');
        if($table_search['category'] == 'speaking' || $table_search['category'] == "listening"){
            $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR transcript LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR keywords LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                )');
        }elseif($table_search['category'] == 'reading'){
            $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                )');
        }else{
            $CI->db->where('(title LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR question LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR id LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                OR keywords LIKE "%' . $CI->db->escape_like_str($string) . '%" ESCAPE \'!\'
                )');
        }
    }

    $CI->db->where("question_type",$category);

    return $CI->db->count_all_results();
}

function getSearchRowString($data){
    switch($data['question_type']){
        case "read_alouds":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['question']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "repeat_sentences":
        case "retell_lectures":
        case "respond_situation":    
        case "answer_questions":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><audio src="'.base_url($data['resourcePath']).'" controls="" preload="none"></audio></div><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['transcript']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "describe_images":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><img src="'.base_url($data['resourcePath']).'" style="max-height:320px;"></div><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['answer']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "swtx":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['question']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "essays":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#' . $data['id'] . ' ' . $data['title'] . '</span></div><div class="col-12 col-md-12 pb-20"><p style="line-height:1.8;font-size: medium;">' . strip_tags($data['question']) . '</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="' . base_url('user/' . $data['question_type'] . '/' . $data['id']) . '" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "email":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#' . $data['id'] . ' ' . $data['title'] . '</span></div><div class="col-12 col-md-12 pb-20"><p style="line-height:1.8;font-size: medium;">' . strip_tags($data['question']) . '</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="' . base_url('user/' . $data['question_type'] . '/' . $data['id']) . '" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "fib_wr":
        case "fib_rd":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20" style="line-height:1.8;font-size: medium;">'.preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $data['question']).'</div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "r_mcm":
        case "r_mcs":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20" style="line-height:1.8;font-size: medium;">'.preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $data['question']).'</div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "ro":
            $paragraphs = json_decode($data['options']);
            $paragraph_arr = [];
            foreach ($paragraphs as $pkey => $paragraph) {
                $paragraph_arr[$pkey + 1] = '<p">'.$paragraph.'</p>';
            }

            $answer = array('<p>In correct order:</p>');
            $answer_order = json_decode($data['answer']);
            foreach ($answer_order as $row) {
                array_push($answer,$paragraph_arr[$row]);
            }
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20" style="line-height:1.8;font-size: medium;">'.implode("",$answer).'</div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "ssts":
        case "wfds":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><audio src="'.base_url($data['audioPath']).'" controls="" preload="none"></audio></div><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['transcript']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "l_mcm":
        case "l_mcs":
        case "l_hcs":
        case "l_smw":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><audio src="'.base_url($data['audioPath']).'" controls="" preload="none"></audio></div><p class="pb-20" style="line-height:1.8;font-size: medium;">'.strip_tags($data['transcript']).'</p><p style="line-height:1.8;font-size: medium;">'.strip_tags($data['question']).'</p></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "l_fib":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><audio src="'.base_url($data['audioPath']).'" controls="" preload="none"></audio></div><div class="pb-20" style="line-height:1.8;font-size: medium;">'.preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $data['question']).'</div></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
        case "hiws":
            $row = '<div class="row p-10 font-14"><div class="col-12 col-md-12 pb-20"><span style="font-size: medium;font-weight: 500;">#'.$data['id'].' '.$data['title'].'</span></div><div class="col-12 col-md-12 pb-20"><div class="pb-20"><audio src="'.base_url($data['audioPath']).'" controls="" preload="none"></audio></div><div class="pb-20" style="line-height:1.8;font-size: medium;">'.preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $data['question']).'</div></div><div class="col-12 col-md-12 d-flex justify-content-end"><a href="'.base_url('user/'.$data['question_type'].'/'.$data['id']).'" class="btn btn-sm btn-primary mt-2">Practice</a></div></div>';

            return $row;
            break;
    }
    

    
}