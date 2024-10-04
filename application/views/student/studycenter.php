<style>
    
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}

.record-card {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    color: rgba(0, 0, 0, .65);
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    list-style: none;
    font-feature-settings: "tnum";
    position: relative;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 2px;
    transition: all .3s;
}

.record-card-head {
    min-height: 48px;
    margin-bottom: -1px;
    padding: 0 24px;
    color: rgba(0, 0, 0, .85);
    font-weight: 500;
    font-size: 16px;
    border-bottom: 1px solid #e8e8e8;
}

.record-card-head-wrapper {
    display: flex;
    align-items: center;
}

.record-card-head-title {
    display: inline-block;
    flex: 1;
    padding: 16px 0;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.list-items {
    margin: 0;
    padding: 10px 0px;
    list-style: none;
}

.list-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 24px;
    cursor: pointer;
}

.list-item:hover {
    background-color: #f9f9f9;
}

li {
    font-size: 16px;
    color: #333;
}

.list-item-title {
    margin-bottom: 4px;
    color: rgba(0, 0, 0, .65);
    font-size: 18px;
    line-height: 22px;
}

.icon-right {
    display: inline-block;
    color: inherit;
    font-style: normal;
    line-height: 0;
    text-align: center;
    text-transform: none;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    margin-left: 4px;
    transform: scale(0.8);
}

.target-box .target-score-box .target {
    font-size: 32px;
    color: #333;
}

.target-box .target-score-box .target-label {
    color: #999;
}

.target-overall {
    color: rgba(27,127,204,.8) !important;
}

.target-box {
    cursor: pointer;
}

.target-days-flex {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    justify-content: space-between;
}

.target-col {
    position: relative;
    min-height: 1px;
}

.target-box .target-days .target-days-left {
    border-width: 1px;
    border-style: solid;
    border-color: #fff;
    border-image: initial;
    padding: 3px 7px;
    border-radius: 4px;
}

.target-box .target-score-box {
    padding: 0 20px;
    text-align: center;
    height: 154px;
    padding-bottom: 30px;
}

.target-score-flex {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    justify-content: space-around;
}

.target-box {
    box-shadow: 0px 4px 10px rgba(51, 51, 51, 0.08);
    border-radius: 8px;
    background-color: #fff;
    height: 194px;
    position: relative;
    overflow: hidden;
}

.target-box .target-days {
    color: #fff;
    font-size: 12px;
    padding: 7px 15px;
}

.target-days-details {
    background-color: rgba(27,127,204,.8);
}

.target-box .set-target-label {
    position: absolute;
    right: 18px;
    bottom: 12px;
    color: #999;
    font-size: 12px;
}

.set-target-label-icon {
    display: inline-block;
    color: inherit;
    font-style: normal;
    line-height: 0;
    text-align: center;
    text-transform: none;
    text-rendering: optimizeLegibility;
    margin-left: 4px;
    transform: scale(0.8);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.set-target-label-icon svg {
    display: inline-block;
}

svg:not(:root) {
    overflow: hidden;
}

.set-target-label-icon>* {
    line-height: 1;
}

.modal-content {
    border-radius: 5px;
}

.form-control {
    color: #000000;
    background: #FFFFFF;
    border: 1px solid #EBEBEB;
    border-radius: 3px;
}

input[type="radio"] {
    display: none;
}

.check-radio {
    padding: 4px;
    display: inline-block;
    cursor: pointer;
    border-radius: 50px;
    cursor: pointer;
    color: #ccc;
    background-color: #;
    font-size: 16px;
    width: 112px;
    line-height: 40px;
    text-align: center;
    border-radius: 50px;
}

.checked {
    cursor: pointer;
    color: #fff;
    background-color: rgba(27,127,204,.8);
    font-size: 16px;
    width: 112px;
    line-height: 40px;
    text-align: center;
    border-radius: 50px;
}

.target-input-div {
    display: inline-block;
    text-align: center;
    background: #fafafa;
    cursor: pointer;
    border-radius: 8px;
    width: 72px;
    padding: 8px 0;
    margin-right: 16px;
    margin-bottom: 20px;
}

.target-input-div .target-input-number {
    width: 72px;
    height: 34px;
    font-weight: 400;
    font-size: 24px;
    border: 0;
    background-color: transparent;
}

.target-input-number {
    box-sizing: border-box;
    font-variant: tabular-nums;
    list-style: none;
    font-feature-settings: "tnum";
    position: relative;
    width: 100%;
    height: 32px;
    color: rgba(0, 0, 0, .65);
    font-size: 14px;
    line-height: 1.5;
    background-color: #fff;
    background-image: none;
    transition: all .3s;
    display: inline-block;
    width: 90px;
    margin: 0;
    padding: 0;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
}

.target-input-div .target-input {
    text-align: center;
}

.target-input {
    width: 100%;
    height: 30px;
    padding: 0 11px;
    text-align: left;
    background-color: transparent;
    border: 0;
    border-radius: 4px;
    outline: 0;
    transition: all .3s linear;
}

input {
    margin: 0;
    color: inherit;
    font-size: inherit;
    font-family: inherit;
    line-height: inherit;
}

.target-input-div {
    display: inline-block;
    text-align: center;
    background: #fafafa;
    cursor: pointer;
    border-radius: 8px;
    width: 72px;
    padding: 8px 0;
    margin-right: 16px;
    margin-bottom: 20px;
}

.toast-close {
    color: #000 !important;
}
</style>





<section>
    <div class="panel-section-card py-20 px-10 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">

                <h2 class="section-title mb-3">Target </h2>

            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">

        <div class="row mb-4 ">
            <div class="col-xl-12">
                <div class="card">
                    <div class="target-box">
                        <div class="target-days target-days-details">
                            <div class="target-days-flex">
                                <div class="target-col">Exam Date:
                                    <?php echo strlen($target[0]->exam_date) > 0 ? $target[0]->exam_date : '____-__-__'; ?>
                                </div>
                                <div class="target-col">
                                    <div class="target-days-left">
                                        <?php
                                            $future = strtotime($target[0]->exam_date); //Future date.
                                            $timefromdb = strtotime(date('Y-m-d'));
                                            $timeleft = $future-$timefromdb;
                                            $daysleft = round((($timeleft/24)/60)/60); 
                                            echo $daysleft > 0 ? $daysleft . ' Day left': 0 . ' Day left';
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="target-score-box">
                            <div class="target-score-flex" style="height: 100%;">
                                <div class="target-col">
                                    <div class="target target-overall">
                                        <?php echo strlen($target[0]->overall) > 0 ? $target[0]->overall : '-'; ?>
                                    </div>
                                    <div class="target-label">Overall</div>
                                </div>
                                <div class="target-col">
                                    <div class="target">
                                        <?php echo strlen($target[0]->listening) > 0 ? $target[0]->listening : '-'; ?>
                                    </div>
                                    <div class="target-label">Listening</div>
                                </div>
                                <div class="target-col">
                                    <div class="target">
                                        <?php echo strlen($target[0]->reading) > 0 ? $target[0]->reading : '-'; ?>
                                    </div>
                                    <div class="target-label">Reading</div>
                                </div>
                                <div class="target-col">
                                    <div class="target">
                                        <?php echo strlen($target[0]->speaking) > 0 ? $target[0]->speaking : '-'; ?>
                                    </div>
                                    <div class="target-label">Speaking</div>
                                </div>
                                <div class="target-col">
                                    <div class="target">
                                        <?php echo strlen($target[0]->writing) > 0 ? $target[0]->writing : '-'; ?>
                                    </div>
                                    <div class="target-label">Writing</div>
                                </div>
                            </div>
                        </div>
                        <div class="set-target-label">Set Target
                            <i aria-label="icon: right" class="set-target-label-icon">
                                <svg viewBox="64 64 896 896" class="" data-icon="right" width="1em" height="1em"
                                    fill="currentColor" aria-hidden="true" focusable="false">
                                    <path
                                        d="M765.7 486.8L314.9 134.7A7.97 7.97 0 0 0 302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 0 0 0-50.4z">
                                    </path>
                                </svg>
                            </i>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6"></div>
        </div>
    </div>

</section>

<section>
    <div class="panel-section-card py-20 px-10 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h2 class="section-title mb-3">Today's Record </h2>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">
        <div class="row mb-4">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body px-1">
                        <div class="record-card">
                            <div class="record-card-head">
                                <div class="record-card-head-wrapper">
                                    <div class="record-card-head-title">
                                        <div style="display: flex;justify-content: space-between;">
                                            <div><?php echo date('Y-m-d'); ?></div>
                                            <div>Total Practiced:
                                                <?php echo count($today_practiced) > 0 ? array_sum(array_map("count", $today_practiced)) : 0; ?>
                                                Qs</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <?php 
                                if(count($today_practiced) > 0){
                                    foreach($today_practiced as $row => $rowdata){
                            ?>
                                <ul class="list-items">
                                    <a
                                        href="<?php echo base_url().'user/practicehistory/'.$rowdata[0]->date.'/'.$rowdata[0]->question_type; ?>">
                                        <li class="list-item">
                                            <h4 class="list-item-title">
                                                <?php echo $categories[$rowdata[0]->question_type]; ?></h4>
                                            <span>
                                                Practiced <?php echo count($rowdata); ?> Qs
                                                <i aria-label="icon: right" class="icon-right">
                                                    <svg viewBox="64 64 896 896" class="" data-icon="right" width="1em"
                                                        height="1em" fill="currentColor" aria-hidden="true"
                                                        focusable="false">
                                                        <path
                                                            d="M765.7 486.8L314.9 134.7A7.97 7.97 0 0 0 302 141v77.3c0 4.9 2.3 9.6 6.1 12.6l360 281.1-360 281.1c-3.9 3-6.1 7.7-6.1 12.6V883c0 6.7 7.7 10.4 12.9 6.3l450.8-352.1a31.96 31.96 0 0 0 0-50.4z">
                                                        </path>
                                                    </svg>
                                                </i>
                                            </span>
                                        </li>
                                    </a>
                                </ul>
                                <?php }}else{ ?>
                                <div style="padding:24px 24px; text-align:center;">No record found</div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- <div class="row">				
			<h3 class="fs-20 text-black mb-2 ml-4">History Records </h3>
		</div> -->
<div style="padding:24px 24px; text-align:center;"><a href="<?php echo base_url().'user/practicehistory'; ?>">View
        Previous History</a></div>


</div>
</div>


<!-- setTarget pop up start -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="set-target-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Set Target</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="javascript:void(0);" class="form-valid" id="target-form" method="post"
                    accept-charset="utf-8">
                    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="col-md-4">
                        <label>Date</label>
                        <input type="date" class="form-control" name="exam-date" id="exam-date"
                            value="<?php echo strlen($target[0]->exam_date) > 0 ? date('Y-m-d',strtotime($target[0]->exam_date)) : date('Y-m-d'); ?>"><br>
                    </div>
                    <div class="col-md-8"></div>

                    <div class="col-md-10">
                        <label>Score Target</label>
                        <div style="display:flex; justify-content: space-around;flex-wrap: wrap;">
                            <input type="radio" id="all-79" name="target" value="79"
                                <?php if($target[0]->target == 79){echo 'checked';} ?> />
                            <label class="check-radio <?php if($target[0]->target == 79){echo 'checked';} ?>"
                                for="all-79">All 79</label>

                            <input type="radio" id="all-65" name="target" value="65"
                                <?php if($target[0]->target == 65){echo 'checked';} ?> />
                            <label class="check-radio <?php if($target[0]->target == 65){echo 'checked';} ?>"
                                for="all-65">All 65</label>

                            <input type="radio" id="all-50" name="target" value="50"
                                <?php if($target[0]->target == 50){echo 'checked';} ?> />
                            <label class="check-radio <?php if($target[0]->target == 50){echo 'checked';} ?>"
                                for="all-50">All 50</label>

                            <input type="radio" id="overall-30" name="target" value="30"
                                <?php if($target[0]->target == 30){echo 'checked';} ?> />
                            <label class="check-radio <?php if($target[0]->target == 30){echo 'checked';} ?>"
                                for="overall-30">All 30</label>
                        </div>
                    </div>

                    <div class="col-md-2"></div>

                    <br>
                    <div class="col-md-10" style="display:flex; justify-content: center;    flex-wrap: wrap;">
                        <div class="target-input-div">
                            <div class="target-input-number">
                                <div class="target-input-wrapper">
                                    <input type="number" placeholder="-" class="target-input" autocomplete="off"
                                        maxlength="2" max="90" min="10" step="1"
                                        value="<?php echo $target[0]->overall; ?>" name="overall-target">
                                </div>
                            </div>
                            <div class="target-input-label">Overall</div>
                        </div>

                        <div class="target-input-div">
                            <div class="target-input-number">
                                <div class="target-input-wrapper">
                                    <input type="number" placeholder="-" class="target-input" autocomplete="off"
                                        maxlength="2" max="90" min="10" step="1"
                                        value="<?php echo $target[0]->listening; ?>" name="listening-target">
                                </div>
                            </div>
                            <div class="target-input-label">Listening</div>
                        </div>


                        <div class="target-input-div">
                            <div class="target-input-number">
                                <div class="target-input-wrapper">
                                    <input type="number" placeholder="-" class="target-input" autocomplete="off"
                                        maxlength="2" max="90" min="10" step="1"
                                        value="<?php echo $target[0]->reading; ?>" name="reading-target">
                                </div>
                            </div>
                            <div class="target-input-label">Reading</div>
                        </div>


                        <div class="target-input-div">
                            <div class="target-input-number">
                                <div class="target-input-wrapper">
                                    <input type="number" placeholder="-" class="target-input" autocomplete="off"
                                        maxlength="2" max="90" min="10" step="1"
                                        value="<?php echo $target[0]->speaking; ?>" name="speaking-target">
                                </div>
                            </div>
                            <div class="target-input-label">Speaking</div>
                        </div>


                        <div class="target-input-div">
                            <div class="target-input-number">
                                <div class="target-input-wrapper">
                                    <input type="number" placeholder="-" class="target-input" autocomplete="off"
                                        maxlength="2" max="90" min="10" step="1"
                                        value="<?php echo $target[0]->writing; ?>" name="writing-target">
                                </div>
                            </div>
                            <div class="target-input-label">Writing</div>
                        </div>

                    </div>
                    <div class="col-md-2"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success light" name="targetsubmit"
                    id="targetsubmit">Submit</button>
            </div>
        </div>
    </div>
</div>


<!-- setTarget popup -->
<script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/vendor/canvas/canvas.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/flot/jquery.flot.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/parsley/parsley.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


<script>
const numbers = document.querySelectorAll('input[type="number"]');
const radios = document.querySelectorAll('input[name="target"]');
const siteUrl = '<?php echo base_url(); ?>';

numbers.forEach(number => {
    number.onkeyup = () => {
        isNumber(event)
    }
});

$('.target-box').click(() => {
    $('#set-target-modal').modal('show');
});

$('[name="target"]').change((evt) => {
    val = evt.target.value

    $("input[name='target'] + .check-radio").removeClass('checked');
    $('input[name="target"]:checked + .check-radio').addClass('checked');

    if (val != 30) {
        numbers.forEach(number => {
            if (number.name == 'overall-target') {
                number.value = '';
            } else {
                number.value = val;
            }
        });
    } else if (val == 30) {
        numbers.forEach(number => {
            if (number.name != 'overall-target') {
                number.value = '';
            } else {
                number.value = val;
            }
        });
    }
});

$(function() {
    var today = new Date();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    var year = today.getFullYear();
    if (month < 10)
        month = '0' + month.toString();
    if (day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;

    $('#exam-date').attr('min', maxDate);
    // $('#exam-date').val(maxDate);
});

$('#targetsubmit').click((e) => {
    e.target.disabled = true;
    let inputdata = [];

    numbers.forEach(number => {
        inputdata.push(number.value);
    });

    if (inputdata.some((input) => input > 0)) {
        var form = $('#target-form');
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: siteUrl + "user/setexamtarget",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                form: form.serialize()
            },
            success: function(data) {
                if (data.status == 1) {
                    $('.csrfToken').val(data.token);
                    toast('Target set successfully!');
                    // e.target.disabled = false;
                    // $('#set-target-modal').modal('hide');
                    location.href = siteUrl + 'user/studycenter';
                } else {
                    toast('Failed to set target!');
                    e.target.disabled = false;
                }
            }
        });
    } else {
        toast('Target score is required!');
        e.target.disabled = false;
    }
});

$('input[type="number"]').on('keyup change', (e) => {
    var inputdata = [];
    var inputText = e.target.value;

    numbers.forEach(number => {
        if (number.name != 'overall-target')
            inputdata.push(number.value);
    });

    var validate = inputdata.every((input) => {
        if (e.target.name == 'overall-target') {
            return;
        } else {
            input == inputText;
        }
    });

    $("input[name='target'] + .check-radio").removeClass('checked');

    if (inputdata.every((input) => input == inputText)) {
        radios.forEach(radio => {
            if (radio.value == inputText) {
                radio.checked = true;
                $('input[name="target"]:checked + .check-radio').addClass('checked');
            }
        });
    } else if (inputText == 30 && e.target.name == 'overall-target') {
        $('#overall-30').attr('checked', true);
        $('input[name="target"]:checked + .check-radio').addClass('checked');
    } else {
        $("input[name='target'] + .check-radio").removeClass('checked');
    }
});

function isNumber(evt) {

    var inputText = evt.target.value;

    if (inputText > 90) {
        evt.target.value = 90;
    }

    if (inputText.length > 1) {
        event.preventDefault();
    }

    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}

function toast(message) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#fff",
            color: "#000"
        }
    }).showToast();
}
</script>