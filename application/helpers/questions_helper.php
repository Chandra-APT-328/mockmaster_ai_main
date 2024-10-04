<?php 
defined('BASEPATH') or exit('No direct script access allowed');

function get_model_question_counts(){
    $CI = &get_instance();

    $CI->db->select('count(id) as count, question_type');
    $CI->db->from("listening_questions");
    $CI->db->group_by("question_type");
    $listening = $CI->db->get()->result_array();
    
    $CI->db->select('count(id) as count, question_type');
    $CI->db->from("reading_questions");
    $CI->db->group_by("question_type");
    $reading = $CI->db->get()->result_array();
    
    $CI->db->select('count(id) as count, question_type');
    $CI->db->from("writing_questions");
    $CI->db->group_by("question_type");
    $writing = $CI->db->get()->result_array();
    
    $CI->db->select('count(id) as count, question_type');
    $CI->db->from("speaking_questions");
    $CI->db->group_by("question_type");
    $speaking = $CI->db->get()->result_array();
    
    return array(
        "listening" => $listening,
        "reading" 	=> $reading, 
        "writing" 	=> $writing,
        "speaking" 	=> $speaking
    );
}

function get_student_model_category_wise_attempts($studentId){
    $CI = &get_instance();
    $CI->load->model('Iifl_info');
    
    $fields = " count(DISTINCT question_id) as attempts, question_type";
    $whereUserClause = " question_type IS NOT NULL AND user_id = " . $studentId . " GROUP BY question_type";
    $listening_category_attempts = $CI->Iifl_info->selectdata($fields,'listening_answers',$whereUserClause);
    $reading_category_attempts = $CI->Iifl_info->selectdata($fields,'reading_answers',$whereUserClause);
    $writing_category_attempts = $CI->Iifl_info->selectdata($fields,'writing_answers',$whereUserClause);
    $speaking_category_attempts = $CI->Iifl_info->selectdata($fields,'speaking_answers',$whereUserClause);

    return array(
        "listening" => $listening_category_attempts,
        "reading" 	=> $reading_category_attempts, 
        "writing" 	=> $writing_category_attempts,
        "speaking" 	=> $speaking_category_attempts
    );
}

function get_student_questions_progress($studentId){
    $categorywise_attempts = get_student_model_category_wise_attempts($studentId);
    $model_question_counts_categorywise = get_model_question_counts();

    $total_questions_attempted_modelwise = [];
    $total_questions_modelwise = [];
    $percent_progress_modelwise = [];
    $total_questions_attempted_categorywise = [];
    $total_questions_categorywise = [];
    $overall_progress_categorywise = [];

    foreach ($categorywise_attempts as $model => $categories) {
        foreach ($categories as $key => $sub_category) {
            $total_questions_attempted_modelwise[$model] += $sub_category->attempts ? $sub_category->attempts : 0;
            $total_questions_attempted_categorywise[$sub_category->question_type] += $sub_category->attempts ? $sub_category->attempts : 0;
        }
    }
    foreach ($model_question_counts_categorywise as $model => $categories) {
        foreach ($categories as $key => $sub_category) {
            $total_questions_modelwise[$model] += $sub_category['count'] ? $sub_category['count'] : 0;
            $total_questions_categorywise[$sub_category['question_type']] += $sub_category['count'] ? $sub_category['count'] : 0;
        }
    }
    
    foreach ($total_questions_modelwise as $model => $model_total_questions) {
        $percent_progress_modelwise[$model] = array(
            "total" => $total_questions_modelwise[$model],
            "attempted" => $total_questions_attempted_modelwise[$model] ? $total_questions_attempted_modelwise[$model] : 0,
            "percent_progress" => $total_questions_attempted_modelwise[$model] ? ceil(($total_questions_attempted_modelwise[$model] / $total_questions_modelwise[$model]) * 100) : 0
        );
    }
    
    foreach ($total_questions_categorywise as $sub_category => $sub_category_total_questions) {
        $overall_progress_categorywise[$sub_category] = array(
            "total" => $total_questions_categorywise[$sub_category],
            "attempted" => $total_questions_attempted_categorywise[$sub_category] ? $total_questions_attempted_categorywise[$sub_category]: 0,
            "percent_progress" => $total_questions_attempted_categorywise[$sub_category] ? ceil(($total_questions_attempted_categorywise[$sub_category] / $total_questions_categorywise[$sub_category]) * 100) : 0
        );
    }

    return array("model_wise" => $percent_progress_modelwise, "category_wise" => $overall_progress_categorywise);
}

// gets 10 questions from each question type of a category
function get_free_questions_per_category($category)
{
    $CI = &get_instance();
    $sql = "
        WITH RankedQuestions AS (
            SELECT 
                id, 
                question_type, 
                ROW_NUMBER() OVER (PARTITION BY question_type ORDER BY id desc) AS row_num
            FROM " . $category . "_questions
        )
        SELECT 
            GROUP_CONCAT(id) AS free_question_ids
        FROM 
            RankedQuestions
        WHERE 
            row_num <= 10
    ";

    // Executing raw SQL in CodeIgniter
    $query = $CI->db->query($sql);
    return $query->result_array();
}

// Function to generate cache-busted resource file URL
function cache_bust_resource($resource_path) {
    $cache_buster = time();
    if (strpos($resource_path, '?') !== false) {
        return base_url() . $resource_path . '&cache=' . $cache_buster;
    } else {
        return base_url() . $resource_path . '?cache=' . $cache_buster;
    }
}