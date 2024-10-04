<title>PTE Listening Mock Test with Answers | A One Australia</title>
<meta name="keywords" content="pte listening mock test, pte listening mock test with answers">
<meta name="description" content="Enhance your PTE preparation with our PTE Listening Mock Test with Answers. Practice and excel in the PTE Listening mock test section with confidence">
<style>
.imp {
    color: red;
}

.info {
    cursor: pointer;
}

.highlight {
    background-color: var(--primary);
    color: #ffffff;
}

#question span {
    font-size: 18px;
    display: inline-block;
    margin-right: 5px;
    line-height: 40px;
    user-select: none;
    cursor: pointer;
}

.noselect {
    -webkit-touch-callout: none;
    /* iOS Safari */
    -webkit-user-select: none;
    /* Safari */
    -khtml-user-select: none;
    /* Konqueror HTML */
    -moz-user-select: none;
    /* Old versions of Firefox */
    -ms-user-select: none;
    /* Internet Explorer/Edge */
    user-select: none;
    /* Non-prefixed version, currently supported by Chrome, Edge, Opera and Firefox */
}

.audio {
    width: 100%;
    outline: none;
    border: 1px solid #e9e9e9;
    border-top: none;
    background: #F1F3F4;
}

.answer-show.answer-state {
    display: inline-block;
    padding: 0px 16px;
    line-height: 32px !important;
    border: 1px solid;
    border-radius: 4px;
}

.answer-show span {
    line-height: 30px !important;
}

.answer-state-wrong-marker {
    margin-right: 14px;
}

.answer-state-correct-marker {
    margin-right: 14px;
}

.answer-state-missing {
    border-color: rgb(204, 204, 204);
    color: rgb(204, 204, 204);
}

.answer-state-correct {
    border-color: rgb(18, 211, 191);
    color: rgb(18, 211, 191);
    background-color: rgb(240, 255, 251);
}

.answer-state-wrong {
    border-color: rgb(255, 102, 102);
    color: rgb(255, 102, 102);
    background-color: rgb(255, 220, 220);
}

.answer-span {
    font-size: 18px;
    color: rgb(255, 204, 102);
    display: inline-block;
    margin-right: 5px;
    line-height: 40px;
}

/* .answer-span{
    color: rgb(18, 211, 191);
}

.answer-match{
    border: 1px solid rgb(18, 211, 191);
}

.answer-mismatch{
    border: 1px solid rgb(255, 102, 102);
} */
</style>

<section>
    <div class="panel-section-card py-20 px-10 mt-20">
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




                        <h2 class="section-title mb-3">Highlight Incorrect Words</h2>
                        <span class="paragraph">You will hear a recording. Below is a transcription of the
                            recording. Some words in the transcription differ from what the speaker said. Please
                            click on the words that are different.</span><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-35">
    <div class="panel-section-card py-20 px-10 mt-20">
        <form id="hiws" class="mb-5"
            action="<?php echo base_url();?>user/hiws/<?php if(isset($getQuestionData) && strlen($getQuestionData[0]->id) > 0){ echo $getQuestionData[0]->id;} ?>"
            method="POST" enctype="multipart/form-data">
            <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"value="<?php echo $this->security->get_csrf_hash(); ?>">
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

                            <div class="row mb-2">
                                <div class="col-12 noselect">
                                        <p id="question">
                                            <?php if(isset($getQuestionData) && strlen($getQuestionData[0]->question) > 0){echo str_replace(array("{", "}"), "", $getQuestionData[0]->question);} ?>
                                        </p>
                                    
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6 quebuttons">
                                    <input type="hidden" name="selections" />
                                    <input type="hidden" name="formHTML" />
                                    <input type="submit" class="btn btn-primary" id="submit" name="submit"
                                        value="Submit" />
                                
                                    <input type="button" class="btn btn-primary" id="redo" name="redo"
                                        data-id="<?php echo $getQuestionData[0]->id; ?>" value="Redo" />

                                    <label class="answer-toggle ml-1 align-middle">
                                    <?php $checked = $this->session->userdata('previous_response') ? "checked" : ""; ?>
                                        <input type="checkbox" id="toggle-answer" <?php echo $checked; ?>/>
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
                                <th>Suggestion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Blanks <i aria-label="icon: info-circle" tabindex="-1"
                                        class="anticon info"
                                        onclick="toogleTips();"><svg viewBox="64 64 896 896" class=""
                                            data-icon="info-circle" width="1em" height="1em" fill="currentColor"
                                            aria-hidden="true" focusable="false">
                                            <path
                                                d="M512 64C264.6 64 64 264.6 64 512s200.6 448 448 448 448-200.6 448-448S759.4 64 512 64zm0 820c-205.4 0-372-166.6-372-372s166.6-372 372-372 372 166.6 372 372-166.6 372-372 372z">
                                            </path>
                                            <path
                                                d="M464 336a48 48 0 1 0 96 0 48 48 0 1 0-96 0zm72 112h-48c-4.4 0-8 3.6-8 8v272c0 4.4 3.6 8 8 8h48c4.4 0 8-3.6 8-8V456c0-4.4-3.6-8-8-8z">
                                            </path>
                                        </svg></i></td>
                                <td><span class="myScore"></span><?php echo '/'.$maxScore; ?></td>
                                <td><span class="suggestion"></span></td>
                            </tr>
                            <tr>
                                <td colspan="3">Max Score：<?php echo $maxScore; ?>, Your Score：<span
                                        class="myScore"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-2" style="color:black;">
                    <span>Your answer: </span><span class="student-response"></span>
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
                <p>You will get 1 mark for each correct word chosen, and lose 1 mark for each wrong word chosen. The
                    minimum score of each question is 0.</p><br>
                <h6>Suggestion</h6>
                <p>HIW is a very easy question in listening. Make sure you get full marks!</p>
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
<script src="<?php echo base_url() ?>assets/js/app/l_common.js"></script>
<script src="<?php echo base_url() ?>assets/js/app/l_hiws.js"></script>
<script>
<?php if($this->session->userdata('previous_response')){ ?>
    let _showing_previous_answer = true;
    let _previous_answer = JSON.parse(JSON.stringify(<?php echo $this->session->userdata('previous_response'); ?>));
<?php } else { ?>
    let _showing_previous_answer = false;
    let _previous_answer = "";
<?php } ?>

window.addEventListener('load', function() {
    document.getElementById("hiws").reset();
    $("#submit").prop('disabled', true);
})

function checkResults(id, answer) {
    var csrfName = $('.csrfToken').attr('name'); 
    var csrfHash = $('.csrfToken').val(); // CSRF hash
    $.ajax({
        url: siteUrl+"user/getuseranswer",    
        type: "POST",
        crossDomain: true,
        dataType: 'json',
        cache: false,         
        data: {answer:answer,[csrfName]:csrfHash,model:'listening'},
        success: function(data) {
            data = JSON.parse(JSON.stringify(data));
            $('.csrfToken').val(data['token']); 
            $('.myScore').text(data['result']['score']);
            $('.suggestion').text(data['result']['suggestion']);
            $('.student-response').html(data['result']['mistakes']);
            $('#resultModal').modal('show');
        },
        error: function(data){
            console.log('Failed to fetch answer');
        }
    })
}

function toogleTips() {
    $('#tipsModel').modal('show');
}

let obj = <?php echo $getQuestionData[0]->answer; ?>;
const wrongwords = Object.keys(obj);
const answer = Object.values(obj);

$('#previous').click(function() {
    location.href = '<?php echo base_url().'user/hiws/'.$prev_id; ?>';
});

$('#next').click(function() {
    location.href = '<?php echo base_url().'user/hiws/'.$next_id; ?>';
});

$(document).ready(function(e){
    if(_showing_previous_answer){
        setPreviousFormData();
    }
});
</script>

<?php $this->session->unset_userdata('previous_response'); ?>