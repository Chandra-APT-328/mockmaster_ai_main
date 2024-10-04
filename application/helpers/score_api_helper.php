<?php

defined('BASEPATH') or exit('No direct script access allowed');

function calcGrammarScore($total_mistakes){
    $grammar = 0;
    // logic update | 02-09 | deduct 0.5 for every two mistakes in grammer and if odd then -1
    $total_mistakes = $total_mistakes % 2 == 0 ? $total_mistakes / 2 : ($total_mistakes - 1) / 2;
    $total_mistakes *= 0.5;
    $grammar = 2 - $total_mistakes;

    if($grammar < 0){
        $grammar = 0;
    }

    return $grammar;
}

function calcSpellingScore($total_mistakes){
    $spelling = 0;
    // logic update | 02-09 | deduct 0.5 for every two mistakes in spelling and if odd then -1
    $total_mistakes = $total_mistakes % 2 == 0 ? $total_mistakes / 2 : ($total_mistakes - 1) / 2;
    $total_mistakes *= 0.5;
    $spelling = 2 - $total_mistakes;

    if($spelling < 0){
        $spelling = 0;
    }

    return $spelling;
}

function getsstsscores($input,$keywords){

    $grammar = 0;
    $grammar_mistakes = 0;
    $spelling = 0;
    $spelling_mistakes = 0;
    $vocabulary = 0;
    $form = 0;
    $content = 0;

    //calc content
    if(strlen($keywords) > 0){
        $_content = 0;
        $keywords = array_map('trim',explode(',',$keywords));

        $matches = array();

        foreach ($keywords as $keyword) {
            if (stripos($input, $keyword) !== false) {
                array_push($matches, $keyword);
                $_content += 1;
            }
        }

        if(count($matches) > 3){
            $content = 2;
        }

        if(count($matches) >= 1 && count($matches) <= 3){
            $content = 1;
        }

        if($content == 0){
            $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'spelling' => $spelling, 'vocabulary' => $vocabulary, 'form' => $form);
            return $data;
        }
    }

    $dataResponse = getGrammerScores($input, false, "gpt");

    $editResponse = $dataResponse['editResponse'];
    $vocabularyResponse = $dataResponse['vocabularyResponse'];
    // $errCates = $dataResponse['errCates'];
    // $errSubCates = $dataResponse['errSubCates'];

    foreach($editResponse['edits'] as $error => $row){
        if($row['error type'] == 'Spelling.' || $row['error type'] == 'spelling.' || $row['error type'] == 'Spelling'){
            ++$spelling_mistakes;
        }
        if($row['error type'] == 'General error/Grammar error' || $row['error_type'] == 'Other'){
            ++$grammar_mistakes;
        }
    }

    if($content != 0){
        // calc form
        $totalWords = $vocabularyResponse['words'];

        switch (get_current_pte_type()) {
            case PTECORE:
                if (($totalWords >= 5 && $totalWords < 19) || ($totalWords >= 31 && $totalWords < 40)) {
                    $form = 1;
                }

                if ($totalWords >= 20 && $totalWords <= 30) {
                    $form = 2;
                }
                break;
            default:
                if ($totalWords >= 71 && $totalWords < 100) {
                    $form = 1;
                }

                if ($totalWords >= 50 && $totalWords <= 70) {
                    $form = 2;
                }
                break;
        }
    }

    if($form != 0){
        // calc vocabulary
        if(count($vocabularyResponse) > 0){
            $_vocabulary = $vocabularyResponse['readability'];
        }

        if($_vocabulary >= 3 && $_vocabulary < 6){
            $vocabulary = 1;
        }
        
        if($_vocabulary >= 6){
            $vocabulary = 2;
        }


        //calc grammar
        $grammar = calcGrammarScore($grammar_mistakes);
        
        //calc spelling 
        $spelling = calcSpellingScore($spelling_mistakes);
        
    }

    $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'spelling' => $spelling, 'vocabulary' => $vocabulary, 'form' => $form);

    usort($editResponse['edits'], function ($a, $b) {
        if ($a['sentence start'] == $b['sentence start']) {
            return $b['start'] - $a['start'];
        }
        return $b['sentence start'] - $a['sentence start'];
    });

    $changes = []; // Array to track changes
    // echo '<pre>';echo(json_encode($editResponse));exit;
    foreach ($editResponse["edits"] as $edit) {
        if(isset($edit["sentence start"])){
            $error = $edit["error type"];
            $start = $edit["sentence start"] + $edit["start"] - 1;
            $end = $edit["sentence start"] + $edit["end"];
            // $errType = explode(':',$edit['error type']);

            // Check if the current edit overlaps with any previous changes
            $skipEdit = false;
            foreach ($changes as $change) {
                if (($start >= $change['start'] && $start <= $change['end']) || ($end >= $change['start'] && $end <= $change['end'])) {
                    $skipEdit = true;
                    break;
                }
            }

            // If overlapping with previous change, skip this edit
            if ($skipEdit) {
                continue;
            }

            if($error != "Spacing"){
                // line through if no replacement available
                $replacement_style = "";
                if(strlen(trim($edit["replacement"])) == 0){
                    $replacement_style = "text-decoration: line-through;";
                }
    
                $tooltip = '<span style="color: red;'.$replacement_style.'" data-container="body" data-toggle="popover"  data-trigger="hover" data-placement="top" data-content="Suggestion: replacing `'.mb_substr($input,$start,$end - $start).'` with 	`'.$edit["replacement"].'`" title="" data-original-title="'.trim($error).'">'.mb_substr($input,$start,$end - $start).'</span>';
                $input = substr_replace($input, $tooltip, $start, $end - $start);
                $changes[] = ['start' => $start, 'end' => $start + strlen($tooltip)];
            }
        }
    }

    $data['mistakes'] = $input;
    return $data;
}

function getessayscores($input,$keywords){

    $grammar = 0;
    $grammar_mistakes = 0;
    $spelling = 0;
    $spelling_mistakes = 0;
    $vocabulary = 0;
    $form = 0;
    $structure = 0;
    $linguistic_range = 0;
    $content = 0;

    //calc content
    if(strlen($keywords) > 0){
        $_content = 0;
        $keywords = array_map('trim', explode(',',$keywords));

        $matches = array();

        foreach ($keywords as $keyword) {
            if (stripos($input, $keyword) !== false) {
                array_push($matches, $keyword);
                $_content += 1;
            }
        }

        if(count($matches) >= 1 && count($matches) <= 2){
            $content = 1;
        }
        
        if(count($matches) >= 3 && count($matches) <= 4){
            $content = 2;
        }
        
        if(count($matches) >= 5){
            $content = 3;
        }

        if($content == 0){
            $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'spelling' => $spelling, 'vocabulary' => $vocabulary, 'form' => $form, 'structure' => $structure, 'linguistic' => $linguistic_range);
            return $data;
        }
    }

    $dataResponse = getGrammerScores($input, false, "gpt");

    $editResponse = $dataResponse['editResponse'];
    $vocabularyResponse = $dataResponse['vocabularyResponse'];
    // $errCates = $dataResponse['errCates'];
    // $errSubCates = $dataResponse['errSubCates'];

    foreach($editResponse['edits'] as $error => $row){
        // echo $row['general_error_type'];
        if($row['error type'] == 'Spelling.' || $row['error type'] == 'spelling.' || $row['error type'] == 'Spelling'){
            ++$spelling_mistakes;
        }
        if($row['error type'] == 'General error/Grammar error' || stripos($row['error type'], 'Grammer') || $row['general_error_type'] == 'Other'){
            ++$grammar_mistakes;
        }
    }

    if($content != 0){
        // calc form
        $totalWords = $vocabularyResponse['words'];
        
        if($totalWords >= 120 && $totalWords < 199 || $totalWords >= 301 && $totalWords < 380){
            $form = 1;
        }

        if($totalWords >= 200 && $totalWords < 300){
            $form = 2;
        }

        if(mb_strtoupper($input, 'utf-8') == $input){
            $form = 0;
        }
    }

    if($form != 0){
        // calc Development, structure and coherence
        $paragraphs = explode("\n", $input);
        $paragraphs = array_filter($paragraphs,'trim');
        
        if(count($paragraphs) > 5 || count($paragraphs) == 0){
            $structure = 0;
        }

        if(count($paragraphs) == 1 || count($paragraphs) == 2){
            $structure = 1;
        }

        if(count($paragraphs) >= 3 && count($paragraphs) <= 5){
            $structure = 2;
        }
        
        // calc linguistic range
        if(count($vocabularyResponse) > 0){
            $_linguistic = $vocabularyResponse['readability'];
        }

        if($_linguistic <= 5){
            $linguistic_range = 1;
        }
        
        if($_linguistic > 5){
            $linguistic_range = 2;
        }

        // calc vocabulary
        if(count($vocabularyResponse) > 0){
            $_vocabulary = $vocabularyResponse['readability'];
        }

        if($_vocabulary >= 7 && $_vocabulary < 12){
            $vocabulary = 1;
        }
        
        if($_vocabulary >= 12){
            $vocabulary = 2;
        }


        //calc grammar
        $grammar = calcGrammarScore($grammar_mistakes);
        
        //calc spelling 
        $spelling = calcSpellingScore($spelling_mistakes);
    }

    $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'spelling' => $spelling, 'vocabulary' => $vocabulary, 'form' => $form, 'structure' => $structure, 'linguistic' => $linguistic_range);

    usort($editResponse['edits'], function ($a, $b) {
        if ($a['sentence start'] == $b['sentence start']) {
            return $b['start'] - $a['start'];
        }
        return $b['sentence start'] - $a['sentence start'];
    });

    $changes = []; // Array to track changes
    foreach ($editResponse["edits"] as $edit) {
        if(isset($edit["sentence start"])){
            $error = $edit["error type"];
            $start = $edit["sentence start"] + $edit["start"] - 1;
            $end = $edit["sentence start"] + $edit["end"];
            // $errType = explode(':',$edit['error type']);

            // Check if the current edit overlaps with any previous changes
            $skipEdit = false;
            foreach ($changes as $change) {
                if (($start >= $change['start'] && $start <= $change['end']) || ($end >= $change['start'] && $end <= $change['end'])) {
                    $skipEdit = true;
                    break;
                }
            }

            // If overlapping with previous change, skip this edit
            if ($skipEdit) {
                continue;
            }

            // line through if no replacement available
            $replacement_style = "";
            if(strlen(trim($edit["replacement"])) == 0){
                $replacement_style = "text-decoration: line-through;";
            }

            $tooltip = '<span style="color: red;'.$replacement_style.'" data-container="body" data-toggle="popover"  data-trigger="hover" data-placement="top" data-content="Suggestion: replacing `'.mb_substr($input,$start,$end - $start).'` with 	`'.$edit["replacement"].'`" title="" data-original-title="'.trim($error).'">'.mb_substr($input,$start,$end - $start).'</span>';
            $input = substr_replace($input, $tooltip, $start, $end - $start);
            
            // Track the change with new start and end
            $changes[] = ['start' => $start, 'end' => $start + strlen($tooltip)];
        }
    }

    $data['mistakes'] = nl2br($input);
    return $data;
}
// created by AKSHITA . R . BHATT    
// start
function getemailscores($input, $keywords, $check_reasons){
    
    $grammar = 0;
    $_grammar = 0;
    $spelling = 0;
    $vocabulary = 0;
    $form = 0;
    $organization = 0;
    $convention = 0;
    $content = 0;

    // form
    $totalWords = countWords($input);

    if($totalWords >= 30 && $totalWords < 50 || $totalWords >= 121 && $totalWords < 140){
        $form = 1;
    }

    if($totalWords >= 50 && $totalWords <= 120){
        $form = 2;
    }

    if(mb_strtoupper($input, 'utf-8') == $input){
        $form = 0;
    }

    if($form == 0){
        $data['scores'] = array(
            'content' => $content, 
            'grammar' => $grammar, 
            'spelling' => $spelling, 
            'vocabulary' => $vocabulary, 
            'form' => $form, 
            'organization' => $organization, 
            'convention' => $convention);
        return $data;
    }

    // Check if all themes are present in the email body
    $satisfied_reasons = checkEmailThemes($check_reasons, $input);

    // Check if email follows conventions
    $email_convention = checkEmailConventions($input);

    // Check paragraphs in the email body and classify them
    $organization = checkParagraphs($input);
    
    //calc content
    if(strlen($keywords) > 0){
        $_content = 0;

        $keywords = array_map('trim', explode(',',$keywords));

        $matches = array();

        foreach ($keywords as $keyword) {
            if (stripos($input, $keyword) !== false) {
                array_push($matches, $keyword);
                $_content += 1;
            }
        }

        if($satisfied_reasons == 1){
            $content = 1;
        }
        
        if(($satisfied_reasons == (count($check_reasons) - 1)) || ($satisfied_reasons == count($check_reasons) && count($matches) == 0)){
            $content = 2;
        }
        
        if(count($matches) >= 5 && $satisfied_reasons == count($check_reasons)){
            $content = 3;
        }

        if($content == 0){
            $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'spelling' => $spelling, 'vocabulary' => $vocabulary, 'form' => $form, 'organization' => $organization, 'convention' => $convention);
            return $data;
        }
    }

    // conventions
    if(($email_convention['salutation'] == false && $email_convention['closing'] == true) || ($email_convention['salutation'] == true && $email_convention['closing'] == false)){
        $convention = 1;
    }

    if($email_convention['salutation'] == true && $email_convention['closing'] == true){
        $convention = 2;
    }

    // echo "<pre>";var_dump($input);exit;

    $dataResponse = getGrammerScores($input, false, "gpt");

    $editResponse = $dataResponse['editResponse'];
    $vocabularyResponse = $dataResponse['vocabularyResponse'];

    foreach($editResponse['edits'] as $error => $row){
        // echo $row['general_error_type'];
        if($row['error type'] == 'Spelling.' || $row['error type'] == 'spelling.' || $row['error type'] == 'Spelling'){
            ++$_spelling;
        }
        if($row['error type'] == 'General error/Grammar error' || stripos($row['error type'], 'Grammer') || $row['general_error_type'] == 'Other'){
            ++$_grammar;
        }
    }

    if($form != 0 && $content != 0){
        // calc vocabulary
        if(count($vocabularyResponse) > 0){
            $_vocabulary = $vocabularyResponse['readability'];
        }

        if($_vocabulary >= 7 && $_vocabulary < 12){
            $vocabulary = 1;
        }
        
        if($_vocabulary >= 12){
            $vocabulary = 2;
        }


        //calc grammar
        $_grammar = $_grammar * 0.5;
        $grammar = 2 - $_grammar;
        
        if($grammar < 0){
            $grammar = 0;
        }
        
        //calc spelling 
        if($_spelling == 1){
            $spelling = 1;
        }

        if($_spelling == 0){
            $spelling = 2;
        }
    }

    $data['scores'] = array(
        'content' => $content, 
        'grammar' => $grammar, 
        'spelling' => $spelling, 
        'vocabulary' => $vocabulary, 
        'form' => $form, 
        'organization' => $organization, 
        'convention' => $convention);

    usort($editResponse['edits'], function ($a, $b) {
        if ($a['sentence start'] == $b['sentence start']) {
            return $b['start'] - $a['start'];
        }
        return $b['sentence start'] - $a['sentence start'];
    });

    foreach ($editResponse["edits"] as $edit) {
        if(isset($edit["sentence start"])){
            $error = $edit["error type"];
            $start = $edit["sentence start"] + $edit["start"] - 1;
            $end = $edit["sentence start"] + $edit["end"];
            // $errType = explode(':',$edit['error type']);

            // line through if no replacement available
            $replacement_style = "";
            if(strlen(trim($edit["replacement"])) == 0){
                $replacement_style = "text-decoration: line-through;";
            }
            
            $tooltip = '<span style="color: red;'.$replacement_style.'" data-container="body" data-toggle="popover"  data-trigger="hover" data-placement="top" data-content="Suggestion: replacing `'.mb_substr($input,$start,$end - $start).'` with 	`'.$edit["replacement"].'`" title="" data-original-title="'.trim($error).'">'.mb_substr($input,$start,$end - $start).'</span>';
            $input = substr_replace($input, $tooltip, $start, $end - $start);
        }
    }

    $data['mistakes'] = nl2br($input);
    return $data;
}

// end

function getswtxscores($input,$keywords, $sample_input){
    $grammar = 0;
    $grammar_mistakes = 0;
    $vocabulary = 0;
    $form = 0;
    $content = 0;

    //calc content
    if(strlen($keywords) > 0){
        $_content = 0;
        $keywords = array_map('trim', explode(',',$keywords));
        $matches = array();

        foreach ($keywords as $keyword) {
            if (stripos($input, $keyword) !== false) {
                array_push($matches, $keyword);
                $_content += 1;
            }
        }

        $percent_content_match = round((count($matches) / count($keywords)) * 100);
        if($percent_content_match < 10){
            $content = 0;
        }	
        if($percent_content_match > 10 && $percent_content_match <= 25){
            $content = 0.5;
        }	
        if($percent_content_match > 25 && $percent_content_match <= 50){
            $content = 1;
        }	
        if($percent_content_match > 50 && $percent_content_match <= 75){
            $content = 1.5;
        }	
        if($percent_content_match > 75 && $percent_content_match <= 100){
            $content = 2;
        }	

        if($content == 0){
            $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'vocabulary' => $vocabulary, 'form' => $form);
            return $data;
        }
    }

    // if total sentence != 1 score == 0 | Abhishek asked only swtx
    if(countSentences($input) != 1){
        $data['scores'] = array('content' => 0, 'grammar' => 0, 'vocabulary' => 0, 'form' => 0);
        return $data;
    }

    $dataResponse = getGrammerScores($input, $sample_input, "gpt");
    $editResponse = $dataResponse['editResponse'];
    $vocabularyResponse = $dataResponse['vocabularyResponse'];
    // $errCates = $dataResponse['errCates'];
    // $errSubCates = $dataResponse['errSubCates'];

    foreach($editResponse['edits'] as $error => $row){
        if($row['error type'] == 'General error/Grammar error' || $row['general_error_type'] == 'Other'){
            ++$grammar_mistakes;
        }
    }

    if($content != 0){
        // calc form
        $totalWords = $vocabularyResponse['words'];

        //removed "&& $vocabularyResponse['sentences'] == 1 from condition"
        if($totalWords > 5 && $totalWords < 76  && $vocabularyResponse['sentences'] == 1){
            $form = 1;
        }
    }

    if($form != 0){
        // calc vocabulary
        if(count($vocabularyResponse) > 0){
            $_vocabulary = $vocabularyResponse['readability'];
        }

        if($_vocabulary >= 7 && $_vocabulary < 12){
            $vocabulary = 1;
        }
        
        if($_vocabulary >= 12){
            $vocabulary = 2;
        }


        //calc grammar
        $grammar = calcGrammarScore($grammar_mistakes);
    }

    $data['scores'] = array('content' => $content, 'grammar' => $grammar, 'vocabulary' => $vocabulary, 'form' => $form);

    usort($editResponse['edits'], function ($a, $b) {
        if ($a['sentence start'] == $b['sentence start']) {
            return $b['start'] - $a['start'];
        }
        return $b['sentence start'] - $a['sentence start'];
    });
    
    $changes = []; // Array to track changes
    foreach ($editResponse["edits"] as $edit) {
        if(isset($edit["sentence start"])){
            $error = $edit["error type"];
            $start = $edit["sentence start"] + $edit["start"] - 1;
            $end = $edit["sentence start"] + $edit["end"];
            $errType = explode(':',$edit['error type']);

            // Check if the current edit overlaps with any previous changes
            $skipEdit = false;
            foreach ($changes as $change) {
                if (($start >= $change['start'] && $start <= $change['end']) || ($end >= $change['start'] && $end <= $change['end'])) {
                    $skipEdit = true;
                    break;
                }
            }

            // If overlapping with previous change, skip this edit
            if ($skipEdit) {
                continue;
            }

            // line through if no replacement available
            $replacement_style = "";
            if(strlen(trim($edit["replacement"])) == 0){
                $replacement_style = "text-decoration: line-through;";
            }
            
            $tooltip = '<span style="color: red;'.$replacement_style.'" data-container="body" data-toggle="popover"  data-trigger="hover" data-placement="top" data-content="Suggestion: replacing `'.mb_substr($input,$start,$end - $start).'` with 	`'.$edit["replacement"].'`" title="" data-original-title="'.trim($error).'">'.mb_substr($input,$start,$end - $start).'</span>';
            $input = substr_replace($input, $tooltip, $start, $end - $start);
            $changes[] = ['start' => $start, 'end' => $start + strlen($tooltip)];
        }
    }

    $data['mistakes'] = $input;
    // echo '<pre>';var_dump($data);exit;
    return $data;
}

function getSpeakingScores($audioPath, $transcript, $strict_mode = "non-strict")
{
    $audioPath = str_replace(base_url(), '', $audioPath);
    $cleaned_text = preg_replace("/<[^>]*>/", "", $transcript);
    $transcript = preg_replace("/\r?\n/", "", $cleaned_text);

    $transcript = explode(' ', $transcript);
    if (count($transcript) >= 200) {
        $transcript = array_slice($transcript, 0, 199);
    }
    $transcript = implode(' ', $transcript);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://103.138.244.114:8000/audio_api/process_audio',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('transcription' => $transcript, 'audio_file' => new CURLFILE($audioPath), 'content_model' => $strict_mode),
        CURLOPT_HTTPHEADER => array('Authorization: CQ3tX3dg*AIdd7xh'),
    )
    );

    $response = curl_exec($curl);

    if($response == false){
        return $response;
    }
    
    curl_close($curl);

    $outputArr = json_decode($response, true);

    $content = $outputArr['content'];
    $overall_pronunciation = $outputArr['pronunciation'];

    $mistakes = "";
    $outputArr['result']['overall'] = $outputArr['content'];

    if($outputArr['word_level_probability']){
        $_transcript_array = preg_split("/[\s-]+/", $outputArr['transcription']);
        foreach ($_transcript_array as $key => $row) {
            if(trim($row) == trim($outputArr['word_level_probability'][$key][0])){
                if($outputArr['word_level_probability'][$key][1] >= 0.7){
                    $mistakes .= ' <span style="color:#22b922;">'.$row.'</span>';
                }elseif($outputArr['word_level_probability'][$key][1] < 0.7 && $outputArr['word_level_probability'][$key][1] > 0.2){
                    $mistakes .= ' <span style="color:#ffbf00;">'.$row.'</span>';
                }else{
                    $mistakes .= ' <span style="color:red;">'.$row.'</span>';
                }
            }else{
                $mistakes .= ' <span style="color:red;">'.$row.'</span>';
            }
        }
    }

    $outputArr['result']['fluency'] = $outputArr['fluency'];
    $outputArr['result']['pronunciation'] = $outputArr['pronunciation'];
    $outputArr['result']['transcription'] = $outputArr['transcription'];
    $outputArr['result']['mistakes'] = strlen($mistakes) > 0 ? $mistakes : $outputArr['transcription'];

    $words = explode("/", $transcript);
    $words = array_filter($words, 'rtrim');
    $words = array_filter($words, 'ltrim');


    $asq_content = 0;

    $search = preg_replace('/\p{P}/', '', $outputArr['transcription']);
    foreach ($words as $key => $word) {
        $word = ltrim($word);
        $word = rtrim($word);
        if (strtolower($search) == strtolower($word)) {
            $asq_content = 1;
        }
    }

    $outputArr['result']['content-asq'] = $asq_content;

    return $outputArr;
}

function getGrammerScores($input, $sample_input = false, $approach = "non-gpt"){

    $curl = curl_init();

    $field_data = array(
        "text"=> $input,
        "approach"=> $approach
    );
    
    if($sample_input && strlen($sample_input) > 0){
        $field_data['input_text'] = $sample_input;
    }
    
    curl_setopt_array($curl, array(
    CURLOPT_URL => CORRECT_GRAMMER_API,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode($field_data),
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: CQ3tX3dg*AIdd7xh'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    

    $data['editResponse'] = json_decode($response, true);
    $getReadability = getReadability($input);
    $getTextMetrics = getTextMetrics($input);

    // $readtime_in_min = explode(' ',$data['getReadTime']['readtime_in_minutes']);

    $matches = array();
    preg_match("/'([^']+)'/", $getReadability['readability_metric'] , $matches);
     
    $vocab = $matches[1];
   if($getReadability['readability_metric'] == "None" || $getReadability['readability_metric'] == "none"){
      $vocab = intval($getReadability['textstat_metric']);
   }
    $vocabularyResponse = array(
    	"chars"=>$getTextMetrics['number_of_total_characters'],
    	"readability"=>$vocab,
        "sentences" => countSentences($input),
    	// "reading_time_min"=>$readtime_in_min[0],
    	// "reading_time_sec"=>$data['getReadTime']['readtime_in_seconds'],
    	"words"=>$getTextMetrics['number_of_words']
    );

    $data['vocabularyResponse'] = $vocabularyResponse;
    //removed "sentences"=>1, from $vocabularyResponse

    // echo '<pre>';
    // print_r($data); exit;
    return $data;
}

function countSentences($str){
	// return preg_match_all('/[^\s](\.|\!|\?)(?!\w)/',$str,$match); This prevents abbreviations like "Mr." from being counted as separate sentences.
	return preg_match_all('/[^\s](\.|\!|\?)/',$str,$match);
}

function getReadTime($input){
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://103.138.244.114:8000/text_api/get_readtime',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
            "text":'.json_encode($input).',
            "wpm" : 200
        }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: CQ3tX3dg*AIdd7xh'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);

    $outputArr = json_decode($response, true);

    return $outputArr;
}

function getReadability($input){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://103.138.244.114:8000/text_api/get_kincaid_grade',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'    {
            "text":'.json_encode($input).'
        }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: CQ3tX3dg*AIdd7xh'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $outputArr = json_decode($response, true);

    return $outputArr;
}

function getTextMetrics($input){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://103.138.244.114:8000/text_api/get_metrics_from_text',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{"text":'.json_encode($input).'}',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: CQ3tX3dg*AIdd7xh'
    ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $outputArr = json_decode($response, true);
    return $outputArr;
}

function get_describe_image_scores($user_response, $keywords){
    $score = getSpeakingScores($user_response, $keywords);

    if(isset($score['result'])){
        $keywords = explode(",", $keywords);
        $keywords = array_filter(array_map('trim',$keywords));
        $words_spoken = explode(" ", $score['result']['transcription']);
        $words_spoken = array_filter(array_map('trim',$words_spoken));

        $content_matches = 0;
        $overall_content = 0;

        foreach($words_spoken as $word){
            foreach($keywords as $keyword){
                if(strtolower($keyword) == strtolower(preg_replace('/\p{P}/', '', $word))){
                    $content_matches += 1;
                }
            }
        }
        if($content_matches == 0){
            $overall_content = 5;
        }	
        if($content_matches == 1){
            $overall_content = 15;
        }	
        if($content_matches == 2){
            $overall_content = 30;
        }	
        if($content_matches >= 3 && $content_matches <= 4){
            $overall_content = 60;
        }	
        if($content_matches >= 5){
            $overall_content = 90;
        }	

        if($score['result']['fluency'] < 50){
            $fluency_score = $score['result']['fluency'] + 20;
        }else if($score['result']['fluency'] < 60){
            $fluency_score = $score['result']['fluency'] + 18;
        }else if($score['result']['fluency'] < 70){
            $fluency_score = $score['result']['fluency'] + 13;
        }else if($score['result']['fluency'] < 75){
            $fluency_score = $score['result']['fluency'] + 10;
        }else{
            $fluency_score = $score['result']['fluency'];
        }

        if($score['result']['pronunciation'] < 50){
            $pronunciation_score = $score['result']['pronunciation'] + 20;
        }else if($score['result']['pronunciation'] < 60){
            $pronunciation_score = $score['result']['pronunciation'] + 18;
        }else if($score['result']['pronunciation'] < 70){
            $pronunciation_score = $score['result']['pronunciation'] + 13;
        }else if($score['result']['pronunciation'] < 75){
            $pronunciation_score = $score['result']['pronunciation'] + 10;
        }else{
            $pronunciation_score = $score['result']['pronunciation'];
        }

        $score['result']['overall'] = $overall_content < 85 ? $overall_content + 5 : $overall_content;
        $score['result']['fluency'] = $fluency_score < 85 ? $fluency_score + 5 : $fluency_score;
        $score['result']['pronunciation'] = $pronunciation_score < 85 ? $pronunciation_score + 5 : $pronunciation_score;
        return $score;
    }
    return false;
}

function get_retell_lecture_scores($user_response, $keywords){
    $score = getSpeakingScores($user_response, $keywords, "strict");

    if(isset($score['result'])){
        $keywords = explode(",", $keywords);
        $keywords = array_filter(array_map('trim',$keywords));
        $words_spoken = explode(" ", $score['result']['transcription']);
        $words_spoken = array_filter(array_map('trim',$words_spoken));

        $content_matches = 0;
        $overall_content = 0;

        foreach($words_spoken as $word){
            foreach($keywords as $keyword){
                if(strtolower($keyword) == strtolower(preg_replace('/\p{P}/', '', $word))){
                    $content_matches += 1;
                }
            }
        }

        $percent_content_match = round(($content_matches / count($keywords)) * 100);
        if($percent_content_match >= 1 && $percent_content_match <= 5){
            $overall_content = 50;
        }	
        if($percent_content_match > 5 && $percent_content_match <= 10){
            $overall_content = 60;
        }
        if($percent_content_match > 10 && $percent_content_match <= 15){
            $overall_content = 70;
        }
        if($percent_content_match > 15 && $percent_content_match <= 20){
            $overall_content = 75;
        }
        if($percent_content_match > 20 && $percent_content_match <= 25){
            $overall_content = 80;
        }
        if($percent_content_match > 25 && $percent_content_match <= 30){
            $overall_content = 85;
        }
        if($percent_content_match > 30){
            $overall_content = 90;
        }

        if($score['result']['fluency'] < 50){
            $fluency_score = $score['result']['fluency'] + 20;
        }else if($score['result']['fluency'] < 60){
            $fluency_score = $score['result']['fluency'] + 18;
        }else if($score['result']['fluency'] < 70){
            $fluency_score = $score['result']['fluency'] + 13;
        }else if($score['result']['fluency'] < 75){
            $fluency_score = $score['result']['fluency'] + 10;
        }else{
            $fluency_score = $score['result']['fluency'];
        }
        
        if($score['result']['pronunciation'] < 50){
            $pronunciation_score = $score['result']['pronunciation'] + 20;
        }else if($score['result']['pronunciation'] < 60){
            $pronunciation_score = $score['result']['pronunciation'] + 18;
        }else if($score['result']['pronunciation'] < 70){
            $pronunciation_score = $score['result']['pronunciation'] + 13;
        }else if($score['result']['pronunciation'] < 75){
            $pronunciation_score = $score['result']['pronunciation'] + 10;
        }else{
            $pronunciation_score = $score['result']['pronunciation'];
        }

        $score['result']['overall'] = $overall_content < 85 ? $overall_content + 5 : $overall_content;
        $score['result']['fluency'] = $fluency_score < 85 ? $fluency_score + 5 : $fluency_score;
        $score['result']['pronunciation'] = $pronunciation_score < 85 ? $pronunciation_score + 5 : $pronunciation_score;
        return $score;
    }
    return false;
}

function get_respond_situation_scores($user_response, $keywords){
    $score = getSpeakingScores($user_response, $keywords);
    
    if(isset($score['result'])){
        
        $keywords = explode(",", $keywords);
        $keywords = array_filter(array_map('trim',$keywords));
        $words_spoken = explode(" ", $score['result']['transcription']);
        $words_spoken = array_filter(array_map('trim',$words_spoken));

        $content_matches = 0;
        $overall_content = 0;

        foreach($words_spoken as $word){
            foreach($keywords as $keyword){
                if(strtolower($keyword) == strtolower(preg_replace('/\p{P}/', '', $word))){
                    $content_matches += 1;
                }
            }
        }

        $percent_content_match = round(($content_matches / count($keywords)) * 100);
        if($percent_content_match >= 1 && $percent_content_match <= 5){
            $overall_content = 50;
        }	
        if($percent_content_match > 5 && $percent_content_match <= 10){
            $overall_content = 60;
        }
        if($percent_content_match > 10 && $percent_content_match <= 15){
            $overall_content = 70;
        }
        if($percent_content_match > 15 && $percent_content_match <= 20){
            $overall_content = 75;
        }
        if($percent_content_match > 20 && $percent_content_match <= 25){
            $overall_content = 80;
        }
        if($percent_content_match > 25 && $percent_content_match <= 30){
            $overall_content = 85;
        }
        if($percent_content_match > 30){
            $overall_content = 90;
        }

        if($score['result']['fluency'] < 50){
            $fluency_score = $score['result']['fluency'] + 20;
        }else if($score['result']['fluency'] < 60){
            $fluency_score = $score['result']['fluency'] + 18;
        }else if($score['result']['fluency'] < 70){
            $fluency_score = $score['result']['fluency'] + 13;
        }else if($score['result']['fluency'] < 75){
            $fluency_score = $score['result']['fluency'] + 10;
        }else{
            $fluency_score = $score['result']['fluency'];
        }
        
        if($score['result']['pronunciation'] < 50){
            $pronunciation_score = $score['result']['pronunciation'] + 20;
        }else if($score['result']['pronunciation'] < 60){
            $pronunciation_score = $score['result']['pronunciation'] + 18;
        }else if($score['result']['pronunciation'] < 70){
            $pronunciation_score = $score['result']['pronunciation'] + 13;
        }else if($score['result']['pronunciation'] < 75){
            $pronunciation_score = $score['result']['pronunciation'] + 10;
        }else{
            $pronunciation_score = $score['result']['pronunciation'];
        }

        $score['result']['overall'] = $overall_content < 85 ? $overall_content + 5 : $overall_content;
        $score['result']['fluency'] = $fluency_score < 85 ? $fluency_score + 5 : $fluency_score;
        $score['result']['pronunciation'] = $pronunciation_score < 85 ? $pronunciation_score + 5 : $pronunciation_score;

        return $score;
    }
    return false;
}

function get_repeat_sentence_scores($user_response, $keywords){
    $score = getSpeakingScores($user_response, $keywords);

    if(isset($score['result'])){
        $score['result']['overall'] = $score['result']['overall'] < 85 ? $score['result']['overall'] + 5 : $score['result']['overall'];
        $score['result']['fluency'] = $score['result']['fluency'] < 85 ? $score['result']['fluency'] + 5 : $score['result']['fluency'];
        $score['result']['pronunciation'] = $score['result']['pronunciation'] < 85 ? $score['result']['pronunciation'] + 5 : $score['result']['pronunciation'];
        return $score;
    }
    return false;
}

function get_fib_wr_score($actual_answer, $student_answer){
    
    if(is_array($actual_answer) && count($student_answer) > 0){
        $userAnswerArr = array();  

        $score = 0;

        foreach ($actual_answer as $key => $value) {
            if ($actual_answer[$key] == $student_answer[$key]) {
                $score++;
            }
            if(strlen($student_answer[$key]) <= 0){
                $userAnswerArr[] = '___BLANK SKIPPED___';
            }else{
                $userAnswerArr[] = $student_answer[$key];
            }
        }

        if($score < count($actual_answer)){
            $suggestion = "Target 79: max 1 mistake. Target 65: max 2 mistakes. Target 50: max 2 mistakes.";
        }else{
            $suggestion = "Excellent";
        }
    }

    return false;
}

function array_diff_repeating($array1, $array2) {
    $count1 = array_count_values($array1);
    $count2 = array_count_values($array2);

    $diff = array();

    foreach ($count1 as $value => $occurrences1) {
        $occurrences2 = isset($count2[$value]) ? $count2[$value] : 0;
        $diff = array_merge($diff, array_fill(0, max(0, $occurrences1 - $occurrences2), $value));
    }

    return $diff;
}

function get_wfd_mistakes($actual_answer, $userAnswerArr){
    $output = "";
    $user_missing_words = array_diff_repeating($actual_answer,$userAnswerArr);
    $user_extra_words = array_diff_repeating($userAnswerArr,$actual_answer);
    $temp_actual_answer = $actual_answer;
    // var_dump($user_missing_words);
    // echo "<br>";
    // var_dump($user_extra_words);
    foreach ($userAnswerArr as $key => $row) {
        // var_dump($temp_actual_answer);echo "<br>";
        if ($row == $temp_actual_answer[0]) {
            $output .= ' <span style="color:var(--primary);font-weight: bold;">' . $row . '</span>';
            array_shift($temp_actual_answer);
            array_shift($userAnswerArr);
            // echo "loop".$key;echo "<br>";
        } elseif(!in_array($row, $temp_actual_answer)){
            // echo "user extra word found: ".$row;echo "<br>";
            $output .= ' <span style="color:red; font-style: italic; text-decoration: line-through;">' . $row . '</span>';
            if(count($user_extra_words) == 1 && count($user_missing_words) == 1 && count($temp_actual_answer) == 1){
                $output .= ' <span style="color:#36b336;font-weight: bold;">'.trim($temp_actual_answer[0]).'</span>';
            }
            array_shift($userAnswerArr);
            unset($user_extra_words[array_search($arow, $user_extra_words)]);
        }else{
            $missed_words = [];
            foreach ($temp_actual_answer as $akey => $arow) {
                // echo $arow . "-" . $row;echo "<br>";
                // echo "loop2".$akey;echo "<br>";
                if(in_array($arow, $user_missing_words)){
                    // echo "user skipped word found: ".$arow;echo "<br>";
                    $output .= ' <span style="color:#36b336;font-weight: bold;">'.trim($arow).'</span>';
                    array_shift($temp_actual_answer);
                    unset($user_missing_words[array_search($arow, $user_missing_words)]);
                    continue;
                }
                if($arow == $row){
                    // echo " match ".$arow.",".$row;echo "<br>";
                    // if(count($missed_words) > 0)
                    $output .= ' <span style="color:var(--primary);font-weight: bold;">' . $row . '</span>';
                    array_shift($temp_actual_answer);
                    array_shift($userAnswerArr);
                    // unset($temp_actual_answer[$akey]);
                    // unset($userAnswerArr[array_search($arow, $userAnswerArr)]);
                    // echo "apply break";echo "<br>";
                    break;
                } else {
                    // echo " not match ".$arow.",".$row;echo "<br>";
                    array_push($missed_words,' <span style="color:#36b336;font-weight: bold;">' . $arow . '</span>');
                    array_shift($temp_actual_answer);
                }
            }
        }
    }

    return $output;
}

function checkEmailThemes($themes = array(), $emailBody) {

    $satisfied_themes = 0;
    
    // Convert the email body to lowercase for case-insensitive matching
    $emailBody = strtolower($emailBody);

    // Check if each theme is present in the email body
    foreach ($themes as $theme) {
        if (strpos($emailBody, $theme) !== false) {
            $satisfied_themes++;
        }
    }

    // All themes are present
    return $satisfied_themes;
}

function checkEmailConventions($emailBody) {
    // Define the conventions for salutation and closing
    $salutations = array(
        "Dear", "Hello", "Hi", "Greetings", "Good morning", "Good afternoon", "Good evening", "Esteemed", "Respected", "Dear Friend", "Hi there", "Yo", "Hello Everyone", "Dear Team"
    );

    $closings = array(
        "Sincerely", "Yours faithfully", "Respectfully", "Regards", "Best regards", "Kind regards", "Cheers", "Take care", "Best", "Thank you", "Best wishes", "Warm regards", "With love", "Yours truly", "All the best", "Many thanks", "Appreciatively", "With gratitude", "Later", "Catch you later", "Talk soon", "Until we meet again", "Wishing you success", "Stay awesome"
    );

    // Convert the email body to lowercase for case-insensitive matching
    $emailBodyLower = strtolower($emailBody);

    // Check if salutation and closing are present in the email body
    $salutationFound = false;
    $closingFound = false;

    $lines = preg_split('/\n/', $emailBodyLower);
    // Check if salutation is present in the first line
    $firstLine = strtolower(trim($lines[0]));
    foreach ($salutations as $salutation) {
        if (strpos($firstLine, strtolower($salutation)) === 0) {
            $salutationFound = true;
            break;
        }
    }

    foreach ($closings as $closing) {
        if (strpos($emailBodyLower, strtolower($closing)) !== false) {
            $closingFound = true;
            break;
        }
    }

    // Check if both salutation and closing are present
    return array("salutation" => $salutationFound, "closing" => $closingFound);
}

function checkParagraphs($emailBody) {
    // Split the email body into paragraphs
    $paragraphs = explode("\r\n", $emailBody);

    // Count the number of paragraphs
    $numParagraphs = count($paragraphs);

    // Classify based on the number of paragraphs
    if ($numParagraphs >= 3) {
        // Check if there are complex sentences in the paragraphs
        $complexSentencesFound = false;
        foreach ($paragraphs as $paragraph) {
            if (preg_match('/[;,:\-–—(){}]/', $paragraph)) {
                $complexSentencesFound = true;
                break;
            }
        }
        if ($complexSentencesFound) {
            return 2; // 3 paragraphs with complex sentences
        } else {
            return 1; // 3 paragraphs with simple sentences
        }
    } elseif ($numParagraphs == 2) {
        return 1; // 2 paragraphs
    } else {
        return 0; // Single paragraph
    }
}

function countWords($sentenceBody) {
    // Remove any HTML tags
    $sentenceBody = strip_tags($sentenceBody);

    // Remove punctuation marks
    $sentenceBody = preg_replace('/[^\p{L}\p{N}\s]/u', '', $sentenceBody);

    // Split the body into words
    $words = preg_split('/\s+/', $sentenceBody);

    // Count the number of words
    $numWords = count($words);

    return $numWords;
}