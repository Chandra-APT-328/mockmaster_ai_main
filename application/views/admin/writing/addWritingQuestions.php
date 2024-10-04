<!-- Fonts and Codebase framework -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
<script src="<?php echo base_url(); ?>public/js/codebase.core.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/plugins/ckeditor/ckeditor.js"></script>

<style>
input[type=time]::-webkit-datetime-edit-ampm-field {
    display: none;
}

input[type=time]::-webkit-clear-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    -o-appearance: none;
    -ms-appearance: none;
    appearance: none;
    margin: -10px;
}
</style>


<div class="block">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-lg-8 col-xl-12">
                <form class="mb-5" id="addwritingquestions"
                    action="<?php echo base_url();?>admin/addwritingquestions/<?php if(isset($getWritingData) && strlen($getWritingData[0]->id) > 0){ echo $getWritingData[0]->id;} ?>"
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
                            <div class="col-6">
                                <h3 class="" id="headingTitle">Select form type</h3>
                            </div>
                            <div class="col-6">
                                <div class="col-8" style="float:right;">
                                    <select id="questionType" class="form-control" name="questionType" required>
                                        <option value="" selected>Select Form Type</option>
                                        <?php foreach($getQuestionType as $data => $rowdata){ ?>
                                        <option value="<?php echo $rowdata->question_code; ?>"
                                            <?php if(isset($getWritingData) && strlen($getWritingData[0]->question_type == $rowdata->question_code)){ echo "selected"; } ?>>
                                            <?php echo $rowdata->type_name;  ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="section-body">
                        <div class="row ">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-12">
                                                <label class="form-label" for="questionTitle">Title</label>
                                                <input type="text" class="form-control" id="questionTitle"
                                                    name="questionTitle"
                                                    value="<?php if(isset($getWritingData) && strlen($getWritingData[0]->title) > 0){ echo $getWritingData[0]->title;} ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="row mb-4" id="questionrow">
                                            <div class="col-12">
                                                <label class="form-label" for="question">Question</label>
                                                <textarea class="form-control" id="question" rows="12" name="question"
                                                    required><?php if(isset($getWritingData) && strlen($getWritingData[0]->question) > 0){ echo $getWritingData[0]->question;} ?></textarea>
                                            </div>
                                        </div>

                                        <!-- keywords row -->
                                        <div class="row mb-4" id="keywordsrow">
                                            <div class="col-12">
                                                <label class="form-label" for="keywords">Keywords (, seperated)</label>
                                                <input type="text" class="form-control" id="keywords" rows="12"
                                                    name="keywords"
                                                    value="<?php if(isset($getWritingData) && strlen($getWritingData[0]->keywords) > 0){ echo implode(', ',explode(',',$getWritingData[0]->keywords));} ?>">
                                            </div>
                                        </div>
                                        
                                        <!-- emailreasons row -->
                                        <div class="row mb-4" style="display:none;" id="emailreasonsrow">
                                            <div class="col-12">
                                                <label class="form-label" for="emailreasons">Reasons (, seperated)</label>
                                                <?php
                                                    $email_reasons = "";
                                                    if(isset($getWritingData[0])){
                                                        $additional_data = json_decode($getWritingData[0]->additional_json);
                                                        if($additional_data){
                                                            $email_reasons = $additional_data->reasons;
                                                            $email_reasons = is_array($email_reasons) ? implode(", ",$email_reasons) : $email_reasons;
                                                        }
                                                    }
                                                ?>
                                                <input type="text" class="form-control" id="emailreasons" rows="12"
                                                    name="emailreasons"
                                                    value="<?php if(strlen($email_reasons) > 0){ echo $email_reasons; } ?>">
                                            </div>
                                        </div>

                                        <div class="row mb-4" style="display:none;" id="answersrow">
                                            <div class="col-12">
                                                <label class="form-label" for="answer">Answer</label>
                                                <textarea class="form-control" id="answer" rows="12"
                                                    name="answer"><?php if(isset($getWritingData) && strlen($getWritingData[0]->answer) > 0){ echo $getWritingData[0]->answer;} ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-4" style="display:none;" id="explanationrow">
                                            <div class="col-12">
                                                <label class="form-label" for="explanation">Explanation</label>
                                                <textarea class="form-control" id="explanation" rows="12"
                                                    name="explanation"><?php if(isset($getWritingData) && strlen($getWritingData[0]->explanation) > 0){ echo $getWritingData[0]->explanation;} ?></textarea>
                                            </div>
                                        </div>

                                        <div class="row mb-4">
                                            <?php
                                    $min="1";$sec="0";
                                    if(isset($getWritingData) && strlen($getWritingData[0]->exam_duration) > 0){ 
                                        $time = explode(":", $getWritingData[0]->exam_duration);
                                        $min = $time[0];
                                        $sec = $time[1];
                                    }
                                ?>
                                            <div class="col-2">
                                                <label for="setTimer" class="form-label">Test timing (<span
                                                        style="color:red;">*
                                                    </span> minutes)</label>
                                                <input type="number" class="form-control" id="setTimerMin"
                                                    name="setTimerMin" value="<?php echo $min ?>"
                                                    onkeypress="isNumberKey(event)" required>
                                            </div>
                                            <div class="col-2">
                                                <label for="setTimer" class="form-label">Test timing (<span
                                                        style="color:red;">*
                                                    </span> seconds)</label>
                                                <input type="number" class="form-control" id="setTimerSec"
                                                    name="setTimerSec" value="<?php echo $sec ?>"
                                                    onkeypress="isNumberKey(event)" required>
                                            </div>
                                            <div class="col-6">
                                                <div class="offset-2 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="answerCheck"
                                                            onchange="toggleAnswer()" name="answerCheck"
                                                            value="answerCheck"
                                                            <?php if(isset($getWritingData) && strlen($getWritingData[0]->answer) > 0){ echo "checked";} ?> />
                                                        <label class="form-check-label" for="answerCheck">Add
                                                            answer</label>
                                                    </div>
                                                </div>
                                                <div class="offset-2 mb-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="explanationCheck" onchange="toggleExplanation()"
                                                            name="explanationCheck" value="explanationCheck"
                                                            <?php if(isset($getWritingData) && strlen($getWritingData[0]->explanation) > 0){ echo "checked";} ?> />
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

</body>
<script>
CKEDITOR.replace('question');
CKEDITOR.replace('answer');
CKEDITOR.replace('explanation');
</script>
<script>
$(document).ready(function() {
    getSelectedFormData();
});
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
    var valueSelected = this.value;
    $('#headingTitle').text(optionSelected);
    setForm(valueSelected);
    // (valueSelected === 'l_mcm') ? $('#multipleChoiceOptionsrow').show() : $('#multipleChoiceOptionsrow').hide();
    // (valueSelected === 'l_mcm') ? $('#questionrow').show() : $('#questionrow').hide();
});

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

function getSelectedFormData() {
    // console.log('form loaded')
    var optionSelected = $("#questionType option:selected").text();
    var valueSelected = $("#questionType option:selected").val();
    // console.log(valueSelected)
    $('#headingTitle').text(optionSelected);

    setForm(valueSelected);

    if ($('#explanationCheck').is(":checked")) {
        $('#explanationrow').show();
    }

    if ($('#answerCheck').is(":checked")) {
        $('#answersrow').show();
    }
    // (valueSelected === 'l_mcm') ? $('#multipleChoiceOptionsrow').show() : $('#multipleChoiceOptionsrow').hide();
    // (valueSelected === 'l_mcm') ? $('#questionrow').show() : $('#questionrow').hide();
    // console.log(valueSelected)
}

function setForm(valueSelected) {
    switch (valueSelected) {
        case 'email':
            $('#emailreasonsrow').show();
            break;
        default:
            $('#emailreasonsrow').hide();
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