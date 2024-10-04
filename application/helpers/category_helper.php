<?php  
    defined('BASEPATH') or exit('No direct script access allowed');

    function getCategoryDataByCode($qcode){
        $codes = array(
            'read_alouds'           =>  [
                'name' => 'Read Aloud',
                'code_name' => 'RA',
                'category' => 'speaking'
            ],
            'repeat_sentences'      =>  [
                'name' => 'Repeat Sentences',
                'code_name' => 'RS',
                'category' => 'speaking'
            ],
            'respond_situation'      =>  [
                'name' => 'Respond to a situation',
                'code_name' => 'RTS',
                'category' => 'speaking'
            ],
            'describe_images'       =>  [
                'name' => 'Describe Image',
                'code_name' => 'DI',
                'category' => 'speaking'
            ],
            'retell_lectures'       =>  [
                'name' => 'Re-tell Lecture',
                'code_name' => 'RL',
                'category' => 'speaking'
            ],
            'answer_questions'      =>  [
                'name' => 'Answer Short Question',
                'code_name' => 'ASQ',
                'category' => 'speaking'
            ],
            'fib_wr'                =>  [
                'name' => 'Reading & Writing：Fill in the blanks',
                'code_name' => 'FIB-RW',
                'category' => 'reading'
            ],
            'fib_rd'                =>  [
                'name' => 'Reading：Fill in the Blanks',
                'code_name' => 'FIB-R',
                'category' => 'reading'
            ],
            'r_mcm'                 =>  [
                'name' => 'Multiple Choice (Multiple)',
                'code_name' => 'MCM-R',
                'category' => 'reading'
            ],
            'r_mcs'                 =>  [
                'name' => 'Multiple Choice (Single)',
                'code_name' => 'MCS-R',
                'category' => 'reading'
            ],
            'ro'                    =>  [
                'name' => 'Re-order Paragraphs',
                'code_name' => 'RO',
                'category' => 'reading'
            ],
            'swtx'                  =>  [
                'name' => 'Summarize Written Text',
                'code_name' => 'SWT',
                'category' => 'writing'
            ],
            'essays'                =>  [
                'name' => 'Write Essay',
                'code_name' => 'ESSAYS',
                'category' => 'writing'
            ],
            'email'                =>  [
                'name' => 'Write Email',
                'code_name' => 'EMAIL',
                'category' => 'writing'
            ],
            'ssts'                  =>  [
                'name' => 'Summarize Spoken Text',
                'code_name' => 'SST',
                'category' => 'listening'
            ],
            'wfds'                  =>  [
                'name' => 'Write From Dictation',
                'code_name' => 'WFD',
                'category' => 'listening'
            ],
            'l_mcm'                 =>  [
                'name' => 'Multiple Choice (Multiple)',
                'code_name' => 'MCM-L',
                'category' => 'listening'
            ],
            'l_mcs'                 =>  [
                'name' => 'Multiple Choice (Single)',
                'code_name' => 'MCS-L',
                'category' => 'listening'
            ],
            'l_hcs'                 =>  [
                'name' => 'Highlight Correct Summary',
                'code_name' => 'HCS',
                'category' => 'listening'
            ],
            'l_smw'                 =>  [
                'name' => 'Select Missing Word',
                'code_name' => 'SMW',
                'category' => 'listening'
            ],
            'l_fib'                 =>  [
                'name' => 'Fill in the Blanks',
                'code_name' => 'FIB-L',
                'category' => 'listening'
            ],
            'hiws'                  =>  [
                'name' => 'Highlight Incorrect Words',
                'code_name' => 'HIWS',
                'category' => 'listening'
            ],
        );

        return $codes[$qcode];
    }
    
    function get_category_sub_categories($category){
        $sub_categories = array(
            'speaking'  =>  ['read_alouds','repeat_sentences','describe_images','retell_lectures','answer_questions'],
            'reading'   =>  ['fib_wr','fib_rd','r_mcm','r_mcs','ro'],
            'writing'   =>  ['swtx','essays'],
            'listening' =>  ['ssts','wfds','l_mcm','l_mcs','l_hcs','l_smw','l_fib','hiws'],
        );

        return $sub_categories[$category];
    }