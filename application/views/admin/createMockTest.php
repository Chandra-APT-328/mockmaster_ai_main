<style>
table.dataTable {
    width: 100% !important;
}
</style>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>public/js/parsley/parsley.css">



<div class="block">
    <div class="block-content">
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-lg-8 col-xl-12">
                <form
                    action="<?php echo base_url() ?>admin/createmocktest/<?php echo $mock_test_type?>/<?php if(isset($getMockTest) && strlen($getMockTest[0]->id) > 0){ echo $getMockTest[0]->id;} ?>"
                    class="form-valide" id="mock-test-form" method="post" accept-charset="utf-8" data-parsley-validate>
                    
                        <input type="hidden" class="csrfToken"
                            name="<?php echo $this->security->get_csrf_token_name(); ?>"
                            value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="writing_questions" value="">
                        <input type="hidden" name="reading_questions" value="">
                        <input type="hidden" name="listening_questions" value="">
                        <input type="hidden" name="speaking_questions" value="">

                        <div class="section-header">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <h3 class="" id="headingTitle">Create a Mock Test</h3>
                                </div>
                            </div>

                        </div>

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

                        <div class="section-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-validation">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="form-group">

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <label class="col-form-label">Mock Test Name</label>
                                                                    <div class="">
                                                                        <input type="test" class="form-control"
                                                                            id="title" name="test-name"
                                                                            value="<?php echo $getMockTest[0]->title; ?>"
                                                                            onblur="verifytitle();" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                <label class="col-form-label">PTE Type</label>
                                                                    <div>
                                                                        <select id="pteType" class="form-control col-form-label" name="pteType" required>
                                                                            <option value="" selected>Select PTE Type</option>
                                                                            </option>
                                                                            <option value="<?php echo PTEACADEMIC; ?>">PTE Academic</option>
                                                                            </option>
                                                                            <option value="<?php echo PTECORE; ?>">PTE Core</option>
                                                                            </option>
                                                                        </select>
                                                                        </div>
                                                                </div>
                                                                       </div>
                                                            <?php if($mock_test_type == 'section' || $mock_test_type == 'question'){?>
                                                            <div class="row">
                                                                <div id="sub_type_div" class="col-xl-6 d-none">
                                                                    <label class=" col-form-label">Test Sub Type</label>
                                                                    <div class="">
                                                                        <select id="test-sub-type" name="test-sub-type"
                                                                            class="form-control"
                                                                            onChange="sub_type_question()">
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <label for="setTimer"
                                                                        class=" col-form-label">Duration (<span
                                                                            style="color:red;">* </span>
                                                                        minutes)</label>
                                                                    <div class="">
                                                                        <input type="number"
                                                                            class="form-control duration" id="duration"
                                                                            name="section-duration"
                                                                            value="<?php echo $getMockTest[0]->section_duration; ?>"
                                                                            onkeypress="isNumberKey(event)" required>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <?php }else{ ?>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <label for="setTimer"
                                                                        class=" col-form-label">Speaking Duration (<span
                                                                            style="color:red;">* </span>
                                                                        minutes)</label>
                                                                    <div class="">
                                                                        <input type="number"
                                                                            class="form-control duration" id="duration"
                                                                            name="speaking-duration"
                                                                            value="<?php echo $getMockTest[0]->speaking_duration; ?>"
                                                                            onkeypress="isNumberKey(event)" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <label for="setTimer" class="col-form-label">Writing
                                                                        Duration (<span style="color:red;">* </span>
                                                                        minutes)</label>
                                                                    <div class="">
                                                                        <input type="number"
                                                                            class="form-control duration" id="duration"
                                                                            name="writing-duration"
                                                                            value="<?php echo $getMockTest[0]->writing_duration; ?>"
                                                                            onkeypress="isNumberKey(event)" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <label for="setTimer" class="col-form-label">Reading
                                                                        Duration (<span style="color:red;">* </span>
                                                                        minutes)</label>
                                                                    <div class="">
                                                                        <input type="number"
                                                                            class="form-control duration" id="duration"
                                                                            name="reading-duration"
                                                                            value="<?php echo $getMockTest[0]->reading_duration; ?>"
                                                                            onkeypress="isNumberKey(event)" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-xl-6">
                                                                    <label for="setTimer"
                                                                        class=" col-form-label">Listening Duration
                                                                        (<span style="color:red;">* </span>
                                                                        minutes)</label>
                                                                    <div class="">
                                                                        <input type="number"
                                                                            class="form-control duration" id="duration"
                                                                            name="listening-duration"
                                                                            value="<?php echo $getMockTest[0]->listening_duration; ?>"
                                                                            onkeypress="isNumberKey(event)" required>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <?php }?>
                                                            <div class="row">
                                                                <div class="col-xl-6 d-none">
                                                                    <label class=" col-form-label">Test Type<span
                                                                            style="color:red;">*</span></label>
                                                                    <div class="">
                                                                        <select id="test-type" name="test-type"
                                                                            class="form-control"
                                                                            onChange="test_sub_type()">
                                                                            <option value="full-test"
                                                                                <?php echo $getMockTest[0]->test_type == 'full-test' ? 'selected' : ($mock_test_type == 'full' ? 'selected' : ''); ?>>
                                                                                Full Test</option>
                                                                            <option value="section-test"
                                                                                <?php echo $getMockTest[0]->test_type == 'section-test' ? 'selected': ($mock_test_type == 'section' ? 'selected' :''); ?>>
                                                                                Section Test</option>
                                                                            <option value="question-test"
                                                                                <?php echo $getMockTest[0]->test_type == 'question-test' ? 'selected': ($mock_test_type == 'question' ? 'selected' : ''); ?>>
                                                                                Question Test</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="row">
                                                                <div class="col-xl-6 mt-4">
                                                                    <input type="button" name="submit_btn"
                                                                        id="submit_btn" class="btn btn-primary"
                                                                        value="Submit">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title">Select Questions to Add</h4>
                                        </div>
                                        <div class="card-body">
                                            <!-- Nav tabs -->
                                            <div class="custom-tab-1">
                                                <ul class="nav nav-tabs">
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link active" data-toggle="tab"
                                                            data-model="reading" href="#reading">Reading Questions</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="writing" href="#writing">Writing Questions</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="listening" href="#listening">Listening
                                                            Questions</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="section-select nav-link" data-toggle="tab"
                                                            data-model="speaking" href="#speaking">Speaking
                                                            Questions</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane fade show active" id="reading" role="tabpanel">
                                                        <div
                                                            class="col-md-4 m-3 pt-2 h2 float-right text-right reading-selection-count">
                                                            <span>0</span> Selected
                                                        </div>
                                                        <div class="pt-4 table-responsive">
                                                            <table id="reading-model-questions"
                                                                class="question-table display min-w850"
                                                                data-model="reading">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle"><input type="checkbox"
                                                                                name="check" id="select-all-r"
                                                                                data-parsley-multiple="check"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="writing" role="tabpanel">
                                                        <div
                                                            class="col-md-4 m-3 pt-2 h2 float-right text-right writing-selection-count">
                                                            <span>0</span> Selected
                                                        </div>
                                                        <div class="pt-4 table-responsive">
                                                            <table id="writing-model-questions"
                                                                class="question-table display min-w850"
                                                                data-model="writing">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle"><input type="checkbox"
                                                                                name="check" id="select-all-w"
                                                                                data-parsley-multiple="check"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="listening" role="tabpanel">
                                                        <div
                                                            class="col-md-4 m-3 pt-2 h2 float-right text-right listening-selection-count">
                                                            <span>0</span> Selected
                                                        </div>
                                                        <div class="pt-4 table-responsive">
                                                            <table id="listening-model-questions"
                                                                class="question-table display min-w850"
                                                                data-model="listening">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle"><input type="checkbox"
                                                                                name="check" id="select-all-l"
                                                                                data-parsley-multiple="check"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="speaking" role="tabpanel">
                                                        <div
                                                            class="col-md-4 m-3 pt-2 h2 float-right text-right speaking-selection-count">
                                                            <span>0</span> Selected
                                                        </div>
                                                        <div class="pt-4 table-responsive">
                                                            <table id="speaking-model-questions"
                                                                class="question-table display min-w850"
                                                                data-model="speaking">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="align-middle"><input type="checkbox"
                                                                                name="check" id="select-all-s"
                                                                                data-parsley-multiple="check"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </thead>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th class="align-middle"></th>
                                                                        <th class="align-middle">#</th>
                                                                        <th class="align-middle">Question</th>
                                                                        <th class="align-middle">Question Type</th>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
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

<!--**********************************
            Content body end
        ***********************************-->

<!--**********************************
        Scripts
    ***********************************-->
<!-- Required vendors -->
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/poper/popper.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/bootstrap/bootstrap.min.js"></script> -->
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>



<script type="text/javascript">
const mock_test_id = <?php echo $getMockTest[0] ? $getMockTest[0]->id : 0 ?>;
const previous_writing_questions =
    <?php echo $getMockTest[0]->writing ? json_encode(explode(',',$getMockTest[0]->writing)) : '[]'; ?>;
const previous_reading_questions =
    <?php echo $getMockTest[0]->reading ? json_encode(explode(',',$getMockTest[0]->reading)) : '[]'; ?>;
const previous_listening_questions =
    <?php echo $getMockTest[0]->listening ? json_encode(explode(',',$getMockTest[0]->listening)) : '[]'; ?>;
const previous_speaking_questions =
    <?php echo $getMockTest[0]->speaking ? json_encode(explode(',',$getMockTest[0]->speaking)) : '[]'; ?>;
let selected_questions = [{
    writing: new Set([...previous_writing_questions]),
    reading: new Set([...previous_reading_questions]),
    listening: new Set([...previous_listening_questions]),
    speaking: new Set([...previous_speaking_questions]),
}];
let url = "<?php echo base_url('admin/getquestionslist'); ?>";

$(document).ready(function() {
    $('.section-select').removeClass('d-none');
    test_sub_type();
    $('.question-table').each(function() {
        const current_category = $(this).attr('data-model');
        if ($('#test-type option:selected').val() == 'question-test') {
            var sub_category = $('#test-type option:selected').val();
        }
        $(this).DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            dataType: "json",
            paging: true,
            pagingType: "simple_numbers",
            order: [],
            pageLength: 50,
            "ajax": {
                "url": url,
                // "type": "POST",
                "data": function(data) {
                    data.category = current_category;
                    data.mock_test_id = mock_test_id;
                    data.sub_category = sub_category;
                },
                "complete": function(data) {
                    $("input[name='selected_" + current_category.charAt(0) + "[]']").on(
                        'change',
                        function() {
                            if ($(this).is(':checked')) {
                                selected_questions[0][current_category].add($(this)
                                    .val());
                            } else {
                                selected_questions[0][current_category].delete($(this)
                                    .val());
                            }
                            $('.' + current_category + '-selection-count span').text(
                                selected_questions[0][current_category].size);
                        });

                    $("input[name='selected_" + current_category.charAt(0) + "[]']").each(
                        function() {
                            if (selected_questions[0][current_category].has($(this)
                                    .val())) {
                                $(this).attr('checked', true);
                            }
                        })

                    $('.' + current_category + '-selection-count span').text(
                        selected_questions[0][current_category].size);
                }
            },
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }],
            "initComplete": function(settings, json) {
                $('#question_count').html(json.question_count);
            }
        });
    });


    $('#select-all-r').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $("input[name='selected_r[]']").each(function() {
                this.checked = true;
                selected_questions[0]['reading'].add(this.value);
            });
        } else {
            $("input[name='selected_r[]']").each(function() {
                this.checked = false;
                selected_questions[0]['reading'].delete(this.value);
            });
        }
        $('.reading-selection-count span').text(selected_questions[0]['reading'].size);
    });

    $('#select-all-w').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $("input[name='selected_w[]']").each(function() {
                this.checked = true;
                selected_questions[0]['writing'].add(this.value);
            });
        } else {
            $("input[name='selected_w[]']").each(function() {
                this.checked = false;
                selected_questions[0]['writing'].delete(this.value);
            });
        }
        $('.writing-selection-count span').text(selected_questions[0]['writing'].size);
    });

    $('#select-all-l').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $("input[name='selected_l[]']").each(function() {
                this.checked = true;
                selected_questions[0]['listening'].add(this.value);
            });
        } else {
            $("input[name='selected_l[]']").each(function() {
                this.checked = false;
                selected_questions[0]['listening'].delete(this.value);
            });
        }
        $('.listening-selection-count span').text(selected_questions[0]['listening'].size);
    });

    $('#select-all-s').click(function(event) {
        if (this.checked) {
            // Iterate each checkbox
            $("input[name='selected_s[]']").each(function() {
                this.checked = true;
                selected_questions[0]['speaking'].add(this.value);
            });
        } else {
            $("input[name='selected_s[]']").each(function() {
                this.checked = false;
                selected_questions[0]['speaking'].delete(this.value);
            });
        }
        $('.speaking-selection-count span').text(selected_questions[0]['speaking'].size);
    });

    $('#submit_btn').click(function() {
        var form = $('#mock-test-form');

        form.parsley().validate();
        if (!form.parsley().isValid()) {
            return false;
        } else {
            $("[name='reading_questions'").val(Array.from(selected_questions[0]['reading']).join(','));
            $("[name='writing_questions'").val(Array.from(selected_questions[0]['writing']).join(','));
            $("[name='listening_questions'").val(Array.from(selected_questions[0]['listening']).join(
                ','));
            $("[name='speaking_questions'").val(Array.from(selected_questions[0]['speaking']).join(
                ','));
            $('#mock-test-form').submit();
        }
    });

});

function verifytitle() {
    var siteUrl = '<?php echo base_url(); ?>';
    var formData = $("#mock-test-form").serialize();
    $.ajax({
        url: siteUrl + "admin/getmocktestname",
        type: "POST",
        crossDomain: true,
        dataType: 'json',
        cache: false,
        data: formData,
        stateSave: true,
        success: function(data) {
            $('.csrfToken').val(data.token);
            if (data.status == 1) {
                $("#title").after(
                    '<ul class="parsley-errors-list filled" id="titleerr" style="padding-top:6px; margin-left:10px;"><li class="parsley-required">Mock Test already exist.</li></ul>'
                );
            } else {
                $('#titleerr').remove();
            }

        }
    });
}

function isNumberKey(evt) {
    if (evt.target.name == 'duration') {
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
</script>
<script>
function test_sub_type() {
    sub_type_question();
    $('.section-select').removeClass('d-none');
    var type_selected = $('#test-type option:selected').val();
    $('#test-sub-type').html('');

    // console.log(type_selected);
    if (type_selected == 'section-test') {
        $('#sub_type_div').removeClass('d-none');
        var selected_test_sub = mock_test_id ? '<?php echo $getMockTest[0]->test_sub_type; ?>' : '';
        var selected_reading = selected_test_sub == 'reading' ? 'selected' : '';
        var selected_writing = selected_test_sub == 'writing' ? 'selected' : '';
        var selected_speaking = selected_test_sub == 'speaking' ? 'selected' : '';
        var selected_listening = selected_test_sub == 'listening' ? 'selected' : '';

        console.log(selected_speaking);
        $('#test-sub-type').append('<option value="reading"' + selected_reading + '>Reading</option>');
        $('#test-sub-type').append('<option value="listening"' + selected_listening + '>Listening</option>');
        $('#test-sub-type').append('<option value="speaking"' + selected_speaking + '>Speaking</option>');
        $('#test-sub-type').append('<option value="writing"' + selected_writing + '>Writing</option>');
        // var options = ` <option value="reading">Reading</option>
        //                 <option value="listening">Listening</option>
        //                 <option value="speaking">Speaking</option>
        //                 <option value="writing">Writing</option>`;
        // $('#test-sub-type').html(options);
        sub_type_question();
    } else if (type_selected == 'question-test') {
        var siteUrl = '<?php echo base_url(); ?>';
        $('#sub_type_div').removeClass('d-none');
        $.ajax({
            url: siteUrl + "admin/getquestiontypes",
            type: "GET",
            crossDomain: true,
            dataType: 'json',
            success: function(data) {
                $('.csrfToken').val(data.token);
                if (data.status == 1) {
                    var selected = mock_test_id ? '<?php echo $getMockTest[0]->test_sub_type ?>' : '';
                    data.getquestiontypes.map((val) => {
                        if (selected == val.question_code) {
                            $('#test-sub-type').append('<option value="' + val.question_code +
                                '" selected>' + val.type_name + '</option>');
                        } else {
                            $('#test-sub-type').append('<option value="' + val.question_code +
                                '">' + val.type_name + '</option>');
                        }
                    })
                }
                sub_type_question();
            }
        });
    } else {
        $('#sub_type_div').addClass('d-none');
    }
}

function sub_type_question() {
    $('.section-select').removeClass('d-none');
    var type_selected = $('#test-type option:selected').val();
    var selected_sub_type = $('#test-sub-type option:selected').val();
    if (type_selected == 'section-test') {
        $('.section-select').each(function() {
            // console.log($(this).attr('data-model'));
            if (selected_sub_type == $(this).attr('data-model')) {
                $(this).click();
            } else {
                $(this).addClass('d-none');
            }
        })
    } else {
        $('.question-table').each(function() {
            const current_category = $(this).attr('data-model');
            var sub_category;
            if ($('#test-type option:selected').val() == 'question-test') {
                sub_category = $('#test-sub-type option:selected').val();
            }
            // console.log(sub_category);
            $(this).DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                dataType: "json",
                paging: true,
                pagingType: "simple_numbers",
                order: [],
                pageLength: 50,
                "ajax": {
                    "url": url,
                    // "type": "POST",
                    "data": function(data) {
                        data.category = current_category;
                        data.mock_test_id = mock_test_id;
                        data.sub_category = sub_category;
                    },
                    "complete": function(data) {
                        $("input[name='selected_" + current_category.charAt(0) + "[]']").on(
                            'change',
                            function() {
                                if ($(this).is(':checked')) {
                                    selected_questions[0][current_category].add($(this).val());
                                } else {
                                    selected_questions[0][current_category].delete($(this)
                                        .val());
                                }
                                $('.' + current_category + '-selection-count span').text(
                                    selected_questions[0][current_category].size);
                            });

                        $("input[name='selected_" + current_category.charAt(0) + "[]']").each(
                            function() {
                                if (selected_questions[0][current_category].has($(this)
                                        .val())) {
                                    $(this).attr('checked', true);
                                }
                            })

                        $('.' + current_category + '-selection-count span').text(selected_questions[
                            0][current_category].size);
                    }
                },
                "columnDefs": [{
                    "targets": [0],
                    "orderable": false
                }],
                "initComplete": function(settings, json) {
                    $('#question_count').html(json.question_count);
                }
            });
        });

    }
}
</script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/js/scripts.js"></script>