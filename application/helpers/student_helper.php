<?php
defined('BASEPATH') or exit('No direct script access allowed');

function register_user_to_applykart($studentId, $auth_key = "")
{
    $CI = &get_instance();

    $CI->load->model("student_model");
    $student = $CI->student_model->get($studentId);
    if ($student) {
        $apply_kart_data = array(
            "username" => $student->full_name,
            "email" => $student->email,
            "User_Type_Id" => 2,
            "social_type" => 2,
            "device_type" => 3,
        );

        if (strlen($auth_key) > 0) {
            $encrypted_data = openssl_encrypt(
                $auth_key,
                'DES-CBC',
                APPLYKART_KEY,
                0, // options: 0 for standard data
                APPLYKART_IV
            );
            $apply_kart_data["password"] = $encrypted_data;
        }

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://applykartfapp.azurewebsites.net/api/User/SocialMediaRegisteration',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($apply_kart_data),
                CURLOPT_HTTPHEADER => array(
                    'client-secret: 1QiLA0KICJhbGciOiJIUzI1NiJ9',
                    'Content-Type: application/json'
                ),
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        log_activity('AK NEW USER REGISTRATION RESPONSE: ' . json_encode($response));

        if ($response['success'] == true && isset($response['data'])) {
            $ak_user_data = $response['data'];
            if (isset($ak_user_data['user_Id'])) {
                update_user_profile_applykart(
                    $ak_user_data['user_Id'],
                    $student->first_name,
                    $student->last_name,
                    $student->email
                );
            }
        }
        return $response['success'];
    }
    return false;
}

function update_user_profile_applykart($ak_user_id, $first_name, $last_name, $email)
{

    $curl = curl_init();

    $apply_kart_data = array(
        "user_id" => $ak_user_id,
        "first_name" => $first_name,
        "last_name" => $last_name,
        "email" => $email,
        "language" => "English",
        "education_details" => [],
        "job_type" => ""
    );

    curl_setopt_array(
        $curl,
        array(
            CURLOPT_URL => 'https://applykartfapp.azurewebsites.net/api/JobSeeker',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($apply_kart_data),
            CURLOPT_HTTPHEADER => array(
                'client-secret: 1QiLA0KICJhbGciOiJIUzI1NiJ9',
                'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyVHlwZUlkIjoiMSIsInVzZXJJZCI6IjEiLCJuYmYiOjE3MjI0MDUyMjYsImV4cCI6MTcyMzAxMDAyNiwiaWF0IjoxNzIyNDA1MjI2LCJpc3MiOiJhcHBseWthcnQiLCJhdWQiOiJhcHBseWthcnQifQ.RUEMKs6bgCYf3OrBDfH5zjLlkGjWZ9X0tR3TVKNmiXM',
                'Content-Type: application/json'
            ),
        )
    );

    $response = curl_exec($curl);

    log_activity('AK UPDATE USER RESPONSE: ' . $response);

    curl_close($curl);
}

function register_and_save_coupon_applykart($studentId, $auth_key = "")
{
    $CI = &get_instance();
    $CI->load->model('student_model');
    if (register_user_to_applykart($studentId, $auth_key)) {
        $coupon_applykart = get_new_coupon_applykart();
        if ($coupon_applykart) {
            $CI->student_model->update(
                array(
                    'ak_coupon_code' => $coupon_applykart,
                ),
                $studentId
            );
            $CI->db->insert(
                "scheduled_emails",
                array(
                    "student_id" => $studentId,
                    "scheduled_at" => date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1 DAY')),
                    "template" => "APPLYKART_REMINDER_CRON",
                )
            );
            return true;
        }
    }
    return false;
}

function get_test_and_video_by_studentid($studentId, $only_mock_test_ids = true, $with_materials_menu_status = false)
{

    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $testIds = [];
    $show_videos = false;
    $addon_languages = null;
    $show_materials = false;
    $show_class_links = false;
    $have_only_free_package = true;
    $whereclause = array('studentid' => $studentId);
    $result = $CI->Iifl_info->getdata('purchases', $whereclause);

    foreach ($result as $key => $value) {
        $packagewhereclause = array('packageid' => $value->productid);
        $packageData = $CI->Iifl_info->getdata('packages', $packagewhereclause);

        // mark purchase expired if expiry date
        if (date('Y-m-d h:i:s') >= $value->expire_date) {
            $CI->Iifl_info->update('purchases', array('is_expired' => 1, 'last_updated' => date('Y-m-d h:i:s')), array('purchaseid' => $packageData[0]->purchaseid));
            continue;
        }

        // checking if only have free package
        if ($packageData[0]->usage_type != PACKAGE_FREE) {
            $have_only_free_package = false;
        }


        $packageTestIds = explode(",", $packageData[0]->category_type_ids);
        foreach ($packageTestIds as $key => $value) {
            if ($only_mock_test_ids) {
                if (!in_array($value, $testIds, true)) {
                    array_push($testIds, $value);
                }
            }

            if ($with_materials_menu_status) {
                if ($packageData[0]->show_videos == 1) {
                    $show_videos = true;
                    if (strlen($packageData[0]->addon_language) != 0) {
                        $addon_languages = explode(',', $packageData[0]->addon_language);
                    }
                }
                if ($packageData[0]->show_materials == 1) {
                    $show_materials = true;
                }
                if ($packageData[0]->show_class_links == 1) {
                    $show_class_links = true;
                }
            }
        }
    }

    if ($only_mock_test_ids) {
        $data['testIds'] = array_filter($testIds);
    }
    if ($with_materials_menu_status) {
        $data['show_videos'] = $show_videos;
        $data['addon_languages'] = $addon_languages;
        $data['show_materials'] = $show_materials;
        $data['show_class_links'] = $show_class_links;
    }

    $whereclause = array('studentId' => $studentId);
    $student = $CI->Iifl_info->getdata('studentuser', $whereclause);

    $student_coupon = $student[0]->ak_coupon_code;

    // lock practice questions if coupon not used
    if ($have_only_free_package && !is_coupon_used($student_coupon)) {
        get_free_practice_questions();
    }

    return $data;
}

function getStudentPackagePurchasesNotExpired($studentid, $only_ids = false)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $student_packages = $CI->Iifl_info->getdata('purchases', array('studentid' => $studentid, 'is_expired' => 0));

    $packages = [];
    if ($student_packages && count($student_packages) > 0) {
        foreach ($student_packages as $key => $package) {
            if (date('Y-m-d h:i:s') >= $package->expire_date) {
                $CI->Iifl_info->update('purchases', array('is_expired' => 1, 'last_updated' => date('Y-m-d h:i:s')), array('purchaseid' => $package->purchaseid));
                continue;
            }

            if ($only_ids) {
                $packages[] = $package->productid;
            } else {
                $packages[$package->productid] = $package;
            }
        }
    }
    return $packages;
}

// assigns on full mock test and returns its validity as response. Also sets the account validity for the new student
function assignFreeFullMockTestToNewStudent($studentid)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    // new package logic
    $free_package = $CI->Iifl_info->getdata('packages', array('usage_type' => PACKAGE_FREE, 'status' => 1));

    // if no free package found continue to old condition
    if ($free_package && count($free_package) == 0) {
        $free_package = $CI->Iifl_info->getdata('packages', array('cost' => 0, 'is_purchaseable' => 1, 'status' => 1));
    }

    if ($free_package && count($free_package) > 0) {
        $package_validity = $free_package[0]->duration . " " . $free_package[0]->duration_type . "s";
        $expire_on = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + ' . $package_validity));

        $db_data = array(
            'product' => $free_package[0]->package_name,
            'productid' => $free_package[0]->packageid,
            'studentid' => $studentid,
            'expire_date' => $expire_on,
            'create_date' => date('Y-m-d h:i:s')
        );
        $CI->Iifl_info->insert('purchases', $db_data);

        $update_data = array('validity' => $expire_on);
        $where = array('studentId' => $studentid);
        $CI->Iifl_info->update('studentuser', $update_data, $where);
        return $expire_on;
    } else {
        $default_expiry = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1 year'));
        $update_data = array('validity' => $default_expiry);
        $where = array('studentId' => $studentid);
        $CI->Iifl_info->update('studentuser', $update_data, $where);
        return $default_expiry;
    }
}

function assign_applykart_package_to_student($studentId, $coupon_code)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');
    $CI->load->model('package_model');
    $CI->load->model('purchase_model');

    $ak_package = $CI->package_model->get("", ['usage_type' => PACKAGE_APPLYKART, 'status' => 1]);

    if ($ak_package && count($ak_package) > 0) {
        $expire_on = get_package_expiry($ak_package);
        $package_included_tests = $ak_package[0]['category_type_ids'];
        $package_included_tests = explode(",", $package_included_tests);

        $data = array(
            'product' => $ak_package[0]['package_name'],
            'productid' => $ak_package[0]['packageid'],
            'studentid' => $studentId,
            'expire_date' => $expire_on,
            'create_date' => date('Y-m-d h:i:s')
        );

        $purchase_id = $CI->purchase_model->create($data);

        // update session ids
        $userTests = $CI->session->userdata('studentTestIds');
        $user_previous_test_ids = explode(",", $userTests);
        $user_new_test_ids = [...$user_previous_test_ids, ...$package_included_tests];
        $CI->session->set_userdata(['studentTestIds' => join(",", array_filter($user_new_test_ids))]);

        // updating account validity if purchased package expiry is greater than account validity
        extendAccountValidityWithPackageExpiry($studentId, $expire_on, true);
        if ($purchase_id) {
            $CI->db->insert('coupon_usage', [
                'coupon_code' => $coupon_code,
                'studentid' => $studentId,
                'purchaseid' => $purchase_id,
                'create_date' => date('Y-m-d H:i:s'),
            ]);

            unlock_practice_questions();
            return true;
        }
        return false;
    }

    return false;
}

function is_practice_available($category, $question_id)
{
    $CI = &get_instance();

    if (!$CI->session->userdata($category . '_free_practice_question_ids')) {
        return true;
    }

    $practice_ids = $CI->session->userdata($category . '_free_practice_question_ids');
    $practice_ids = explode(",", $practice_ids);

    if (in_array($question_id, $practice_ids)) {
        return true;
    }

    return false;
}

function get_free_practice_questions()
{
    $CI = &get_instance();
    $CI->load->library('session');

    try {
        unlock_practice_questions();

        $reading_questions = get_free_questions_per_category("reading");
        $speaking_questions = get_free_questions_per_category("speaking");
        $writing_questions = get_free_questions_per_category("writing");
        $listening_questions = get_free_questions_per_category("listening");

        $CI->session->set_userdata(['reading_free_practice_question_ids' => $reading_questions[0]['free_question_ids']]);
        $CI->session->set_userdata(['speaking_free_practice_question_ids' => $speaking_questions[0]['free_question_ids']]);
        $CI->session->set_userdata(['writing_free_practice_question_ids' => $writing_questions[0]['free_question_ids']]);
        $CI->session->set_userdata(['listening_free_practice_question_ids' => $listening_questions[0]['free_question_ids']]);
    } catch (Exception $e) {

    }
}

function unlock_practice_questions()
{
    $CI = &get_instance();
    $CI->load->library('session');

    $CI->session->unset_userdata('reading_free_practice_question_ids');
    $CI->session->unset_userdata('speaking_free_practice_question_ids');
    $CI->session->unset_userdata('writing_free_practice_question_ids');
    $CI->session->unset_userdata('listening_free_practice_question_ids');
}

function isAccountExpired($studentid, $validity)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $expire_on = date('Y-m-d h:i:s', strtotime($validity));
    $today = date('Y-m-d h:i:s');

    if ($expire_on > $today) {
        return false;
    }
    return true;
}

function extendAccountValidity($studentid, $newExpiry)
{
    $CI = &get_instance();
    $CI->load->model('Iifl_info');

    $update_data = array('validity' => $newExpiry);
    $where = array('studentId' => $studentid);
    $CI->Iifl_info->update('studentuser', $update_data, $where);

    return true;
}

function get_section_color_code($section)
{
    if (!$section) {
        return false;
    }

    $color_codes = array(
        'speaking' => 'rgb(169, 64, 68)',
        'writing' => 'rgb(45, 63, 169)',
        'reading' => 'rgb(30, 150, 147)',
        'listening' => 'rgb(148, 194, 60)',
    );

    return $color_codes[strtolower($section)];
}

function get_answer_details_by_id($post_data)
{
    $CI = &get_instance();

    $answer_id = $post_data['answer'];
    $answers_table = $post_data['model'] . '_answers';
    $questions_table = $post_data['model'] . '_questions';
    $CI->db->select('*,' . $questions_table . '.answer as actual_answer,' . $answers_table . '.answer as student_answer');
    $CI->db->join($questions_table, $answers_table . '.question_id=' . $questions_table . '.id');
    $CI->db->where($answers_table . '.id', $answer_id);
    $answer_data = $CI->db->get($answers_table)->row();
    $response = get_answer_details($answer_data);
    return $response;
}

function get_answer_details($answer_data)
{
    $response = [];
    if ($answer_data) {
        switch ($answer_data->question_type) {
            case 'fib_wr':
                $actual_answer = json_decode($answer_data->actual_answer);
                $student_answer = json_decode($answer_data->student_answer);
                $student_answer = array_map("trim", $student_answer);

                $mistakes = [];
                foreach ($actual_answer as $key => $row) {
                    if ($actual_answer[$key] == $student_answer[$key]) {
                        array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                    } else {
                        array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                    }
                }
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                $response['mistakes'] = join(', ', $mistakes);
                break;
            case 'fib_rd':
                $actual_answer = json_decode($answer_data->actual_answer);
                $student_answer = json_decode($answer_data->student_answer);
                $student_answer = array_map("trim", $student_answer);

                $mistakes = [];
                foreach ($actual_answer as $key => $row) {
                    if ($actual_answer[$key] == $student_answer[$key]) {
                        array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                    } else {
                        array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                    }
                }
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                $response['mistakes'] = join(', ', $mistakes);
                // $response['student_answer'] = $student_answer;
                // $response['actual_answer'] = $actual_answer;
                break;
            case 'l_fib':
                $actual_answer = json_decode($answer_data->actual_answer);
                $student_answer = json_decode($answer_data->student_answer);
                $student_answer = array_map("trim", $student_answer);

                $mistakes = [];
                foreach ($actual_answer as $key => $row) {
                    if ($actual_answer[$key] == $student_answer[$key]) {
                        array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                    } else {
                        array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                    }
                }
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                $response['mistakes'] = join(', ', $mistakes);
                // $response['student_answer'] = $student_answer;
                // $response['actual_answer'] = $actual_answer;
                break;
            case 'hiws':
                $actual_answer = json_decode($answer_data->actual_answer, true);
                $student_answer = json_decode($answer_data->student_answer);
                $incorrectWordsArr = array_diff($student_answer, array_keys($actual_answer));

                $mistakes = [];
                foreach ($student_answer as $key => $row) {
                    if (in_array($row, $incorrectWordsArr)) {
                        array_push($mistakes, '<span style="color:red;font-style: italic;">' . $student_answer[$key] . '</span>');
                    } else {
                        array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $student_answer[$key] . '</span>');
                    }
                }
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                $response['mistakes'] = join(', ', $mistakes);
                // $response['student_answer'] = $student_answer;
                // $response['actual_answer'] = $actual_answer;
                break;
            case 'essays':
                $c_score = json_decode($answer_data->component_score);
                $response['score'] = $answer_data->score;
                $response['component_score'] = $c_score;
                $response['mistakes'] = json_decode($answer_data->mistakes);
                break;
            case 'email':
                $c_score = json_decode($answer_data->component_score);
                $response['score'] = $answer_data->score;
                $response['component_score'] = $c_score;
                $response['mistakes'] = json_decode($answer_data->mistakes);
                break;
            case 'swtx':
                $c_score = json_decode($answer_data->component_score);
                $response['score'] = $answer_data->score;
                $response['component_score'] = $c_score;
                $response['mistakes'] = json_decode($answer_data->mistakes);
                break;
            case 'ssts':
                $c_score = json_decode($answer_data->component_score);
                $response['score'] = $answer_data->score;
                $response['component_score'] = $c_score;
                $response['mistakes'] = json_decode($answer_data->mistakes);
                break;
            case 'wfds':
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                $response['mistakes'] = json_decode($answer_data->mistakes);
            case 'read_alouds':
            case 'repeat_sentences':
            case 'describe_images':
            case 'retell_lectures':
            case 'answer_questions':
            case 'respond_situation':
                $c_score = json_decode($answer_data->component_score);
                $response['score'] = $answer_data->score;
                $response['component_score'] = $c_score;
                $response['answer_transcript'] = $answer_data->answer_transcript;
                $response['mistakes'] = json_decode($answer_data->mistakes);
                break;

            case 'l_mcm':
            case 'r_mcs':
            case 'r_mcm':
            case 'l_mcs':
            case 'l_hcs':
            case 'ro':
            case 'l_smw':
                $response['score'] = $answer_data->score;
                $response['suggestion'] = $answer_data->suggestion;
                break;
        }
    }
    return $response;
}

function get_study_videos()
{
    return array(
        'speaking' => array(
            [
                'title' => 'Speaking - Read Aloud Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/UvcwdNAPhsU',
            ],
            [
                'title' => 'Speaking - Read Aloud / Example',
                'url' => 'https://www.youtube.com/embed/9c7grBC1sDg',
            ],
            [
                'title' => 'Speaking - Repeat Sentence Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/Oh7-iRQ0XuE',
            ],
            [
                'title' => 'Speaking - Repeat Sentence / Example',
                'url' => 'https://www.youtube.com/embed/ng40cO-bIkI',
            ],
            [
                'title' => 'Speaking - Describe Image by Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/01JxSIELU9Q',
            ],
            [
                'title' => 'Speaking - Describe Image / Example',
                'url' => 'https://www.youtube.com/embed/UAVml42nKUw',
            ],
            [
                'title' => 'Speaking - Re-tell Lecture Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/hyEwLzAPd_U',
            ],
            [
                'title' => 'Speaking - Re-tell Lecture / Example',
                'url' => 'https://www.youtube.com/embed/0DAGLlEy_oQ',
            ],
            [
                'title' => 'Speaking - Answer Short Question Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/Jx0GfRPUj6g',
            ],
            [
                'title' => 'Speaking - Answer short Question / Example',
                'url' => 'https://www.youtube.com/embed/am5LIRShcmI',
            ],
        ),
        'writing' => array(
            [
                'title' => 'Writing - Summarise Written Text Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/9jAu-fYk1R4',
            ],
            [
                'title' => 'Writing - Summarise Written Text / Example',
                'url' => 'https://www.youtube.com/embed/S5qWgbptIyk',
            ],
            [
                'title' => 'Writing - Write Essay Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/ObkDKBYDM1Y',
            ],
            [
                'title' => 'Writing - Write essay / Example',
                'url' => 'https://www.youtube.com/embed/KixJY9C73cc',
            ],
        ),
        'reading' => array(
            [
                'title' => 'Reading - MCCMA Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/e06BJmkPWOY',
            ],
            [
                'title' => 'Reading - MCCMA / Example',
                'url' => 'https://www.youtube.com/embed/kh__bm4Cm8A',
            ],
            [
                'title' => 'Reading - Re-Order Paragraph Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/2h6-UHu-0C8',
            ],
            [
                'title' => 'Reading - Re-order Paragraph / Example',
                'url' => 'https://www.youtube.com/embed/YxzhuWoq-sg',
            ],
            [
                'title' => 'Reading - Fill in the Blanks Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/Z4t1wQLMMcI',
            ],
            [
                'title' => 'Reading - Fill in the Blanks / Example',
                'url' => 'https://www.youtube.com/embed/5J8tLDWtE2Y',
            ],
            [
                'title' => 'Reading - MCCSA Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/tKTScNg3vZs',
            ],
            [
                'title' => 'Reading - MCCSA / Example',
                'url' => 'https://www.youtube.com/embed/wKtghFyYag8',
            ],
            [
                'title' => 'Reading & Writing - Fill in the Blanks Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/cTMqFCAKh2Q',
            ],
            [
                'title' => 'Reading & Writing Fill in the Blanks / Example',
                'url' => 'https://www.youtube.com/embed/2nlOAHI2L_g',
            ],
        ),
        'listening' => array(
            [
                'title' => 'Listening - Summarize Spoken Text Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/qWv33lj1cXM',
            ],
            [
                'title' => 'Listening - Summarise Spoken Text / Example',
                'url' => 'https://www.youtube.com/embed/HQkQ2fWOBzs',
            ],
            [
                'title' => 'Listening - MCCMA Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/N_pE9HKM7SU',
            ],
            [
                'title' => 'Listening - MCCMA / Example',
                'url' => 'https://www.youtube.com/embed/jr4TuhZuSoc',
            ],
            [
                'title' => 'Listening - Fill in the blanks Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/cuRje-_vZmc',
            ],
            [
                'title' => 'Listening - Fill in the Blanks / Example',
                'url' => 'https://www.youtube.com/embed/y5B5EvYPwPU',
            ],
            [
                'title' => 'Listening - Highlight Correct Summary Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/7msB0rbsHN0',
            ],
            [
                'title' => 'Listening - highlight correct summary / Example',
                'url' => 'https://www.youtube.com/embed/Cn3M8sLPM4g',
            ],
            [
                'title' => 'Listening - MCCSA Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/W5HOWjcLuz4',
            ],
            [
                'title' => 'Listening - MCCSA / Example',
                'url' => 'https://www.youtube.com/embed/LoJiI7Uaieo',
            ],
            [
                'title' => 'Listening - Select Missing Word Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/sdF8D4nWBsk',
            ],
            [
                'title' => 'Listening - Select missing words / Example',
                'url' => 'https://www.youtube.com/embed/2SooOilNFjE',
            ],
            [
                'title' => 'Listening - Highlight Incorrect Words Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/-eduBJDbcAk',
            ],
            [
                'title' => 'Listening - Highlight incorrect words / Example',
                'url' => 'https://www.youtube.com/embed/ZjXQr2J4izY',
            ],
            [
                'title' => 'Listening - Write from Dictation Malcolm 2023 / Explanation',
                'url' => 'https://www.youtube.com/embed/thw-ip0yZiU',
            ],
            [
                'title' => 'Listening - Write from Dictation / Example',
                'url' => 'https://www.youtube.com/embed/JnYy9JZOJ6E',
            ],
        ),
    );
}

function get_user_id()
{
    return get_instance()->session->has_userdata('studentId');
}

function get_user_full_name()
{
    return get_instance()->session->has_userdata('name');
}

function get_current_pte_type(){
    $CI = &get_instance();
    $CI->load->library('session');

    return $CI->session->userdata('pte_type') == PTECORE ? PTECORE : PTEACADEMIC;
}