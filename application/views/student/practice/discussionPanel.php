<style>
.chr {
    border-bottom: 1px solid #d3d3d3;
}

.chr:last-child {
    border-bottom: none; 
}

.deleteanswer {
    float: right;
    margin-right: 30px;
    font-size: 20px;
    cursor: pointer;
}

#loading{
    text-align: left;
}

#ReadMore {
    padding: 10px;
    text-align: center;
    background-color: #33739E;
    color: #fff;
    border-width: 0 1px 1px 0;
    border-style: solid;
    border-color: #fff;
    box-shadow: 0 1px 1px #ccc;
}

#ReadMore:hover {
    background-color: lightblue;
    color: darkblue;
}
</style>
<div class="col-xl-12">
    <div class="card">
        <div class="card-header px-10">
            <h4 class="card-title">Submissions</h4>
        </div>
        <div class="card-body px-10">
            <!-- Nav tabs -->
            <div class="default-tab">
                <ul class="nav nav-tabs" role="tablist">
                    <!-- <li class="nav-item"> -->
                    <!-- <i class="la la-home mr-2"></i> -->
                    <!-- <a class="nav-link" data-toggle="tab" href="#topperboard"> Top Board</a> -->
                    <!-- </li> -->
                    <li class="nav-item pr-2">
                        <!-- <i class="la la-user mr-2"></i> -->
                        <a class="nav-link px-0 active" data-toggle="tab" href="#myanswers"> My Submissions</a>
                    </li>
                    <li class="nav-item">
                        <!-- <i class="la la-user mr-2"></i> -->
                        <a class="nav-link" data-toggle="tab" href="#high_scores"> Board</a>
                    </li>

                </ul>
                <div class="tab-content">
                    <!-- <div class="tab-pane fade" id="topperboard">
                        <div class="pt-4">
                            <div class="chr pb-4 pt-4">
                                <div style="display:flex;">
                                    <h6>John Doe</h6>
                                    <p style="font-size:12px; padding-left: 10px;">2023-01-18</p>
                                </div>
                                <div >
                                    <p style="padding-left: 10px;">
                                        qwertyuihgesg
                                    </p>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary">Score Info</button>
                            </div>
                        </div>
                    </div> -->

                    <div class="tab-pane fade active show" id="myanswers" role="tabpanel">
                        <div class="pt-4">
                            <?php
                            if (isset($getUserAttempts) && count($getUserAttempts) > 0) {
                                arsort($getUserAttempts);
                                $i = 0;
                                foreach ($getUserAttempts as $data => $rowdata) {
                                    ?>
                                    <div class="chr pb-4 pt-4" id="answer-box-<?php echo $rowdata->id; ?>">
                                        <div style="display:flex; align-items: center;">
                                            <h6>
                                                <?php echo ucwords($this->session->userdata('name')); ?>
                                            </h6>
                                            <p style="font-size:12px; padding-left: 15px;">
                                                <?php echo $rowdata->create_date; ?>
                                            </p>
                                        </div>
                                        <div class="py-4">
                                            <p style="padding-left: 10px;">
                                                <?php
                                                switch ($testType) {
                                                    case 'l_mcm':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'l_fib':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'hiws':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'read_alouds':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'repeat_sentences':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'describe_images':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'retell_lectures':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'answer_questions':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'respond_situation':
                                                        echo '<audio src="' . base_url() . $rowdata->answer . '" controls="" preload="none"></audio>';
                                                        break;
                                                    case 'r_mcm':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'fib_wr':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'fib_rd':
                                                        $answer = json_decode($rowdata->answer);
                                                        echo implode(', ', $answer);
                                                        break;
                                                    case 'essays':
                                                        echo nl2br($rowdata->answer);
                                                        break;
                                                    case 'email':
                                                        echo nl2br($rowdata->answer);
                                                        break;
                                                    case 'wfds':
                                                        $actual_answer = explode(' ', strtolower(trim(preg_replace('/\p{P}/', '', $getQuestionData[0]->transcript))));
                                                        $userAnswer = preg_replace('/\p{P}/', '', strtolower(strip_tags($rowdata->answer)));
                                                        $userAnswerArr = explode(' ', $userAnswer);

                                                        // $mistakes = [];
                                                        // foreach ($actual_answer as $key => $row) {
                                                        //     if (in_array($row, $userAnswerArr)) {
                                                        //         array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $actual_answer[$key] . '</span>');
                                                        //     }else{
                                                        //         array_push($mistakes, '<span style="color:red;font-style: italic;text-decoration: line-through;">' . $actual_answer[$key] . '</span>');
                                                        //     }
                                                        // }
                                        
                                                        // echo implode(' ', $mistakes);
                                                        // echo "<br>";
                                                        // $mistakes = [];
                                                        // foreach ($userAnswerArr as $key => $row) {
                                                        //     if (in_array($row, $actual_answer)) {
                                                        //         array_push($mistakes, '<span style="color:var(--primary);font-weight: bold;">' . $userAnswerArr[$key] . '</span>');
                                                        //     }else{
                                                        //         array_push($mistakes, '<span style="color:red;font-style: italic;text-decoration: line-through;">' . $userAnswerArr[$key] . '</span>');
                                                        //     }
                                                        // }
                                        
                                                        // echo implode(' ', $mistakes);
                                                        // echo "<br>";
                                                        echo get_wfd_mistakes($actual_answer, $userAnswerArr);
                                                        break;
                                                    default:
                                                        echo $rowdata->answer;
                                                }
                                                ?>
                                            </p>
                                        </div>
                                        <button class="btn btn-xs btn-outline-secondary"
                                            onclick="checkResults(<?php echo $i . ',' . $rowdata->id; ?>)">Score Info
                                            <?php echo $rowdata->score . '/' . $maxScore; ?>
                                        </button>
                                        <!-- <button class="btn btn-xs btn-outline-secondary" onclick="checkResults(<?php echo $i; ?>)">Score Info <?php echo $rowdata->score . '/' . $maxScore; ?></button> -->
                                        <a class="deleteanswer"
                                            onclick="deleteanswer(<?php echo $rowdata->id; ?>,'<?php echo $testType; ?>');"><i
                                                class='fa fa-trash'></i></a>
                                    </div>
                                    <?php $i++;
                                }
                            } else { ?>
                                <div class="chr pb-4 pt-4">
                                    <div style="display:flex;">
                                        <h6>No answers submitted</h6>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="tab-pane" id="high_scores" role="tabpanel"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>
<script>
    var limit = 10 ;
    var offset = 0 ; 
    var flag = true;
    var maxScore = '<?php echo $maxScore; ?>';
    let getQuestionData = <?php echo json_encode($getQuestionData[0]); ?>;
    $(document).ready(function () {
        loadmore();
    });

    $(window).scroll(function() {
        if($("#high_scores").hasClass("active")){
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                if (flag){
                    loadmore();  
                }
            }
        }
    });

function loadmore(){
    // var csrfName = $('.csrfToken').attr('name');
    // var csrfHash = $('.csrfToken').val(); // CSRF hash
    // console.log(csrfHash)
    $.ajax({
            url: app_url + "user/get_high_score_board_list",
            type: 'POST',
            data: {
                // [csrfName]: csrfHash,
                maxScore: maxScore,
                getQuestionData: getQuestionData,
                limit: limit,
                offset: offset

            },
            success: function (data) {
                offset = offset + limit;
                data = JSON.parse(data);
                // $('.csrfToken').val(data.token);

                if(data.data.length){
                    $("#high_scores").append(data.data);
                    $("#high_scores .chr").css("border-bottom", " 1px solid #d3d3d3");
                    $("#high_scores .chr").last().css("border-bottom", " none");
                    
                }else{
                    flag = false;
                    $("#high_scores").append(`
                    <div class="chr pb-4 pt-4">
                        <div style="display:flex;">
                            <h6>No data found</h6>
                        </div>
                    </div>`);
                }
            }
        });
        
}
</script>

<script>
    var siteUrl = '<?php echo base_url() ?>';

    function deleteanswer(id, model) {
        if (confirm('Are sure you to delete this answer?')) {
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: app_url + "user/deleteanswer",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: {
                    [csrfName]: csrfHash,
                    model: model,
                    id: id
                },
                success: function (data) {
                    $('.csrfToken').val(data.token);
                    $('#answer-box-' + id).remove();
                }
            })
        } else {
            return false;
        }
    }
</script>