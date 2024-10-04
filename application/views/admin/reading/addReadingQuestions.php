<link href="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>public/js/plugins/ckeditor/ckeditor.js"></script>

        <div class="block">
            <div class="block-content">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-8 col-xl-12">
                        <form class="mb-5" id="addreadingquestions"
                            action="<?php echo base_url();?>admin/addreadingquestions/<?php if(isset($getReadingData) && strlen($getReadingData[0]->id) > 0){ echo $getReadingData[0]->id;} ?>"
                            method="POST" enctype="multipart/form-data">
                            <input type="hidden" class="csrfToken"
                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
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
                                                    <?php if(isset($getReadingData) && strlen($getReadingData[0]->question_type == $rowdata->question_code)){ echo "selected"; } ?>>
                                                    <?php echo $rowdata->type_name;  ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- title -->
                            <div class="section-body">
                            <div class="row">
                            <div class="col-lg-12">                            
                            <div class="card"> 
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <label class="form-label" for="questionTitle">Title</label>
                                            <input type="text" class="form-control" id="questionTitle"
                                                name="questionTitle"
                                                value="<?php if(isset($getReadingData) && strlen($getReadingData[0]->title) > 0){ echo $getReadingData[0]->title;} ?>"
                                                required>
                                        </div>
                                    </div>

                                    <!-- questions row -->
                                    <div class="row mb-4" id="questionrow">
                                        <div class="col-12">
                                            <label class="form-label" for="question">Question</label>
                                            <textarea class="form-control" id="question" rows="12"
                                                name="question"><?php if(isset($getReadingData) && strlen($getReadingData[0]->question) > 0){ echo $getReadingData[0]->question;} ?></textarea>
                                        </div>
                                    </div>

                                    <!-- fill in the blanks -->
                                    <div class="row mb-4" style="display:none;" id="fitbrow">
                                        <div class="col-12">
                                            <label class="form-label" for="fitb">Fill in the blanks (*write the blank
                                                answers in
                                                the {} brackets)</label>
                                            <textarea class="form-control" id="fitb" rows="12"
                                                name="fitb"><?php if(isset($getReadingData) && strlen($getReadingData[0]->question) > 0){ echo $getReadingData[0]->question;} ?></textarea>
                                        </div>
                                    </div>

                                    <!-- fill in the blanks options -->
                                    <div class="row mb-4" style="display:none;" id="fitbOptionsRow">
                                        <div class="col-11">
                                            <label class="form-label">Fill in the Blanks Drop Options (comma (,)
                                                seperated)</label>
                                            <div class="offset-1" id="fitbOptions"></div>
                                            <div class="offset-1" id="addCheckOption" style="padding-left:10px;">
                                                <span>Add
                                                    Option </span><i class="fa fa-plus" aria-hidden="true"
                                                    onclick="addFITBKPI()"></i></div>
                                        </div>
                                    </div>

                                    <!-- multiple choice question -->
                                    <div class="row mb-4" style="display:none;" id="multipleChoiceOptionsrow">
                                        <div class="col-11">
                                            <label class="form-label">Multiple Choice (Multiple) Options</label>
                                            <div class="offset-1" id="checkOptions"></div>
                                            <div class="offset-1" id="addCheckOption" style="padding-left:10px;">
                                                <span>Add
                                                    Question </span><i class="fa fa-plus" aria-hidden="true"
                                                    onclick="addMCMKPI()"></i></div>
                                        </div>
                                    </div>

                                    <!-- single choice question -->
                                    <div class="row mb-4" style="display:none;" id="singleChoiceOptionsrow">
                                        <div class="col-11">
                                            <label class="form-label" id="singleChoiceOptionsLabel"></label>
                                            <div class="offset-1" id="checkSingleOptions"></div>
                                            <div class="offset-1" id="addSingleOption" style="padding-left:10px;">
                                                <span>Add
                                                    Question </span><i class="fa fa-plus" aria-hidden="true"
                                                    onclick="addMCSKPI()"></i></div>
                                        </div>
                                    </div>

                                    <!-- reorder paragraphs -->
                                    <div class="row mb-4" style="display:none;" id="ro-paragraphs-row">
                                        <div class="col-11">
                                            <label class="form-label">Reorder Paragraphs (in jumbled way)</label>
                                            <div class="offset-1" id="ro-paragraphs"></div>
                                            <div class="offset-1" id="add-paragraph" style="padding-left:10px;">
                                                <span>Add Paragraph </span><i class="fa fa-plus" aria-hidden="true"
                                                    onclick="addROKPI()"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- reorder paragraphs answer -->
                                    <div class="row mb-4" style="display:none;" id="ro-paragraphs-answer-row">
                                        <div class="col-11">
                                            <label class="form-label">Reorder Paragraphs Answer Sequence (comma (,)
                                                seperated in numeric)</label>
                                            <div class="offset-1 mt-2">
                                                <input type="text" class="form-control" id="ro-answer" name="ro-answer"
                                                    value="<?php if(isset($getReadingData) && strlen($getReadingData[0]->answer) > 0){ echo implode(',',json_decode($getReadingData[0]->answer));} ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- timer -->
                                    <div class="row mb-4" id="timerrow">
                                        <?php
                                    $min="1";$sec="0";
                                    if(isset($getReadingData) && strlen($getReadingData[0]->exam_duration) > 0){ 
                                        $time = explode(":", $getReadingData[0]->exam_duration);
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





<script>
CKEDITOR.replace('question');
</script>
<script>
// var tmpKPI = [1,2,3,4,5];
var kpi = 1;
$(document).ready(function() {
    getSelectedFormData();

    isFormEdit =
        <?php echo (isset($getReadingData) && strlen($getReadingData[0]->options) > 0) ? 'true' : 'false'; ?>;
    kpiCount = parseInt(
        <?php echo (isset($getReadingData) && strlen($getReadingData[0]->options) > 0) ? count(json_decode($getReadingData[0]->options)) : '5'; ?>
    );
    editFormCheckValue =
        <?php echo (isset($getReadingData) && strlen($getReadingData[0]->answer) > 0) ? json_encode($getReadingData[0]->answer) : '0'; ?>;
    editFormCheckOptions =
        <?php echo (isset($getReadingData) && strlen($getReadingData[0]->options) > 0) ? json_encode($getReadingData[0]->options) : '0' ; ?>;
    editFormCheckValue = JSON.parse(editFormCheckValue);
    editFormCheckOptions = JSON.parse(editFormCheckOptions);

    if (isFormEdit === true && $("#questionType option:selected").val() == 'r_mcm') {
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

    if (isFormEdit === true && $("#questionType option:selected").val() == 'r_mcs') {
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

    if (isFormEdit === true && $("#questionType option:selected").val() == 'fib_wr') {
        for (let index = 0; index < kpiCount; index++) {
            // console.log(editFormCheckOptions[index].join(", "))
            $('#fitbOptions').append("<div id='fitbOption" + kpi +
                "'><label class='form-label' id='fitbOptionLabel" + kpi +
                "' style='float:right; margin-right:42px;'>Dropdown " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='optionsValue" +
                kpi +
                "' name='optionValues[]' value='" + editFormCheckOptions[index].join(", ") +
                "'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeFITBKPI(" + kpi + ")'></i></span></div></div>");
            kpi++;
        }
    }

    if (isFormEdit === true && $("#questionType option:selected").val() == 'fib_rd') {
        $('#fitbOptions').append(
            "<div id='fitbOption'><label class='form-label' id='fitbOptionLabel' style='float:right; margin-right:42px;'>Dropdown value</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='optionsValue' name='optionValue' value='" +
            editFormCheckOptions.join(", ") + "'></div></div>");

        $('#addCheckOption').hide();
    }

    if (isFormEdit === true && $("#questionType option:selected").val() == 'ro') {
        for (let index = 0; index < kpiCount; index++) {
            $('#ro-paragraphs').append("<div id='ro-paragraph" + kpi +
                "'><label class='form-label' id='ro-paragraph-label" + kpi +
                "' style='float:right; margin-right:42px;'>Paragraph " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='paragraph" +
                kpi +
                "' name='paragraph[]' value='" + editFormCheckOptions[index] +
                "'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='remove-paragraph" +
                kpi + "' aria-hidden='true' onclick='removeROKPI(" + kpi + ")'></i></span></div></div>");
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

function addFITBKPI() {
    $('#fitbOptions').append("<div id='fitbOption" + kpi + "'><label class='form-label' id='fitbOptionLabel" + kpi +
        "' style='float:right; margin-right:42px;'>Dropdown " + kpi +
        "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='optionsValue" +
        kpi +
        "' name='optionValues[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
        kpi + "' aria-hidden='true' onclick='removeFITBKPI(" + kpi + ")'></i></span></div></div>");
    kpi++;
}

function addROKPI() {
    $('#ro-paragraphs').append("<div id='ro-paragraph" + kpi + "'><label class='form-label' id='ro-paragraph-label" +
        kpi + "' style='float:right; margin-right:42px;'>Paragraph " + kpi +
        "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='paragraph" +
        kpi +
        "' name='paragraph[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='remove-paragraph" +
        kpi + "' aria-hidden='true' onclick='removeROKPI(" + kpi + ")'></i></span></div></div>");
    kpi++;
}

function removeMCMKPI(id) {
    $('#checkOption' + id).remove();
}

function removeMCSKPI(id) {
    $('#singleOption' + id).remove();
}

function removeFITBKPI(id) {
    $('#fitbOption' + id).remove();
}

function removeROKPI(id) {
    $('#ro-paragraph' + id).remove();
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
    if ($("#questionType option:selected").val() == 'r_mcs') {
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

    if (CKEDITOR.instances['question']) {
        CKEDITOR.instances['question'].destroy(true);
    }
    CKEDITOR.replace('question');

    setForm(valueSelected);

    kpi = 1;

    $('#checkOptions').empty();
    $('#checkSingleOptions').empty();
    $('#fitbOptions').empty();
    $('#ro-paragraphs').empty();
    $('#addCheckOption').show();

    if (valueSelected === 'r_mcm') {
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
        $('#multipleChoiceOptionsrow').hide();
    }

    if (valueSelected === 'r_mcs') {
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

        $('#singleChoiceOptionsrow').show();
    } else {
        $('#singleChoiceOptionsrow').hide();
    }

    if (valueSelected === 'fib_wr') {
        for (let index = 0; index < kpiCount; index++) {
            $('#fitbOptions').append("<div id='fitbOption" + kpi +
                "'><label class='form-label' id='fitbOptionLabel" + kpi +
                "' style='float:right; margin-right:42px;'>Dropdown " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='optionsValue" +
                kpi +
                "' name='optionValues[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='singleOptionMinus" +
                kpi + "' aria-hidden='true' onclick='removeFITBKPI(" + kpi + ")'></i></span></div></div>");
            kpi++;
        }

        $('#fitbOptionsRow').show();
    } else if ((valueSelected === 'fib_rd')) {
        $('#fitbOptions').append(
            "<div id='fitbOption'><label class='form-label' id='fitbOptionLabel' style='float:right; margin-right:42px;'>Dropdown value</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='optionsValue' name='optionValue'></div></div>"
            );

        $('#addCheckOption').hide();
        $('#fitbOptionsRow').show();
    } else {
        $('#fitbOptionsRow').hide();
    }

    if (valueSelected === 'ro') {
        for (let index = 0; index < kpiCount; index++) {
            $('#ro-paragraphs').append("<div id='ro-paragraph" + kpi +
                "'><label class='form-label' id='ro-paragraph-label" + kpi +
                "' style='float:right; margin-right:42px;'>Paragraph " + kpi +
                "</label><div class='form-check mb-4 form-check-inline col-12'><input type='text' class='form-control' id='paragraph" +
                kpi +
                "' name='paragraph[]'><span style='margin-left:16px;float:right;'><i class='fa fa-minus' id='remove-paragraph" +
                kpi + "' aria-hidden='true' onclick='removeROKPI(" + kpi + ")'></i></span></div></div>");
            kpi++;
        }
        $('#ro-paragraphs-row').show();
    } else {
        $('#ro-paragraphs-row').hide();
    }
});

function getSelectedFormData() {
    var optionSelected = $("#questionType option:selected").text();
    var valueSelected = $("#questionType option:selected").val();
    $('#headingTitle').text(optionSelected);

    setForm(valueSelected);

    (valueSelected === 'r_mcm') ? $('#multipleChoiceOptionsrow').show(): $('#multipleChoiceOptionsrow').hide();
    (valueSelected === 'r_mcs') ? $('#singleChoiceOptionsrow').show(): $('#singleChoiceOptionsrow').hide();
    (valueSelected === 'fib_wr') || (valueSelected === 'fib_rd') ? $('#fitbOptionsRow').show(): $('#fitbOptionsRow')
        .hide();
    (valueSelected === 'ro') ? $('#ro-paragraphs-row').show(): $('#ro-paragraphs-row').hide();
}

function setForm(valueSelected) {
    switch (valueSelected) {
        case 'fib_wr':
            $('#questionrow').hide();
            $('#fitbrow').show();
            $('#ro-paragraphs-answer-row').hide();
            break;
        case 'r_mcm':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#ro-paragraphs-answer-row').hide();
            break;
        case 'r_mcs':
            $('#questionrow').show();
            $('#fitbrow').hide();
            $('#ro-paragraphs-answer-row').hide();
            break;
        case 'fib_rd':
            $('#questionrow').hide();
            $('#fitbrow').show();
            $('#ro-paragraphs-answer-row').hide();
            break;
        case 'ro':
            $('#questionrow').hide();
            $('#ro-paragraphs-answer-row').show();
            $('#fitbrow').hide();
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