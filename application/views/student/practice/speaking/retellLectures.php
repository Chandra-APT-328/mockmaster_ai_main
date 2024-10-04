<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://www.webrtc-experiment.com/DetectRTC.js"> </script>
<script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>

<style>
.imp {
    color: red;
}

.error-container {
    background-color: rgb(255 102 102);
    height: 100px;
    display: flex;
    flex-direction: column;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    color: rgb(255, 255, 255);
}

.audio-container {
    background-color: rgb(241, 243, 244);
    height: 100px;
    display: flex;
    flex-direction: column;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
}

.audioMic {
    font-size: 36px;
    cursor: pointer;
    color: green;
}

.audio-container a {
    color: green;
    background-color: white;
    padding: 14px;
    border-radius: 50px;
    border: none;
    display: flex;
    flex-direction: column;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
}

.audio-container a:hover {
    border: 1px solid #c9c9c9;
}

.audio {
    width: 100%;
    outline: none;
    border: 1px solid #e9e9e9;
    border-top: none;
    background: #F1F3F4;
}

.answer-box {
    margin-top: 10px;
    user-select: none;
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
</style>


<section>
    <div class="panel-section-card py-20 px-20 mt-20">
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



                        <h2 class="section-title mb-3">Re-tell Lecture</h2>
                        <span class="paragraph">You will hear a lecture. After listening to the lecture, in 10
                            seconds, please speak into the microphone and retell what you have just heard from the
                            lecture in your own words. You will have 40 seconds to give your response.</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">
        <form class="mb-5" id="retell_lectures"
            action="<?php echo base_url();?>user/retell_lectures/<?php if(isset($getQuestionData) && strlen($getQuestionData[0]->id) > 0){ echo $getQuestionData[0]->id;} ?>"
            method="POST" enctype="multipart/form-data">
            <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="task_details" data-type="<?php echo $getQuestionData[0]->question_type; ?>" data-questionid="<?php echo $getQuestionData[0]->id; ?>">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-between px-10 align-items-center">
                                <div class="">
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
                                        controlsList="nodownload noplaybackrate" style="width:100%" ;
                                        onended="audioend()">
                                        <source
                                            src="<?php if(isset($getQuestionData[0]->resourcePath) && strlen($getQuestionData[0]->resourcePath) > 0){ echo base_url().$getQuestionData[0]->resourcePath;} ?>"
                                            type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12 recording-container">
                                    <div class="progress-bar" id="recording-progress" aria-valuenow="0"
                                        aria-valuemin="0" aria-valuemax="100" style="width:0%; height:4px;"
                                        role="progressbar"></div>
                                    <div class="error-container d-none">
                                        <span>Microphone permission is not granted.</span>
                                    </div>
                                    <div class="audio-container">
                                        <div><a href="javascript:void(0)" id="record"><i
                                                    class="fa fa-microphone audioMic"
                                                    aria-hidden="true"></i><span>Start</span></a></div>
                                    </div>
                                </div>
                                <div class="col-md-12 pt-3 d-none" id="user-speech"></div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 quebuttons">
                                    <input type="hidden" name="studentAnswer">
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
                                        data-id="<?php echo $prev_id; ?>"
                                        <?php if(!isset($prev_id)){echo 'disabled';} ?> />
                                    <input type="button" class="btn btn-success" id="next" value="Next"
                                        data-id="<?php echo $next_id; ?>"
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
                    <div id="transcript">
                        <?php echo strip_tags($getQuestionData[0]->transcript, '<p>'); ?>
                    </div>
                </div>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Component</th>
                                    <th>Score</th>
                                    <!-- <th>Suggestion</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                     <td>Content <i aria-label="icon: info-circle" tabindex="-1" class="anticon anticon-info-circle AIScoreCom__InfoIcon-sc-1yzm0aw-0 gXpbBC info" onclick="toogleTips('content');"><svg viewBox="64 64 896 896" class="" data-icon="info-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path><path d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z"></path></svg></i></td>
                                    <td><span class="content"></span><?php echo '/'.$maxScore; ?></td>
                                    <!-- <td><span class="suggestion"></span></td> -->
                                </tr>
                                <tr>
                                     <td>Pronunciation <i aria-label="icon: info-circle" tabindex="-1" class="anticon anticon-info-circle AIScoreCom__InfoIcon-sc-1yzm0aw-0 gXpbBC info" onclick="toogleTips('pronunciation');"><svg viewBox="64 64 896 896" class="" data-icon="info-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path><path d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z"></path></svg></i></td>
                                    <td><span class="pronunciation"></span><?php echo '/'.$maxScore; ?></td>
                                    <!-- <td><span class="suggestion"></span></td> -->
                                </tr>
                                <tr>
                                     <td>Fluency <i aria-label="icon: info-circle" tabindex="-1" class="anticon anticon-info-circle AIScoreCom__InfoIcon-sc-1yzm0aw-0 gXpbBC info" onclick="toogleTips('fluency');"><svg viewBox="64 64 896 896" class="" data-icon="info-circle" width="1em" height="1em" fill="currentColor" aria-hidden="true" focusable="false"><path d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z"></path><path d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z"></path></svg></i></td>
                                    <td><span class="fluency"></span><?php echo '/'.$maxScore; ?></td>
                                    <!-- <td><span class="suggestion"></span></td> -->
                                </tr>
                                <tr>
                                    <td colspan="3">Max Score：<?php echo $maxScore; ?>,  Your Score：<span class="myScore"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <p class="text-gray font-14">
                                            Note: Your scores have been computed using different parameters like your content accuracy, oral fluency, pronunciation and stress on words. These scores can be used for skill improvement, but they are not directly related to the PTE-Academic scores. The scores may differ with the usage of a proper headset with a mic compared to directly recording yourself on a laptop without using a headset.
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        &nbsp;<button class="btn" disabled style="height:19px; padding:0 15px; background-color:#22b922;"></button>&nbsp;Good
                        &nbsp;<button class="btn" disabled style="height:19px; padding:0 15px; background-color:#ffbf00;"></button>&nbsp;Average
                        &nbsp;<button class="btn" disabled style="height:19px; padding:0 15px; background-color:red;"></button>&nbsp;Bad/Pause
                    </div>
                    <div class="p-2" style="color:black;">
                        <span>Your answer: </span><span class="answer-transcript"></span>
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

<script>
const base_url = '<?php echo base_url('user/retell_lectures/'); ?>';

function checkResults(id, answer) {
    var csrfName = $('.csrfToken').attr('name'); 
    var csrfHash = $('.csrfToken').val(); // CSRF hash
    $.ajax({
        url: app_url + "user/getuseranswer",    
        type: "POST",
        crossDomain: true,
        dataType: 'json',
        cache: false,         
        data: {answer:answer,[csrfName]:csrfHash,model:'speaking'},
        success: function(data) {
            data = JSON.parse(JSON.stringify(data));
            $('.csrfToken').val(data['token']); 
            $('.myScore').text(data['result']['score']);
            $('.content').text(data['result']['component_score']['content']);
            $('.fluency').text(data['result']['component_score']['fluency']);
            $('.pronunciation').text(data['result']['component_score']['pronunciation']);
            $('.answer-transcript').html(data['result']['answer_transcript']);
            $('.suggestion').text(data['result']['suggestion']);
            $('#resultModal').modal('show');
        },
        error: function(data){
            console.log('Failed to fetch answer');
        }
    })
}
</script>

<!-- Required vendors -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/app/retell-lectures.js"></script>
<script src="<?php echo base_url() ?>assets/js/app/common.js"></script>
