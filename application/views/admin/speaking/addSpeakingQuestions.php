<!-- Fonts and Codebase framework -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/plugins/ckeditor/ckeditor.js"></script>


<div class="block block-rounded mt-150">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center h-100" style="height:unset !important">
            <div class="col-lg-8 col-xl-12">
                <form class="mb-5" id="addspeakingquestions"
                    action="<?php echo base_url();?>admin/addspeakingquestions/<?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->id) > 0){ echo $getSpeakingData[0]->id;} ?>"
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
                                            <?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->question_type == $rowdata->question_code)){ echo "selected"; } ?>>
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
                                            <div class="col-12">
                                                <label class="form-label" for="questionTitle">Title</label>
                                                <input type="text" class="form-control" id="questionTitle"
                                                    name="questionTitle"
                                                    value="<?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->title) > 0){ echo $getSpeakingData[0]->title;} ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <!-- upload -->
                                        <div class="row mb-4" style="display:none;" id="resourcerow">
                                            <div class="col-12">
                                                <label for="resourceUpload" class="form-label">Upload resource
                                                    file</label>
                                                <input class="form-control" type="file" name="resourcePath"
                                                    id="resourceUpload"
                                                    accept="audio/mpeg,audio/mp3,audio/m4a,image/jpeg,image/jpg,image/png" />
                                            </div>
                                        </div>

                                        <!-- transcript -->
                                        <div class="row mb-4" style="display:none;" id="transcriptrow">
                                            <div class="col-12">
                                                <label class="form-label" for="transcript">Transcript</label>
                                                <textarea class="form-control" id="transcript" rows="12"
                                                    name="transcript"><?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->transcript) > 0){ echo $getSpeakingData[0]->transcript;} ?></textarea>
                                            </div>
                                        </div>

                                        <!-- questions row -->
                                        <div class="row mb-4" style="display:none;" id="questionrow">
                                            <div class="col-12">
                                                <label class="form-label" for="question">Question</label>
                                                <textarea class="form-control" id="question" rows="12"
                                                    name="question"><?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->question) > 0){ echo $getSpeakingData[0]->question;} ?></textarea>
                                            </div>
                                        </div>

                                        <!-- answers row -->
                                        <div class="row mb-4" style="display:none;" id="answersrow">
                                            <div class="col-12">
                                                <label class="form-label" for="answer">Answer</label>
                                                <textarea class="form-control" id="answer" rows="12"
                                                    name="answer"><?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->answer) > 0){ echo $getSpeakingData[0]->answer;} ?></textarea>
                                            </div>
                                        </div>

                                        <!-- keywords row -->
                                        <div class="row mb-4" style="display:none;" id="keywordsrow">
                                            <div class="col-12">
                                                <label class="form-label" for="keywords">Keywords (, seperated)</label>
                                                <input type="text" class="form-control" id="keywords" rows="12"
                                                    name="keywords"
                                                    value="<?php if(isset($getSpeakingData) && strlen($getSpeakingData[0]->keywords) > 0){ echo implode(', ',explode(',',$getSpeakingData[0]->keywords));} ?>">
                                            </div>
                                        </div>

                                        <!-- timer -->
                                        <div class="row mb-4" id="timerrow" hidden>
                                            <?php
                                    $min="1";$sec="0";
                                    if(isset($getSpeakingData) && strlen($getSpeakingData[0]->exam_duration) > 0){ 
                                        $time = explode(":", $getSpeakingData[0]->exam_duration);
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
</div>
</div>

<script>
CKEDITOR.replace('transcript');
CKEDITOR.replace('question');
CKEDITOR.replace('answer');
</script>
<script>
var kpi = 1;
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

    if (valueSelected === 'read_alouds') {
        $('#questionrow').show();
    } else {
        $('#questionrow').hide();
    }

    if (valueSelected === 'repeat_sentences' || valueSelected === 'retell_lectures' || valueSelected ===
        'answer_questions'|| valueSelected === 'respond_situation') {
        $('#transcriptrow').show();
    } else {
        $('#transcriptrow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'retell_lectures' || valueSelected ===
        'repeat_sentences' || valueSelected === 'answer_questions'|| valueSelected === 'respond_situation') {
        $('#resourcerow').show();
    } else {
        $('#resourcerow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'retell_lectures'|| valueSelected === 'respond_situation') {
        $('#keywordsrow').show();
    } else {
        $('#keywordsrow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'answer_questions'|| valueSelected === 'respond_situation') {
        $('#answersrow').show();
    } else {
        $('#answersrow').hide();
    }
});

function getSelectedFormData() {
    // console.log('form loaded')
    var optionSelected = $("#questionType option:selected").text();
    var valueSelected = $("#questionType option:selected").val();
    // console.log(valueSelected)
    $('#headingTitle').text(optionSelected);

    if (valueSelected === 'read_alouds') {
        $('#questionrow').show();
    } else {
        $('#questionrow').hide();
    }

    if (valueSelected === 'repeat_sentences' || valueSelected === 'retell_lectures' || valueSelected ===
        'answer_questions'|| valueSelected === 'respond_situation') {
        $('#transcriptrow').show();
    } else {
        $('#transcriptrow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'retell_lectures' || valueSelected ===
        'repeat_sentences' || valueSelected === 'answer_questions'|| valueSelected === 'respond_situation') {
        $('#resourcerow').show();
    } else {
        $('#resourcerow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'retell_lectures'|| valueSelected === 'respond_situation') {
        $('#keywordsrow').show();
    } else {
        $('#keywordsrow').hide();
    }

    if (valueSelected === 'describe_images' || valueSelected === 'answer_questions'|| valueSelected === 'respond_situation') {
        $('#answersrow').show();
    } else {
        $('#answersrow').hide();
    }
    // console.log(valueSelected)
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