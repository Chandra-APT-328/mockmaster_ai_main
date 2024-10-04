<?php  
    defined('BASEPATH') or exit('No direct script access allowed');

    function get_answer_score_by_id($post_data){
        $CI = &get_instance();

        $answer_id = $post_data['answer'];
		$answers_table = $post_data['model'].'_answers';
        $questions_table = $post_data['model'].'_questions';
        $CI->db->select('*,'.$questions_table.'.answer as actual_answer,'.$answers_table.'.answer as student_answer');
		$CI->db->join($questions_table, $answers_table.'.question_id=' . $questions_table.'.id');
        $CI->db->where($answers_table.'.id', $answer_id);
		$answer_data = $CI->db->get($answers_table)->row();
        $response = get_answer_score_details($answer_data);
        return $response;
    }

    function get_answer_score_details($answer_data){
        $response = [];
        $CI = &get_instance();
        if($answer_data){
            switch($answer_data->question_type){
                case 'read_alouds':
                case 'repeat_sentences':
                case 'describe_images':
                case 'retell_lectures':
                case 'respond_situation':
                    $response['max_score'] = 90;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['answer_transcript'] = $answer_data->answer_transcript;
                    $response = $CI->load->view('popupmodals/read_alouds', $response, TRUE);
                    break;
                case 'answer_questions':
                    $response['max_score'] = 1;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['answer_transcript'] = $answer_data->answer_transcript;
                    $response = $CI->load->view('popupmodals/answer_questions', $response, TRUE);
                    break;
                case 'fib_rd':
                case 'fib_wr':
                case 'l_fib':
                    $actual_answer = json_decode($answer_data->actual_answer);
                    $student_answer = json_decode($answer_data->student_answer);
                    
                    $mistakes = [];
                    foreach ($actual_answer as $key => $row) {
                        if ($actual_answer[$key] == $student_answer[$key]) {
                            array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                        }else{
                            array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                        }
                    }
                    $response['max_score'] = count($actual_answer);
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = join(', ',$mistakes);
                    $response = $CI->load->view('popupmodals/fib_rd', $response, TRUE);
                    break;
                case 'r_mcm':
                    $actual_answer = json_decode($answer_data->actual_answer);
                    $originalAnswerCount = 0;
                    foreach ($actual_answer as $value) {
                        if ($value == "1") {
                            $originalAnswerCount++;
                        }
                    }
                    $response['max_score'] = $originalAnswerCount;
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response = $CI->load->view('popupmodals/r_mcm', $response, TRUE);
                    break;
                case 'r_mcs':
                case 'l_mcs':
                case 'l_hcs':
                case 'l_smw':
                    $response['max_score'] = 1;
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response = $CI->load->view('popupmodals/r_mcm', $response, TRUE);
                    break;
                case 'ro':
                    $actual_answer = json_decode($answer_data->actual_answer);
                    $response['max_score'] = count($actual_answer) - 1;
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response = $CI->load->view('popupmodals/ro', $response, TRUE);
                    break;
                case 'l_mcm':
                    $response['max_score'] = 2;
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response = $CI->load->view('popupmodals/r_mcm', $response, TRUE);
                    break;
                case 'hiws':
                    $actual_answer = json_decode($answer_data->actual_answer,true);
                    $student_answer = json_decode($answer_data->student_answer);
                    $incorrectWordsArr = array_diff($student_answer,array_keys($actual_answer));

                    $mistakes = [];
                    foreach ($student_answer as $key => $row) {
                        if (in_array($row, $incorrectWordsArr)) {
                            array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                        }else{
                            array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                        }
                    }
                    $response['max_score'] = count($actual_answer);
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = join(', ',$mistakes);
                    $response = $CI->load->view('popupmodals/hiws', $response, TRUE);
                    break;
                case 'wfds':
                    $originalAnswerArr = explode(' ',strtolower(trim(preg_replace('/\p{P}/', '',$answer_data->transcript))));
                    $response['max_score'] = count($originalAnswerArr);
                    $response['score'] = $answer_data->score;
                    $response['suggestion'] = $answer_data->suggestion;
                    // $response['mistakes'] =json_decode($answer_data->mistakes);
                    $response = $CI->load->view('popupmodals/wfds', $response, TRUE);
                    break;
                case 'essays':
                    $response['max_score'] = 15;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = json_decode($answer_data->mistakes);
                    $response = $CI->load->view('popupmodals/essays', $response, TRUE);
                    break;
                case 'email':
                    $response['max_score'] = 15;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = json_decode($answer_data->mistakes);
                    $response = $CI->load->view('popupmodals/email', $response, TRUE);
                    break;
                case 'swtx':
                    $response['max_score'] = 7;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = json_decode($answer_data->mistakes);
                    $response = $CI->load->view('popupmodals/swtx', $response, TRUE);
                    break;
                case 'ssts':
                    $response['max_score'] = 10;
                    $response['score'] = $answer_data->score;
                    $response['component_score'] = json_decode($answer_data->component_score);
                    $response['suggestion'] = $answer_data->suggestion;
                    $response['mistakes'] = json_decode($answer_data->mistakes);
                    $response = $CI->load->view('popupmodals/ssts', $response, TRUE);
                    break;
            }
        }
        return $response;
    }