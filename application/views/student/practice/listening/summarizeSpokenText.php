<title>PTE Listening Mock Test with Answers | A One Australia</title>
<meta name="keywords" content="pte listening mock test, pte listening mock test with answers">
<meta name="description" content="Enhance your PTE preparation with our PTE Listening Mock Test with Answers. Practice and excel in the PTE Listening mock test section with confidence">
<style>
.imp {
    color: red;
}

.popover-body {
    font-size: 14px;
}

.answer-box {
    margin-top: 10px;
    user-select: none;
}
.textareafield{
    border: 1px solid #c3c0c0 !important;
}
.answer-divider-horizontal.answer-divider-with-text-left {
    display: table;
    margin: 16px 0;
    color: rgba(0, 0, 0, .85);
    font-weight: 500;
    font-size: 16px;
    white-space: nowrap;
    text-align: center;
    background: transparent;
}

.answer-divider-horizontal {
    display: block;
    clear: both;
    width: 100%;
    min-width: 100%;
    height: 1px;
    margin: 24px 0;
}

.answer-divider {
    position: relative;
    top: -0.06em;
    display: inline-block;
    width: 1px;
    height: 0.9em;
    margin: 0 8px;
    vertical-align: middle;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    color: rgba(0, 0, 0, .65);
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    list-style: none;
    font-feature-settings: "tnum";
    background: #e8e8e8;
}

.answer-divider-horizontal.answer-divider-with-text-left:before {
    top: 50%;
    width: 5%;
}

.answer-divider-horizontal.answer-divider-with-text-left:before {
    position: relative;
    top: 50%;
    display: table-cell;
    width: 50%;
    border-top: 1px solid #e8e8e8;
    transform: translateY(50%);
    content: "";
}

.answer-divider-horizontal.answer-divider-with-text-left:after,
.answer-divider-horizontal.answer-divider-with-text-left:before {
    position: relative;
    top: 50%;
    display: table-cell;
    width: 50%;
    border-top: 1px solid #e8e8e8;
    transform: translateY(50%);
    content: "";
}

.answer-divider-horizontal.answer-divider-with-text-left:after,
.answer-divider-horizontal.answer-divider-with-text-right:before {
    top: 50%;
    width: 95%;
}

.audio {
    width: 100%;
    outline: none;
    border: 1px solid #e9e9e9;
    border-top: none;
    background: #F1F3F4;
}
textarea.form-control{
    font-size: 18px;
    line-height: 1.7;
    font-weight: 500;
}
</style>
<!-- ssts -->

<section>
    <div class="panel-section-card py-20 px-15 mt-20">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12 col-md-12">
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




                        <h2 class="section-title mb-3">Summarize Spoken Text</h2>
                        <span class="paragraph">You will hear a short report. Write a summary for a fellow student who
                            was not present. You should write 50-70 words. You have 10 minutes to finish this task. Your
                            response will be judged on the quality of your writing and on how well your response
                            presents the key points presented in the lecture.</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">
        <form class="mb-5" id="ssts"
            action="<?php echo base_url();?>user/ssts/<?php if(isset($getQuestionData) && strlen($getQuestionData[0]->id) > 0){ echo $getQuestionData[0]->id;} ?>"
            method="POST" enctype="multipart/form-data">
            <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="task_details" data-type="<?php echo $getQuestionData[0]->question_type; ?>" data-questionid="<?php echo $getQuestionData[0]->id; ?>">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body px-2">
                            <div class="row justify-content-between px-10 align-items-center">
                                <div class="col-11 col-md-7 p-0">
                                    <p class="mb-10 font-weight-bold">
                                        <?php if(isset($getQuestionData[0]->title) && strlen($getQuestionData[0]->title) > 0){ echo "#".$getQuestionData[0]->id." ".$getQuestionData[0]->title;} ?>
                                    </p>
                                </div>
                                <div class="">
                                    <small class="mb-10 float-right">
                                        <a href="javascript:void(0);" class="text-gray font-14" data-toggle="modal" data-target="#feedback-modal"><span class="d-none d-sm-inline">Report an issue&nbsp;</span><i class="fa fa-regular fa-question-circle"></i></a>
                                    </small>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12 imp">
                                    <span id="timer-label"></span><span id="timer"></span>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <audio id="questionAudio" class="audio" controls
                                        controlsList="nodownload noplaybackrate" style="width:100%" ;>
                                        <source
                                            src="<?php if(isset($getQuestionData) && strlen($getQuestionData[0]->audioPath) > 0){ echo base_url().$getQuestionData[0]->audioPath;} ?>"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <label class="form-label" for="answerText">Your answer</label>
                                    <textarea class="form-control textareafield" cols="40" id="answerText" rows="12" name="answer"
                                        required></textarea>
                                    <div class="mt-3 pl-2"><span id="wordCount">0</span> Word(s)</div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <input type="submit" class="btn btn-primary" id="submit" name="submit"
                                        value="Submit" />

                                    <input type="button" class="btn btn-primary" id="redo" name="redo"
                                        data-id="<?php echo $getQuestionData[0]->id; ?>" value="Redo" />

                                    <label class="answer-toggle ml-1 align-middle">
                                        <input type="checkbox" id="toggle-answer" />
                                        <span class="slider"></span>
                                        <span class="labels" data-on="Answer" data-off="Answer"></span>
                                    </label>
                                </div>
                                <div class="col-md-6 prevnext_btn quebuttons">
                                    <input type="button" class="btn btn-warning" id="previous" value="Previous"
                                        <?php if(!isset($prev_id)){echo 'disabled';} ?> />
                                    <input type="button" class="btn btn-success" id="next" value="Next"
                                        <?php if(!isset($next_id)){echo 'disabled';} ?> />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>


<section class="mt-35 ">
    <div class="panel-section-card card answer-card d-none py-20 px-10 mt-20">
        <div class="card-body">
            <div class="answer-box">
                <div class="answer-divider answer-divider-horizontal answer-divider-with-text-left" role="separator">
                    <span>Answer</span>
                </div>
                <div>
                    <h4>Transcript:</h4>
                    <div><?php echo strip_tags($getQuestionData[0]->transcript, '<p>'); ?></div>
                </div>

                <?php if(strlen($getQuestionData[0]->answer) > 0){ ?>
                <h4>Answer:</h4>
                <div><?php echo strip_tags($getQuestionData[0]->answer, '<p>'); ?></div>
                <?php } ?>

                <?php if($getQuestionData[0]->explanation){ ?>
                <h4>Explanation:</h4>
                <div><?php echo strip_tags($getQuestionData[0]->explanation, '<p>'); ?></div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Discussion's -->
<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">
        <div class="row mb-15">
            <?php $this->load->view('student/practice/discussionPanel'); ?>
        </div>
    </div>
</section>


<!-- result pop up start -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="resultModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Score</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-responsive-sm">
                        <thead>
                            <tr>
                                <th>Component</th>
                                <th>Score</th>
                                <!-- <th>Suggestion</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Content <i aria-label="icon: info-circle" tabindex="-1"
                                        class="info"
                                        onclick="toogleTips('content');"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="content"></span><?php echo '/2'; ?></td>
                                <!-- <td><span class="suggestion"></span></td> -->
                            </tr>
                            <tr>
                                <td>Form <i aria-label="icon: info-circle" tabindex="-1"
                                        class="info"
                                        onclick="toogleTips('form');"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="_form"></span><?php echo '/2'; ?></td>
                                <!-- <td><span class="suggestion"></span></td> -->
                            </tr>
                            <tr>
                                <td>Grammar <i aria-label="icon: info-circle" tabindex="-1"
                                        class="info"
                                        onclick="toogleTips('grammar');"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="grammar"></span><?php echo '/2'; ?></td>
                                <!-- <td><span class="suggestion"></span></td> -->
                            </tr>
                            <tr>
                                <td>Spelling <i aria-label="icon: info-circle" tabindex="-1"
                                        class="info"
                                        onclick="toogleTips('spelling');"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="spelling"></span><?php echo '/2'; ?></td>
                                <!-- <td><span class="suggestion"></span></td> -->
                            </tr>
                            <tr>
                                <td>Vocabulary <i aria-label="icon: info-circle" tabindex="-1"
                                        class="info"
                                        onclick="toogleTips('vocabulary');"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="vocabulary"></span><?php echo '/2'; ?></td>
                                <!-- <td><span class="suggestion"></span></td> -->
                            </tr>
                            <tr>
                                <td colspan="3">Max Score：<?php echo $maxScore; ?>, Your Score：<span
                                        class="myScore"></span></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="user-response"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- result popup -->

<!-- tips -->
<div class="modal fade" id="tipsModel" role="dialog" tabindex="-2" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tips</h5>
                <button type="button" class="close" data-dismiss="modal"><span>×</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Score Guide</h6>
                <p class="tip-score-guide"></p><br>
                <h6>Suggestion</h6>
                <p class="tip-suggestion"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- tips -->

<!-- Required vendors -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/app/l_common.js"></script> -->
<script src="<?php echo base_url() ?>assets/js/app/l_sst.js"></script>
<script>

<?php if($this->session->userdata('redo')){ ?>
    let _set_redo = true;
<?php } else { ?>
    let _set_redo = false;
<?php } ?>

var min = 0;
var sec = 0;

window.onload = function() {
    <?php
            if(isset($getQuestionData) && strlen($getQuestionData[0]->exam_duration) > 0){ 
                $time = explode(":", $getQuestionData[0]->exam_duration);
                $min = $time[0];
                $sec = $time[1];
                ?>
    min = <?php echo $min; ?>;
    sec = <?php echo $sec; ?>;
    if(!_set_redo)
        prepareTimer(min, sec + 1, startTimer);
    <?php } ?>
};

var siteUrl = '<?php echo base_url(); ?>';

$('#previous').click(function() {
    location.href = '<?php echo base_url().'user/ssts/'.$prev_id; ?>';
});

$('#next').click(function() {
    location.href = '<?php echo base_url().'user/ssts/'.$next_id; ?>';
});

$('[name="redo"]').click(function(e){
    clearAllIntervals();
    document.getElementsByTagName('audio')[0].pause();
    document.getElementsByTagName('audio')[0].currentTime = 0;
    prepareTimer(min, sec + 1, startTimer);
});
</script>

<?php $this->session->unset_userdata('redo'); ?>