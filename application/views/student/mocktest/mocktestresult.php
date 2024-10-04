<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<style>
/* .chr {
    border-bottom: 1px solid #d3d3d3;
}

.chr:last-child {
    border-bottom: none;
} */

.goto-question {
    text-align: end;
    cursor: pointer;
}

.fa-angle-right {
    font-size: 18px;
}

.answer {
    background-color: #e7e7e7;
}

.card label {
    font-size: .8571em;
    margin-bottom: 5px;
    color: #9a9a9a;
}

.chart-container {
  position: relative;
  max-width: 800px;
  margin: auto;
}

.app-card > .card {
    position: relative;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 0.25rem;
}

.app-card > .card > .card-header:first-child {
    border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}
.app-card > .card > .card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: rgba(0,0,0,.03);
    border-bottom: 1px solid rgba(0,0,0,.125);
}
.app-card > .card > .card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.app-card > .card > .card-body {
    -webkit-box-flex: 1;
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.app-card > .card > .card-footer {
    padding: 0.75rem 1.25rem;
    background-color: rgba(0,0,0,.03);
    border-top: 1px solid rgba(0,0,0,.125);
}

.app-card > .card > .card-title {
    margin-bottom: 0.75rem;
}

.ro-draggable {
  border: 1px solid lightgray;
  padding: 1.5ch;
  background-color: #efefef;
  /* cursor: move; */
  display: flex;
}
.ro-draggable:not(:first-child) {
    margin-top: 1.5ch;
}

.check-state-correct {
    background-color: rgb(18, 211, 189);
}

.check-state-wrong {
    background-color: rgb(255, 102, 102);
}
</style>

<input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"> 
<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="section-header">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title">Score Report </h2>
                </div>
            </div>
        </div>
    </div>
</section>
        <!-- <div class="row d-flex justify-content-center align-items-center h-100" style="height:unset !important">
                        <div class="col-lg-8 col-xl-12"> -->

    <section class="mt-35">
        <div class="panel-section-card py-20 px-25 mt-20">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card">

                                <div class="card-body">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#score-report"> Score
                                                    Report</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div class="tab-pane fade show active" id="score-report">
                                                <div class="col-xl-6 col-lg-12 col-sm-12 mt-4">
                                                    <div class="chart-container bar-line">
                                                        <canvas id="horizontalBarChartCanvas"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"><?php echo $getMockTest[0]->title; ?> - Answer and Score Info
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <!-- Nav tabs -->
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs" role="tablist">

                                            <?php if (isset($speaking)) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo $active_tab == 'speaking' ? 'active' : ''; ?>"
                                                        data-toggle="tab" href="#speaking"> Speaking</a>
                                                </li>
                                            <?php } ?>

                                            <?php if (isset($writing)) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo $active_tab == 'writing' ? 'active' : ''; ?>"
                                                        data-toggle="tab" href="#writing"> Writing</a>
                                                </li>
                                            <?php } ?>

                                            <?php if (isset($reading)) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo $active_tab == 'reading' ? 'active' : ''; ?>"
                                                        data-toggle="tab" href="#reading"> Reading</a>
                                                </li>
                                            <?php } ?>

                                            <?php if (isset($listening)) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link <?php echo $active_tab == 'listening' ? 'active' : ''; ?>"
                                                        data-toggle="tab" href="#listening"> Listening</a>
                                                </li>
                                            <?php } ?>

                                        </ul>


                                        <div class="tab-content">

                                            <!-- speaking -->

                                            <?php if (isset($speaking)) { ?>
                                                <div class="tab-pane fade <?php echo $active_tab == 'speaking' ? 'show active' : ''; ?>"
                                                    id="speaking">
                                                    <div class="pt-4">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getMockTestAnswers as $row => $response) {
                                                            foreach ($speaking as $skey => $rowspeaking) {
                                                                if ($response->question_id == $rowspeaking->id) {
                                                                    switch ($response->question_type) {
                                                                        case 'read_alouds': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowspeaking->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Your Answer</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $response->answer ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php if($response->answer_id){ ?>
                                                                                                <div class="card-footer">
                                                                                                    <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                        <?php case 'repeat_sentences': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowspeaking->resourcePath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Transcript</h5>
                                                                                                <div class="card-body">
                                                                                                    <p class="card-text"><?php echo strip_tags($rowspeaking->transcript); ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                        <audio src="<?php echo base_url() . $response->answer ?>" controls></audio>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                        <?php case 'describe_images': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <img src="<?php echo base_url() . $rowspeaking->resourcePath; ?>" style="max-height:320px;">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Sample Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <p class="card-text"><?php echo strip_tags($rowspeaking->answer); ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                        <audio src="<?php echo base_url() . $response->answer ?>" controls></audio>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                        <?php case 'retell_lectures': ?>

                                                                        <div class="chr pb-4 pt-4">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                    <h6>Ques No.
                                                                                        <?php echo $i + 1; ?>
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                    <div class="card mt-2">
                                                                                        <h5 class="card-header">Question</h5>
                                                                                        <div class="card-body">
                                                                                            <div
                                                                                                style="display:flex;align-items:center;justify-content:center;">
                                                                                                <audio
                                                                                                    src="<?php echo base_url() . $rowspeaking->resourcePath; ?>"
                                                                                                    controls></audio>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="display:flex; width:100%;">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text">
                                                                                                    <?php echo strip_tags($rowspeaking->transcript); ?>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Your Answer</h5>
                                                                                            <div class="card-body" style="display: grid;">
                                                                                                <div
                                                                                                    style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio
                                                                                                        src="<?php echo base_url() . $response->answer ?>"
                                                                                                        controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php if ($response->answer_id) { ?>
                                                                                                <div class="card-footer">
                                                                                                    <button class="btn btn-sm btn-secondary"
                                                                                                        style="float:right;"
                                                                                                        onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <?php break; ?>
                                                                    <?php case 'respond_situation': ?>

                                                                        <div class="chr pb-4 pt-4">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                    <h6>Ques No.
                                                                                        <?php echo $i + 1; ?>
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                    <div class="card mt-2">
                                                                                        <h5 class="card-header">Question</h5>
                                                                                        <div class="card-body">
                                                                                            <div
                                                                                                style="display:flex;align-items:center;justify-content:center;">
                                                                                                <audio
                                                                                                    src="<?php echo base_url() . $rowspeaking->resourcePath; ?>"
                                                                                                    controls></audio>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="display:flex; width:100%;">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text">
                                                                                                    <?php echo strip_tags($rowspeaking->transcript); ?>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Your Answer</h5>
                                                                                            <div class="card-body" style="display: grid;">
                                                                                                <div
                                                                                                    style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio
                                                                                                        src="<?php echo base_url() . $response->answer ?>"
                                                                                                        controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                            <?php if ($response->answer_id) { ?>
                                                                                                <div class="card-footer">
                                                                                                    <button class="btn btn-sm btn-secondary"
                                                                                                        style="float:right;"
                                                                                                        onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                            <?php break; ?>

                                                                        <?php case 'answer_questions': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowspeaking->resourcePath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowspeaking->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Sample Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <p class="card-text"><?php echo strip_tags($rowspeaking->answer); ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                        <audio src="<?php echo base_url() . $response->answer ?>" controls></audio>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('speaking',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                    <?php }
                                                                    $i++;
                                                                }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                            <!-- writing -->

                                            <?php if (isset($writing)) { ?>
                                                <div class="tab-pane fade <?php echo $active_tab == 'writing' ? 'show active' : ''; ?>"
                                                    id="writing" role="tabpanel">
                                                    <div class="pt-4">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getMockTestAnswers as $row => $response) {
                                                            foreach ($writing as $wkey => $rowwriting) {
                                                                if ($response->question_id == $rowwriting->id) {
                                                                    switch ($response->question_type) {
                                                                        case 'swtx': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowwriting->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <?php if (strlen($rowwriting->answer) > 0) { ?>
                                                                                            <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                                <div class="card" style="height:100%;">
                                                                                                    <h5 class="card-header">Sample Answer</h5>
                                                                                                    <div class="card-body">
                                                                                                        <p class="card-text"><?php echo strip_tags($rowwriting->answer); ?></p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>

                                                                                        <div class="<?php echo strlen($rowwriting->answer) > 0 ? 'col-lg-6 col-md-6 col-sm-6' : 'col-lg-12 col-md-12 col-sm-12'; ?> app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text"><?php echo strip_tags($response->answer); ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('writing',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                        <?php case 'essays': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowwriting->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <?php if (strlen($rowwriting->answer) > 0) { ?>
                                                                                            <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                                <div class="card" style="height:100%;">
                                                                                                    <h5 class="card-header">Sample Answer</h5>
                                                                                                    <div class="card-body">
                                                                                                        <p class="card-text"><?php echo strip_tags($rowwriting->answer); ?></p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>

                                                                                        <div class="<?php echo strlen($rowwriting->answer) > 0 ? 'col-lg-6 col-md-6 col-sm-6' : 'col-lg-12 col-md-12 col-sm-12'; ?> app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text"><?php echo strip_tags($response->answer); ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('writing',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        <?php break; ?>
                                                                    <?php case 'email': ?>

                                                                        <div class="chr pb-4 pt-4">
                                                                            <div class="row">
                                                                                <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                    <h6>Ques No.
                                                                                        <?php echo $i + 1; ?>
                                                                                    </h6>
                                                                                </div>
                                                                                <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                    <div class="card mt-2">
                                                                                        <h5 class="card-header">Question</h5>
                                                                                        <div class="card-body">
                                                                                            <p class="card-text">
                                                                                                <?php echo strip_tags($rowwriting->question); ?>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div style="display:flex; width:100%;">
                                                                                    <?php if (strlen($rowwriting->answer) > 0) { ?>
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Sample Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <p class="card-text">
                                                                                                        <?php echo strip_tags($rowwriting->answer); ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php } ?>

                                                                                    <div
                                                                                        class="<?php echo strlen($rowwriting->answer) > 0 ? 'col-lg-6 col-md-6 col-sm-6' : 'col-lg-12 col-md-12 col-sm-12'; ?> app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Your Answer</h5>
                                                                                            <div class="card-body" style="display: grid;">
                                                                                                <p class="card-text">
                                                                                                    <?php echo strip_tags($response->answer); ?>
                                                                                                </p>
                                                                                            </div>
                                                                                            <?php if ($response->answer_id) { ?>
                                                                                                <div class="card-footer">
                                                                                                    <button class="btn btn-sm btn-secondary"
                                                                                                        style="float:right;"
                                                                                                        onclick="viewscore('writing',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                </div>
                                                                                            <?php } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            </div>
    
                                                                            <?php break; ?>
    
    
                                                                    <?php }
                                                                    $i++;
                                                                }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>



                                            <!-- reading -->

                                            <?php if (isset($reading)) { ?>
                                                <div class="tab-pane fade <?php echo $active_tab == 'reading' ? 'show active' : ''; ?>"
                                                    id="reading" role="tabpanel">
                                                    <div class="pt-4">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getMockTestAnswers as $row => $response) {
                                                            foreach ($reading as $wkey => $rowreading) {
                                                                if ($response->question_id == $rowreading->id) {
                                                                    switch ($response->question_type) {

                                                                        case 'fib_wr': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Question</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text">
                                                                                                        <?php echo preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $rowreading->question); ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                        $userAnswerArr = array();
                                                                                                        $userResponse = json_decode($response->answer);
                                                                                                        foreach ($userResponse as $key => $user_answer) {
                                                                                                            if (strlen($user_answer) <= 0) {
                                                                                                                $userAnswerArr[] = '___BLANK SKIPPED___';
                                                                                                            } else {
                                                                                                                $userAnswerArr[] = $user_answer;
                                                                                                            }
                                                                                                        }

                                                                                                        $actual_answer = json_decode($rowreading->answer);
                                                                                                        $student_answer = $userAnswerArr;
                                                                                                        
                                                                                                        $mistakes = [];
                                                                                                        foreach ($actual_answer as $key => $row) {
                                                                                                            if (trim($actual_answer[$key]) == trim($student_answer[$key])) {
                                                                                                                array_push($mistakes, '<span style="background-color: green;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }else{
                                                                                                                array_push($mistakes, '<span style="background-color: red;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }
                                                                                                        }

                                                                                                        preg_match_all('/{(.*?)}/', $rowreading->question, $replacing_words);
                                                                                                        $replacing_words = $replacing_words[1];
                                                                                                        $answer_string = $rowreading->question;

                                                                                                        $_i = 0;
                                                                                                        foreach ($mistakes as $key => $mistake) {
                                                                                                            $answer_string = str_replace('{' . $replacing_words[$_i] . '}', $mistake, $answer_string);
                                                                                                            $_i++;
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="card-text"><?php echo $answer_string; ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('reading',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'fib_rd': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Question</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text">
                                                                                                        <?php echo preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $rowreading->question); ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                        $userAnswerArr = array();
                                                                                                        $userResponse = json_decode($response->answer);
                                                                                                        foreach ($userResponse as $key => $user_answer) {
                                                                                                            if (strlen($user_answer) <= 0) {
                                                                                                                $userAnswerArr[] = '___BLANK SKIPPED___';
                                                                                                            } else {
                                                                                                                $userAnswerArr[] = $user_answer;
                                                                                                            }
                                                                                                        }

                                                                                                        $actual_answer = json_decode($rowreading->answer);
                                                                                                        $student_answer = $userAnswerArr;
                                                                                                        
                                                                                                        $mistakes = [];
                                                                                                        foreach ($actual_answer as $key => $row) {
                                                                                                            if (trim($actual_answer[$key]) == trim($student_answer[$key])) {
                                                                                                                array_push($mistakes, '<span style="background-color: green;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }else{
                                                                                                                array_push($mistakes, '<span style="background-color: red;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }
                                                                                                        }

                                                                                                        preg_match_all('/{(.*?)}/', $rowreading->question, $replacing_words);
                                                                                                        $replacing_words = $replacing_words[1];
                                                                                                        $answer_string = $rowreading->question;

                                                                                                        $_i = 0;
                                                                                                        foreach ($mistakes as $key => $mistake) {
                                                                                                            $answer_string = str_replace('{' . $replacing_words[$_i] . '}', $mistake, $answer_string);
                                                                                                            $_i++;
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="card-text"><?php echo $answer_string; ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('reading',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'r_mcm': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo $rowreading->question; ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowreading->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowreading->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('reading',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'r_mcs': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo $rowreading->question; ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowreading->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowreading->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('reading',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                        <?php case 'ro': ?>


                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <?php 
                                                                                                    $paragraphs = json_decode($rowreading->options);
                                                                                                    $paragraph_arr = [];
                                                                                                    foreach ($paragraphs as $pkey => $paragraph) {
                                                                                                        $paragraph_arr[$pkey+ 1] = '<div class="ro-draggable" data-order="'.($pkey+1).'"><span style="margin-right: 5px;">'.($pkey+1) .') </span><span>'.$paragraph.'</span></div>';
                                                                                                        echo $paragraph_arr[$pkey+ 1];
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Answer</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                        $answer = array();
                                                                                                        $answer_order = json_decode($rowreading->answer);
                                                                                                        foreach ($answer_order as $row) {
                                                                                                            echo $paragraph_arr[$row];
                                                                                                        }
                                                                                                    ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                        $answer = array();
                                                                                                        $answer_order = json_decode($response->answer);
                                                                                                        foreach ($answer_order as $row) {
                                                                                                            echo $paragraph_arr[$row];
                                                                                                        }
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('reading',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                    <?php }
                                                                    $i++;
                                                                }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>



                                            <!-- listening -->

                                            <?php if (isset($listening)) { ?>
                                                <div class="tab-pane fade <?php echo $active_tab == 'listening' ? 'show active' : ''; ?>"
                                                    id="listening" role="tabpanel">
                                                    <div class="pt-4">
                                                        <?php
                                                        $i = 0;
                                                        foreach ($getMockTestAnswers as $row => $response) {
                                                            foreach ($listening as $wkey => $rowlistening) {
                                                                if ($response->question_id == $rowlistening->id) {
                                                                    switch ($response->question_type) {

                                                                        case 'ssts': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <?php if (strlen($rowlistening->answer) > 0) { ?>
                                                                                            <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                                <div class="card" style="height:100%;">
                                                                                                    <h5 class="card-header">Sample Answer</h5>
                                                                                                    <div class="card-body">
                                                                                                        <p class="card-text"><?php echo strip_tags($rowlistening->answer); ?></p>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php } ?>

                                                                                        <div class="<?php echo strlen($rowlistening->answer) > 0 ? 'col-lg-6 col-md-6 col-sm-6' : 'col-lg-12 col-md-12 col-sm-12'; ?> app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text"><?php echo strip_tags($response->answer); ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'l_fib': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Question</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text">
                                                                                                        <?php echo preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $rowlistening->question); ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                        $userAnswerArr = array();
                                                                                                        $userResponse = json_decode($response->answer);
                                                                                                        foreach ($userResponse as $key => $user_answer) {
                                                                                                            if (strlen($user_answer) <= 0) {
                                                                                                                $userAnswerArr[] = '_';
                                                                                                            } else {
                                                                                                                $userAnswerArr[] = $user_answer;
                                                                                                            }
                                                                                                        }

                                                                                                        $actual_answer = json_decode($rowlistening->answer);
                                                                                                        $student_answer = $userAnswerArr;
                                                                                                        
                                                                                                        $mistakes = [];
                                                                                                        foreach ($actual_answer as $key => $row) {
                                                                                                            if (trim($actual_answer[$key]) == trim($student_answer[$key])) {
                                                                                                                array_push($mistakes, '<span style="background-color: green;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }else{
                                                                                                                array_push($mistakes, '<span style="background-color: red;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $student_answer[$key] . '</span>');
                                                                                                            }
                                                                                                        }

                                                                                                        preg_match_all('/{(.*?)}/', $rowlistening->question, $replacing_words);
                                                                                                        $replacing_words = $replacing_words[1];
                                                                                                        $answer_string = $rowlistening->question;

                                                                                                        $_i = 0;
                                                                                                        foreach ($mistakes as $key => $mistake) {
                                                                                                            $answer_string = str_replace('{' . $replacing_words[$_i] . '}', $mistake, $answer_string);
                                                                                                            $_i++;
                                                                                                        }
                                                                                                    ?>
                                                                                                    <p class="card-text"><?php echo $answer_string; ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'l_mcm': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Choices</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowlistening->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowlistening->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'l_mcs': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Choices</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowlistening->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowlistening->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <?php break; ?>



                                                                        <?php case 'l_hcs': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Choices</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowlistening->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowlistening->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>



                                                                        <?php case 'l_smw': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo strip_tags($rowlistening->question); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Choices</h5>
                                                                                                <div class="card-body">
                                                                                                    <?php
                                                                                                    $options = json_decode($rowlistening->options);

                                                                                                    $answer = array();
                                                                                                    $original_answer = json_decode($rowlistening->answer);
                                                                                                    $givenanswer = json_decode($response->answer);
                                                                                                    foreach($original_answer as $key => $rowresponse){
                                                                                                        if($rowresponse == '1'){
                                                                                                            array_push($answer,chr($key + 65));
                                                                                                        }
                                                                                                    }

                                                                                                    foreach ($options as $key => $row) {
                                                                                                        $option = chr($key + 65) . ") " . $row;
                                                                                                        $correct_class = "";
                                                                                                        if(in_array(chr($key + 65), $answer) == true){
                                                                                                            $correct_class = "check-state-correct";
                                                                                                        }
                                                                                                        ?>
                                                                                                        <p class="card-text <?php echo $correct_class; ?> m-1"><?php echo $option; ?></p>
                                                                                                    <?php } ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                    $i = 0;
                                                                                                        foreach ($givenanswer as $key => $row) {
                                                                                                            $option = chr($i + 65) . ") " . $options[$i];
                                                                                                            if($row == 1 && $original_answer[$i] == 1){
                                                                                                                echo '<p class="card-text m-1 check-state-correct">'.$option.'</p>';
                                                                                                            }elseif($row == 1 && $original_answer[$i] == 0){
                                                                                                                echo '<p class="card-text m-1 check-state-wrong">'.$option.'</p>';
                                                                                                            }else{
                                                                                                                echo '<p class="card-text m-1">'.$option.'</p>';
                                                                                                            }
                                                                                                        $i++;}
                                                                                                    ?>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'hiws': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Audio</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Transcript</h5>
                                                                                            <div class="card-body">
                                                                                                <p class="card-text"><?php echo preg_replace('/{([^}]+)}/', '$1', $rowlistening->transcript); ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card mt-2">
                                                                                        <div class="card" style="height:100%;">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body" style="display: grid;">
                                                                                                <p class="card-text">
                                                                                                    <?php echo preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $rowlistening->question); ?>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text">
                                                                                                        <?php echo preg_replace('/{([^}]+)}/', '<span style="background-color: var(--primary);color:#fff;border-radius: 25px;padding: 1px 8px;">$1</span>', $rowlistening->transcript); ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <?php
                                                                                                        $userAnswerArr = json_decode($response->answer);
                                                                                                        $userAnswerArr = array_map(function ($string) { return preg_replace('/\p{P}/', '', $string); }, $userAnswerArr);
                                                                                                        
                                                                                                        $actual_answer = json_decode($rowlistening->answer,true);
                                                                                                        $incorrectWordsArr = array_diff($userAnswerArr,array_keys($actual_answer));
                                                                                                        
                                                                                                        $answer_string = $rowlistening->question;
                                                                                                        // $answer_string = preg_replace('/{([^}]+)}/', '$1', $answer_string);
                                                                                                        foreach ($userAnswerArr as $key => $row) {
                                                                                                            if (in_array($row, array_keys($actual_answer))) {
                                                                                                                $mistake = '<span style="background-color: green;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $userAnswerArr[$key] . '</span>';
                                                                                                                $answer_string = str_replace($userAnswerArr[$key], $mistake, $answer_string);
                                                                                                            }else{
                                                                                                                $mistake = '<span style="background-color: red;color:#fff;border-radius: 25px;padding: 1px 8px;">' . $userAnswerArr[$key] . '</span>';
                                                                                                                $answer_string = str_replace($userAnswerArr[$key], $mistake, $answer_string);
                                                                                                            }
                                                                                                        }
                                                                                                        $answer_string = preg_replace('/{([^}]+)}/', '$1', $answer_string);
                                                                                                    ?>
                                                                                                    <p class="card-text"><?php echo $answer_string; ?></p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>


                                                                        <?php case 'wfds': ?>

                                                                            <div class="chr pb-4 pt-4">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12"><h6>Ques No. <?php echo $i + 1; ?></h6></div>
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 app-card">
                                                                                        <div class="card mt-2">
                                                                                            <h5 class="card-header">Question</h5>
                                                                                            <div class="card-body">
                                                                                                <div style="display:flex;align-items:center;justify-content:center;">
                                                                                                    <audio src="<?php echo base_url() . $rowlistening->audioPath; ?>" controls></audio>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="display:flex; width:100%;">
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card">
                                                                                            <div class="card mt-2">
                                                                                                <h5 class="card-header">Transcript</h5>
                                                                                                <div class="card-body">
                                                                                                    <p class="card-text"><?php echo strip_tags($rowlistening->transcript); ?></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-lg-6 col-md-6 col-sm-6 app-card mt-2">
                                                                                            <div class="card" style="height:100%;">
                                                                                                <h5 class="card-header">Your Answer</h5>
                                                                                                <div class="card-body" style="display: grid;">
                                                                                                    <p class="card-text">
                                                                                                    <?php 
                                                                                                        $actual_answer = explode(' ',strtolower(trim(preg_replace('/\p{P}/', '',$rowlistening->transcript))));
                                                                                                        $userAnswer = preg_replace('/\p{P}/', '',strtolower(strip_tags($response->answer)));
                                                                                                        $userAnswerArr = explode(' ',$userAnswer);
                                                                                            
                                                                                                        echo get_wfd_mistakes($actual_answer, $userAnswerArr);
                                                                                                    ?>
                                                                                                    </p>
                                                                                                </div>
                                                                                                <?php if($response->answer_id){ ?>
                                                                                                    <div class="card-footer">
                                                                                                        <button class="btn btn-sm btn-secondary" style="float:right;" onclick="viewscore('listening',<?php echo $response->answer_id; ?>);">Score</button>
                                                                                                    </div>
                                                                                                <?php } ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <?php break; ?>

                                                                    <?php }
                                                                    $i++;
                                                                }
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="score-model"></div>
<script src="<?php echo base_url() ?>assets/newlayout/assets/admin/vendor/jquery/jquery-3.3.1.min.js"></script>
<script src="<?php echo base_url() ?>assets/newlayout/assets/default/vendors/chartjs/chart.min.js"></script>
<script>
    const siteUrl = '<?php echo base_url(); ?>';
    const verticalLine = {
        renderVerticalLine: function(chartInstance, pointIndex) {
            const xaxis = chartInstance.scales["x-axis-0"];
            const yaxis = chartInstance.scales["y-axis-0"];
            const context = chartInstance.chart.ctx;

            // render vertical line
            context.beginPath();

            context.strokeStyle = "#DA1726";

            context.moveTo(xaxis.getPixelForValue(pointIndex), yaxis.top);
            context.lineTo(xaxis.getPixelForValue(pointIndex), yaxis.bottom);
            context.lineWidth = 3;
            context.stroke();

            context.textAlign = "start";
            context.fillText("<?php echo $overall_score; ?> Overall",xaxis.getPixelForValue(pointIndex) + 10, 10);

        },

        afterDatasetsDraw: function(chart, easing) {
            if (chart.config.lineAtIndex) {
                var index = [];
                index = chart.config.lineAtIndex;
                for (i = 0; i < index.length; i++) {
                this.renderVerticalLine(chart, index[i]);
                }
            }
        }
    };

    Chart.plugins.register(verticalLine);

    var horizontalBarChart = new Chart(horizontalBarChartCanvas, {
        type: 'horizontalBar',
        data: {
            labels: <?php echo json_encode($chart_label); ?>,
            datasets: [{
                data: <?php echo json_encode($chart_dataset); ?>,
                backgroundColor: <?php echo json_encode($chart_bgcolor); ?>, 
            }]
        },
        options: {
            tooltips: {
                enabled: true
            },
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    gridLines: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        fontColor: '#555759',
                        fontSize: 14,
                        fontStyle: "bold",
                    },
                }],
                xAxes: [{
                    gridLines: {
                        drawOnChartArea: false
                    },
                    ticks: {
                        beginAtZero: true,
                        display:false, 
                        min: 0,
                        max: <?php echo json_encode($max_bar_length); ?>,
                        stepSize: 10,                 
                    },
                }]
            }
        },
        lineAtIndex: [10]
    });

    function viewscore(model, answer){
        var csrfName = $('.csrfToken').attr('name'); 
        var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: siteUrl+"user/getscorebyanswer",    
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,         
                data: {answer:answer,[csrfName]:csrfHash,model:model},
                success: function(data) {
                    console.log(data)
                    data = JSON.parse(JSON.stringify(data));
                    $('.csrfToken').val(data.token); 
                    $('#score-model').html(data.result); 
                    $('#resultModal').modal('show');
                    $('#resultModal').modal('show');
                    $('[data-toggle="popover"]').popover()
                },
                error: function(data) {
                    console.log('failed to fetch score')
                }

            })
    }
</script>

