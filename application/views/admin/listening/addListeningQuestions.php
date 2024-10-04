<link href="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/plugins/ckeditor/ckeditor.js"></script>
<!-- <div class="content-body"> -->
<!-- row -->
<!-- <div class="container-fluid"> -->

<div class="block">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-8 col-xl-12">
                <form class="mb-5" id="addlisteningquestions"
                    action="<?php echo base_url();?>admin/addlisteningquestions/<?php if(isset($getListeningData) && strlen($getListeningData[0]->id) > 0){ echo $getListeningData[0]->id;} ?>"
                    method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">

                    <!-- form error notification -->
                    <?php if($this->session->userdata('error')){ ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->userdata('error'); 
                                $this->session->unset_userdata('error');?>
                    </div>
                    <?php } ?>
                    <?php if($this->session->userdata('success')){ ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->userdata('success'); 
                                $this->session->unset_userdata('success');?>
                    </div>
                    <?php } ?>
                    <div class="section-header">
                        <div class="col-12 row">
                            <div class="col-6 ">
                                <h3 class="" id="headingTitle">Select form type</h3>
                            </div>
                            <div class="col-6">
                                <div class="col-8" style="float:right;">
                                    <select id="questionType" class="form-control" name="questionType" required>
                                        <option value="" selected>Select Form Type</option>
                                        <?php foreach($getQuestionType as $data => $rowdata){ ?>
                                        <option value="<?php echo $rowdata->question_code; ?>"
                                            <?php if(isset($getListeningData) && strlen($getListeningData[0]->question_type == $rowdata->question_code)){ echo "selected"; } ?>>
                                            <?php echo $rowdata->type_name;  ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- title -->
                    <div class="section-body">
                        <div class="row ">
                            <div class="col-lg-12">                            
                            <div class="card">                            
                                <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12 form-group mt-15 ">
                                        <label class="input-label" for="questionTitle">Title</label>
                                        <input type="text" class="form-control" id="questionTitle" name="questionTitle"
                                            value="<?php if(isset($getListeningData) && strlen($getListeningData[0]->title) > 0){ echo $getListeningData[0]->title;} ?>"
                                            required>
                                    </div>
                                </div>

                                <!-- upload -->
                                <div class="form-group mt-15">
                                    <label for="audioUpload" class="input-label">Upload audio file</label>
                                    <input class="form-control" type="file" name="audioPath" id="audioUpload"
                                        accept="audio/mpeg,audio/mp3,audio/m4a" />
                                </div>

                                <!-- transcript -->
                                <div class="row mb-4" id="transcriptrow">
                                    <div class="col-12 form-group mt-15 ">
                                        <label class="form-label" for="transcript">Audio Transcript</label>
                                        <textarea class="form-control" id="transcript" rows="12"
                                            name="transcript"><?php if(isset($getListeningData) && strlen($getListeningData[0]->transcript) > 0){ echo $getListeningData[0]->transcript;} ?></textarea>
                                    </div>
                                </div>

                                <!-- answers row -->
                                <div class="row mb-4" style="display:none;" id="answersrow">
                                    <div class="col-12 form-group mt-15 ">
                                        <label class="form-label" for="answer">Answer</label>
                                        <textarea class="form-control" id="answer" rows="12"
                                            name="answer"><?php if(isset($getListeningData) && strlen($getListeningData[0]->answer) > 0){ echo $getListeningData[0]->answer;} ?></textarea>
                                    </div>
                                </div>

                                <!-- explanation row -->
                                <div class="row mb-4" style="display:none;" id="explanationrow">
                                    <div class="col-12 form-group mt-15 ">
                                        <label class="form-label" for="explanation">Explanation</label>
                                        <textarea class="form-control" id="explanation" rows="12"
                                            name="explanation"><?php if(isset($getListeningData) && strlen($getListeningData[0]->explanation) > 0){ echo $getListeningData[0]->explanation;} ?></textarea>
                                    </div>
                                </div>

                                <!-- keywords row -->
                                <div class="row mb-4" style="display:none;" id="keywordsrow">
                                    <div class="col-12">
                                        <label class="form-label" for="keywords">Keywords (, seperated)</label>
                                        <input type="text" class="form-control" id="keywords" rows="12" name="keywords"
                                            value="<?php if(isset($getListeningData) && strlen($getListeningData[0]->keywords) > 0){ echo implode(', ',explode(',',$getListeningData[0]->keywords));} ?>">
                                    </div>
                                </div>

                                <!-- questions row -->
                                <div class="row mb-4" style="display:none;" id="questionrow">
                                    <div class="col-12">
                                        <label class="form-label" for="question">Question</label>
                                        <textarea class="form-control" id="question" rows="12"
                                            name="question"><?php if(isset($getListeningData) && strlen($getListeningData[0]->question) > 0){ echo $getListeningData[0]->question;} ?></textarea>
                                    </div>
                                </div>

                                <!-- fill in the blanks -->
                                <div class="row mb-4" style="display:none;" id="fitbrow">
                                    <div class="col-12">
                                        <label class="form-label" for="fitb">Fill in the blanks (*write the blank
                                            answers in
                                            the {} brackets)</label>
                                        <textarea class="form-control" id="fitb" rows="12"
                                            name="fitb"><?php if(isset($getListeningData) && strlen($getListeningData[0]->question) > 0){ echo $getListeningData[0]->question;} ?></textarea>
                                    </div>
                                </div>

                                <!-- Highlight Incorrect Words -->
                                <div class="row mb-4" style="display:none;" id="hiwsrow">
                                    <div class="col-12">
                                        <label class="form-label" for="hiws">Highlight Incorrect Words (*write the wrong
                                            words in
                                            the {} brackets)</label>
                                        <textarea class="form-control" id="hiws" rows="12"
                                            name="hiws"><?php if(isset($getListeningData) && strlen($getListeningData[0]->question) > 0){ echo $getListeningData[0]->question;} ?></textarea>
                                    </div>
                                </div>

                                <!-- multiple choice question -->
                                <div class="row mb-4" style="display:none;" id="multipleChoiceOptionsrow">
                                    <div class="col-11">
                                        <label class="form-label">Multiple Choice (Multiple) Options</label>
                                        <div class="offset-1" id="checkOptions"></div>
                                        <div class="offset-1" id="addCheckOption" style="padding-left:10px;"><span>Add
                                                Question </span><i class="fa fa-plus" aria-hidden="true"
                                                onclick="addMCMKPI()"></i></div>
                                    </div>
                                </div>

                                <!-- single choice question -->
                                <div class="row mb-4" style="display:none;" id="singleChoiceOptionsrow">
                                    <div class="col-11">
                                        <label class="form-label" id="singleChoiceOptionsLabel"></label>
                                        <div class="offset-1" id="checkSingleOptions"></div>
                                        <div class="offset-1" id="addSingleOption" style="padding-left:10px;"><span>Add
                                                Question </span><i class="fa fa-plus" aria-hidden="true"
                                                onclick="addMCSKPI()"></i></div>
                                    </div>
                                </div>

                                <!-- timer -->
                                <div class="row mb-4" id="timerrow">
                                    <?php
                                    $min="1";$sec="0";
                                    if(isset($getListeningData) && strlen($getListeningData[0]->exam_duration) > 0){ 
                                        $time = explode(":", $getListeningData[0]->exam_duration);
                                        $min = $time[0];
                                        $sec = $time[1];
                                    }
                                ?>
                                    <div class="col-2">
                                        <label for="setTimer" class="form-label">Test timing (<span style="color:red;">*
                                            </span> minutes)</label>
                                        <input type="number" class="form-control" id="setTimerMin" name="setTimerMin"
                                            value="<?php echo $min ?>" onkeypress="isNumberKey(event)" required>
                                    </div>
                                    <div class="col-2">
                                        <label for="setTimer" class="form-label">Test timing (<span style="color:red;">*
                                            </span> seconds)</label>
                                        <input type="number" class="form-control" id="setTimerSec" name="setTimerSec"
                                            value="<?php echo $sec ?>" onkeypress="isNumberKey(event)" required>
                                    </div>
                                    <div class="col-6" id="extra-check-items">
                                        <div class="offset-2 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="answerCheck"
                                                    onchange="toggleAnswer()" name="answerCheck" value="answerCheck"
                                                    <?php if(isset($getListeningData) && strlen($getListeningData[0]->answer) > 0){ echo "checked";} ?> />
                                                <label class="form-check-label" for="answerCheck">Add answer</label>
                                            </div>
                                        </div>
                                        <div class="offset-2 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="explanationCheck"
                                                    onchange="toggleExplanation()" name="explanationCheck"
                                                    value="explanationCheck"
                                                    <?php if(isset($getListeningData) && strlen($getListeningData[0]->explanation) > 0){ echo "checked";} ?> />
                                                <label class="form-check-label" for="explanationCheck">Add
                                                    explanation</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <input type="submit" class="btn btn-primary" id="submit" name="submit"
                                            value="Submit" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- </div>
</div> -->


<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>

<script>
CKEDITOR.replace('question');
CKEDITOR.replace('transcript');
CKEDITOR.replace('answer');
CKEDITOR.replace('explanation');
</script>
<script>
// var tmpKPI = [1,2,3,4,5];
var kpi = 1;
$(document).ready(function() {
    getSelectedFormData();

    isFormEdit =
        <?php echo (isset($getListeningData) && strlen($getListeningData[0]->options) > 0) ? 'true' : 'false'; ?>;
    kpiCount = parseInt(
        <?php echo (isset($getListeningData) && strlen($getListeningData[0]->options) > 0) ? count(json_decode($getListeningData[0]->options)) : '5'; ?>
    );
    editFormCheckValue =
        <?php echo (isset($getListeningData) && strlen($getListeningData[0]->answer) > 0) ? json_encode($getListeningData[0]->answer) : '0'; ?>;
    editFormCheckOptions =
        <?php echo (isset($getListeningData) && strlen($getListeningData[0]->options) > 0) ? json_encode($getListeningData[0]->options) : '0' ; ?>;
    editFormCheckValue = JSON.parse(editFormCheckValue);
    editFormCheckOptions = JSON.parse(editFormCheckOptions);

    if (isFormEdit === true && $("#questionType option:selected").val() == 'l_mcm') {
        for (let index = 0; index < kpiCount; index++) {
            $('#checkOptions').append("<div id='checkOption" + kpi +
                "'><label class='form-label' id='checkOptionLabel" + kpi +
                "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='checkStatus" +
                kpi + "' name='checkstatus[]' value='" + editFormCheckValue[index] +
                "'/><input type='checkbox' class='form-check-input box' id='checkOptionResult" + kpi +
                "' name='checkOptionResult[]' onclick='ischeck(" + kpi + ")' value='" + editFormCheckValue[
                    index] + "'><input type='text' class='form-control' id='checkOptionQuestion" + kpi +
                "' name='checkOptionQuestion[]' value='" + editFormCheckOptions[index] +
                "'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='checkOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeMCMKPI(" + kpi + ")'></i></span></div></div>");

            if (editFormCheckValue[index] == 1) {
                $('#checkOptionResult' + kpi).attr('checked', 'true');
            }
            kpi++;
        }
    }

    if (isFormEdit === true && $("#questionType option:selected").val() == 'l_mcs' || $(
            "#questionType option:selected").val() == 'l_smw' || $("#questionType option:selected").val() ==
        'l_hcs') {
        for (let index = 0; index < kpiCount; index++) {
            $('#checkSingleOptions').append("<div id='singleOption" + kpi +
                "'><label class='form-label' id='singleOptionLabel" + kpi +
                "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='selectStatus" +
                kpi + "' name='selectStatus[]' value='" + editFormCheckValue[index] +
                "'/><input type='radio' class='form-check-input box' id='singleOptionResult" + kpi +
                "' name='singleOptionResult' onclick='isradiocheck(" + kpi +
                ")'><input type='text' class='form-control' id='singleOptionQuestion" + kpi +
                "' name='singleOptionQuestion[]' value='" + editFormCheckOptions[index] +
                "'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeMCSKPI(" + kpi + ")'></i></span></div></div>");

            if (editFormCheckValue[index] == 1) {
                $('#singleOptionResult' + kpi).attr('checked', 'true');
            }
            kpi++;
        }
    }
});

function addMCMKPI() {
    $('#checkOptions').append("<div id='checkOption" + kpi + "'><label class='form-label' id='checkOptionLabel" + kpi +
        "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
        "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='checkStatus" + kpi +
        "' name='checkstatus[]' value='0'/><input type='checkbox' class='form-check-input box' id='checkOptionResult" +
        kpi + "' name='checkOptionResult[]' onclick='ischeck(" + kpi +
        ")' value='0'><input type='text' class='form-control' id='checkOptionQuestion" + kpi +
        "' name='checkOptionQuestion[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='checkOptionMinus" +
        kpi + "' aria-hidden='true' onclick='removeMCMKPI(" + kpi + ")'></i></span></div></div>");
    kpi++;
}

function addMCSKPI() {
    $('#checkSingleOptions').append("<div id='singleOption" + kpi +
        "'><label class='form-label' id='singleOptionLabel" + kpi +
        "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
        "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='selectStatus" +
        kpi +
        "' name='selectStatus[]' value='0'/><input type='radio' class='form-check-input box' id='singleOptionResult" +
        kpi + "' name='singleOptionResult' onclick='isradiocheck(" + kpi +
        ")'><input type='text' class='form-control' id='singleOptionQuestion" + kpi +
        "' name='singleOptionQuestion[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
        kpi + "' aria-hidden='true' onclick='removeMCSKPI(" + kpi + ")'></i></span></div></div>");
    kpi++;
}

function removeMCMKPI(id) {
    $('#checkOption' + id).remove();
}

function removeMCSKPI(id) {
    $('#singleOption' + id).remove();
}

function ischeck(id) {
    // console.log(id);
    if ($('#checkOptionResult' + id).is(":checked")) {
        $('#checkStatus' + id).val('1');
        // console.log( $('#checkStatus'+id).val());
    } else {
        $('#checkStatus' + id).val('0');
    }
}

function isradiocheck(id) {
    // console.log(id);
    if ($("#questionType option:selected").val() == 'l_smw' || $("#questionType option:selected").val() == 'l_mcs' || $(
            "#questionType option:selected").val() == 'l_hcs') {
        for (let index = 1; index <= kpi; index++) {
            $('#selectStatus' + index).val('0');
        }
    }

    if ($('#singleOptionResult' + id).is(":checked")) {
        $('#selectStatus' + id).val('1');
        // console.log( $('#checkStatus'+id).val());
    } else {
        $('#selectStatus' + id).val('0');
    }
}

function toggleAnswer() {
    if (document.getElementById('answerCheck').checked) {
        $('#answersrow').show();
    } else {
        $('#answersrow').hide();
    }
}

function toggleExplanation() {
    if (document.getElementById('explanationCheck').checked) {
        $('#explanationrow').show();
    } else {
        $('#explanationrow').hide();
    }
}
</script>
<script>
function isNumberKey(evt) {
    if (evt.target.name == 'setTimerMin' || evt.target.name == 'setTimerSec') {
        var inputText = evt.target.value;
        if (inputText.length >= 2) {
            event.preventDefault();
        }
    }

    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}

$('select').on('change', function(e) {

    var optionSelected = $("#questionType option:selected").text();
    var valueSelected = $("#questionType option:selected").val();
    $('#headingTitle').text(optionSelected);

    if (CKEDITOR.instances['transcript']) {
        CKEDITOR.instances['transcript'].destroy(true);
    }
    CKEDITOR.replace('transcript');

    setForm(valueSelected);

    kpi = 1;

    $('#checkOptions').empty();
    $('#checkSingleOptions').empty();

    if (valueSelected === 'l_mcm') {
        for (let index = 0; index < kpiCount; index++) {
            $('#checkOptions').append("<div id='checkOption" + kpi +
                "'><label class='form-label' id='checkOptionLabel" + kpi +
                "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='checkStatus" +
                kpi +
                "' name='checkstatus[]' value='0'/><input type='checkbox' class='form-check-input box' id='checkOptionResult" +
                kpi + "' name='checkOptionResult[]' onclick='ischeck(" + kpi +
                ")' value='0'><input type='text' class='form-control' id='checkOptionQuestion" + kpi +
                "' name='checkOptionQuestion[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='checkOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeMCMKPI(" + kpi + ")'></i></span></div></div>");
            kpi++;
        }
        $('#multipleChoiceOptionsrow').show();
    } else {
        //    for (let index = 1; index <= kpiCount; index++) {
        //         $('#checkOption'+index).remove();
        //     } 
        $('#multipleChoiceOptionsrow').hide();
    }

    if (valueSelected === 'l_mcs' || valueSelected === 'l_smw' || valueSelected === 'l_hcs') {
        for (let index = 0; index < kpiCount; index++) {
            $('#checkSingleOptions').append("<div id='singleOption" + kpi +
                "'><label class='form-label' id='singleOptionLabel" + kpi +
                "' for='question' style='float:right; margin-right:42px;'>Option " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='hidden' id='selectStatus" +
                kpi +
                "' name='selectStatus[]' value='0'/><input type='radio' class='form-check-input box' id='singleOptionResult" +
                kpi + "' name='singleOptionResult' onclick='isradiocheck(" + kpi +
                ")'><input type='text' class='form-control' id='singleOptionQuestion" + kpi +
                "' name='singleOptionQuestion[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeMCSKPI(" + kpi + ")'></i></span></div></div>");
            kpi++;
        }

        $('#singleChoiceOptionsLabel').text(optionSelected + ' Options');
        $('#singleChoiceOptionsrow').show();
    } else {
        //    for (let index = 1; index <= kpiCount; index++) {
        //         $('#singleOption'+index).remove();
        //     } 
        $('#singleChoiceOptionsrow').hide();
    }
});

function getSelectedFormData() {
    var optionSelected = $("#questionType option:selected").text();
    var valueSelected = $("#questionType option:selected").val();
    $('#headingTitle').text(optionSelected);

    setForm(valueSelected);

    (valueSelected === 'l_mcm') ? $('#multipleChoiceOptionsrow').show(): $('#multipleChoiceOptionsrow').hide();
    (valueSelected === 'l_mcs' || valueSelected === 'l_smw' || valueSelected === 'l_hcs') ? $('#singleChoiceOptionsrow')
        .show(): $('#singleChoiceOptionsrow').hide();
}

function setForm(valueSelected) {
    switch (valueSelected) {
        case 'ssts':
            console.log('check', $('#answerCheck').is(":checked"))
            $('#questionrow').hide();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').show();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').show();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').show();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').show();
            }
            break;
        case 'l_mcm':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            break;
        case 'l_mcs':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            break;
        case 'l_smw':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            break;
        case 'wfds':
            $('#questionrow').hide();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            CKEDITOR.instances['transcript'].destroy(true);
            break;
        case 'l_hcs':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            break;
        case 'l_fib':
            $('#fitbrow').show();
            $('#questionrow').hide();
            $('#hiwsrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            break;
        case 'hiws':
            $('#hiwsrow').show();
            $('#fitbrow').hide();
            $('#questionrow').hide();
            $('#keywordsrow').hide();
            $('#transcriptrow div label').text('Transcript (*write the answers in the {} brackets)');
            $('#extra-check-items').hide();
            if ($('#explanationCheck').is(":checked")) {
                $('#explanationrow').hide();
            }
            if ($('#answerCheck').is(":checked")) {
                $('#answersrow').hide();
            }
            CKEDITOR.instances['transcript'].destroy(true);
            break;
        default:
            $('#extra-check-items').hide();
            break;

    }
}
</script>



<!-- Required vendors -->
<script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/highlightjs/highlight.pack.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>