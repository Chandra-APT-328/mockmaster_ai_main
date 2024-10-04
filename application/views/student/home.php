<head>
    <title>Best PTE Full Mock Test Practice With Answers | mockmaster.ai</title>
    <meta name="keywords" content="Pte Full Mock Test With Answers, best pte mock test, practice pte mock test">
    <meta name="title" content="Best PTE Full Mock Test Practice With Answers | mockmaster.ai">
    <meta name="description"
        content="Boost your PTE preparation with the best PTE Full Mock Test with answers. Practice PTE mock tests to enhance your skills and achieve success confidently.">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="<?php echo base_url(); ?>assets/css/user-dashboard.css" rel="stylesheet">
</head>

<section>
    <div class="row">
        <div class="col-md-12">
        <?php
            $exp_date = strtotime($this->session->userdata('validity'));
            $week_date = strtotime("-1 Week", $exp_date);
            $current_date = strtotime("today");
            ?>

            <?php if (($current_date >= $week_date) && ($current_date <= $exp_date)) { ?>
                <div class="warning" style="display:flex; align-items: center;    justify-content: space-between;">
                    <p>Your account access will expire by - <span class="warning-bold">
                            <?php echo $this->session->userdata('validity'); ?>
                    </span>. </p><a class="btn btn-sm btn-primary renew-btn"
                            href="<?php echo base_url() ?>user/package">Renew Now</a> 
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<section>

    <div class="row">
        <div class="col-xl-4 col-md-4">

        <div class="card mt-20">
							<div class="card-body p-2 ">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <?php if(in_array(get_user_device(), ["Mac OS X", "iOS"])){  ?>
                                            <a href="https://apps.apple.com/in/app/applykart/id1638867413" target="_blank">
                                                <img class="d-block w-100" src="<?php echo base_url() ?>assets/images/applykart_image.png" alt="First slide">
                                            </a>
                                            <?php } else {  ?>
                                                <a href="https://play.google.com/store/apps/details?id=com.applykart" target="_blank">
                                                <img class="d-block w-100" src="<?php echo base_url() ?>assets/images/applykart_image.png" alt="First slide">
                                            </a>
                                        <?php } ?>
                                    </div>



                                    <div class="carousel-item">
                                    <div class="d-block w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                            <img src="https://img.youtube.com/vi/UvcwdNAPhsU/hqdefault.jpg" alt="" style="width: 65%;">
                                        
                                        <div class="py-20">
                                            <div class="mb-2 mx-2 ">
                                                <h4>Upgrade To Our Video Course</h4>
                                                <a href="<?php echo base_url(); ?>user/package">  <button class="btn btn-primary predictionbtn my-1" style="height: 40px;font-size: 12px;margin-top: 20px !important;padding: 10px;">Register for English</button>
                                                </a>
                                                </a>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="carousel-item">
                                    <div class="d-block w-100">
                                    <div class="d-flex align-items-center justify-content-between">
                                            <img src="https://app.mockmaster.ai/uploads/materials/thumbnail/669a174811980.jpg" alt="" style="width: 65%;" >
                                        
                                        <div class="py-20">
                                            <div class="mb-2 mx-2 ">
                                                <h4>Upgrade To Our Video Course</h4>
                                                <a href="<?php echo base_url(); ?>user/package#PB">  <button class="btn btn-primary predictionbtn my-1" style="height: 40px;font-size: 12px;margin-top: 20px !important;padding: 10px;">Register for Punjabi</button>
                                                </a>
                                                </a>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                </div>
                            </div>
                        </div>
   
  

            <!-- Card -->
            <!-- <div class="card mt-20">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="" style="width: 65%;">
                            <img src="<?php echo base_url() ?>assets/images/videocourse.webp" alt="">
                        </div>
                        <div class="py-20">
                            <div class="mb-2 mx-2 ">
                                <h4>Upgrade To Our Video Course</h4>
                                <a href="<?php echo base_url(); ?>user/package">  <button class="btn btn-primary predictionbtn my-1" style="height: 30px; font-size: 12px;margin-top: 5px !important;padding: 12px;">Register for English</button>
                                </a>
                                <a href="<?php echo base_url(); ?>user/package#PB">  <button class="btn btn-primary predictionbtn" style="height: 30px; font-size: 12px;margin-top: 5px !important;padding: 12px;">Register for Punjabi</button>
                                </a>
                             </div>
                        </div>
                    </div>

                </div>
            </div> -->
            <!-- End Card -->
        </div>

        <div class="col-xl-8 col-md-8">
            <div class="panel-section-card py-20 px-25 mt-20">
                <!-- <span class="icon icon-xs-2 fa-solid fa-newspaper"></span> -->
                <div class="icon-group">
                    <a href="<?php echo base_url(); ?>mock/mocktestlist" class="stlink">
                        <div class="stfirstdiv">
                            <div class="stmocktest">
                                <h5>300+</h5>
                            </div>
                        </div>
                        <div class="name-group">
                            <span>Mock Tests Offered</span>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>public/study-materials/prediction.pdf"
                        class="stlink">
                        <div class="stsecdiv">
                            <div class="stimage-group" style="width: 50%;">
                                <img src="<?php echo base_url() ?>assets/images/predictionicon.png" width="100"
                                    height="100">
                            </div>
                        </div>
                        <div class="name-group">
                            <span>Prediction file for September 2024</span>
                        </div>
                    </a>

                    <a href="#featurevideos" class="stlink">
                        <div class="stthirddiv">
                            <div class="stimage-group" style="width: 65%;">
                                <img src="<?php echo base_url() ?>assets/images/videos.png" width="100" height="100">
                            </div>
                        </div>

                        <div class="name-group">
                            <span>Video Tutorials for Practice</span>
                        </div>
                    </a>

                    <a href="<?php echo base_url(); ?>mock/myattempts" class="stlink">
                        <div class="stfourthdiv">
                            <div class="stimage-group" style="width: 65%;">
                                <img src="<?php echo base_url() ?>assets/images/practice_mock_test.png" width="100"
                                    height="100">
                            </div>
                        </div>

                        <div class="name-group">
                            <span>My Practiced Mock Tests</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="mt-35">
    <div class="panel-section-card py-20 px-25 mt-20">

        <div class="row justify-content-between">
            <h3 class="section-title h3title">Score Target</h3>
            <span class="text-end target-box mr-20"><i class="fa fa-pencil"></i></span>
        </div>

        <div class="row mt-4 targetstats">
            <div class="col-md-3 col-6">
                <div class="stats">
                    <h3 class="readingstat" style="color: #FF0000;">
                        <?php echo strlen($target[0]->reading) > 0 ? $target[0]->reading : 0; ?>
                    </h3>


                    <hr class="readingstathr" style="border-top: 10px solid #FFC8C8;">
                    <p>Reading Questions</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stats">
                    <h3 class="listeningstat" style="color: #046FD2;">
                        <?php echo strlen($target[0]->listening) > 0 ? $target[0]->listening : 0; ?>
                    </h3>

                    <hr class="listeningstathr" style="border-top: 10px solid #BCDFFF;">
                    <p>Listening Questions</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stats">
                    <h3 class="speakingstat" style="color: #7567FF;">
                        <?php echo strlen($target[0]->speaking) > 0 ? $target[0]->speaking : 0; ?>
                    </h3>

                    <hr class="speakingstathr" style="border-top: 10px solid #CEBCFF;">
                    <p>Speaking Questions</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="stats">
                    <h3 class="writingstat" style="color: #1EC8DF;">
                        <?php echo strlen($target[0]->writing) > 0 ? $target[0]->writing : 0; ?>
                    </h3>

                    <hr class="writingstathr" style="border-top: 10px solid #ABFFE1;">
                    <p>Writing Questions</p>
                </div>
            </div>
        </div>



        <div class="row my-5">
            <div class="col-xl-3 mt-35" id="study-card">
                <div class="card progress_7 ">
                    <div class="card-body">
                        <div class="ProgressBar-wrap position-relative">
                            <div class="ProgressBar ProgressBar_7" data-progress=" <?php
												$future = strtotime($target[0]->exam_date); //Future date.
												$timefromdb = strtotime(date('Y-m-d'));
												$timeleft = $future-$timefromdb;
												$daysleft = round((($timeleft/24)/60)/60); 
												echo $daysleft > 0 ? $daysleft: 0;
											?>">
                                <svg class="ProgressBar-contentCircle" viewBox="0 0 200 200">
                                    <!-- on défini le l'angle et le centre de rotation du cercle -->
                                    <circle transform="rotate(135, 100, 100)" class="ProgressBar-background" cx="100"
                                        cy="100" r="8"></circle>
                                    <circle transform="rotate(135, 100, 100)" class="ProgressBar-circle" cx="100"
                                        cy="100" r="85" style="stroke-dasharray: 534px; stroke-dashoffset: 133.5px;">
                                    </circle>
                                </svg>

                                <span class="ProgressBar-percentage ProgressBar-percentage--count"> <?php
												$future = strtotime($target[0]->exam_date); //Future date.
												$timefromdb = strtotime(date('Y-m-d'));
												$timeleft = $future-$timefromdb;
												$daysleft = round((($timeleft/24)/60)/60); 
												echo $daysleft > 0 ? $daysleft: 0;
											?></span>
                                <span class="ProgressBar-percentage--text">
                                    Days <br> Left
                                </span>
                            </div>
                        </div>
                    </div>

                    <h6 class="examdate">Exam Date:
                        <?php echo strlen($target[0]->exam_date) > 0 ? $target[0]->exam_date : '____-__-__'; ?></h6>
                </div>
            </div>


            <div class="col-xl-3 mt-35">
                <button class="btn todaypractice" id="edit-target"> Today Practices </button>
                <button class="btn totalpractice" id="edit-target"> Total Practices </button>
                <button class="btn practicedays" id="edit-target"> Practice Days </button>
            </div>


            <div class="col-xl-6 mt-35">




                <div class="card">
                    <div class="">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="bar-chart" width="520" height="275"
                            style="display: block; width: 592px; height: 318px;"
                            class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="default-tab">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#practiceprogress"> Practice Progress</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" data-toggle="tab" href="#performanceprogress"> Performance Progress</a></a> -->
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="practiceprogress" role="tabpanel">
                    <div class="pt-2">
                        <div class="row p-1">
                            <div class="col-md" style=" padding:4px 2px 4px 2px !important;">
                                <div class="module-mini-card">

                                    <div class="card progress_1">
                                        <div class="card-body">
                                            <div class="ProgressBar-wrap position-relative">
                                                <div class="ProgressBar ProgressBar_1" data-progress="<?php echo $questions_progress['model_wise']['reading']['percent_progress']; ?>">
                                                    <svg class="ProgressBar-contentCircle" viewBox="0 0 200 200">
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-background" cx="100" cy="100" r="8">
                                                        </circle>
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-circle" cx="100" cy="100" r="85"
                                                            style="stroke-dasharray: 534px; stroke-dashoffset: 133.5px;">
                                                        </circle>
                                                    </svg>

                                                    <span class="ProgressBar-percentage"><?php echo $questions_progress['model_wise']['reading']['attempted']; ?></span>
                                                    <span class="ProgressBar-percentage--text">
                                                        Reading Questions
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md" style=" padding:4px 2px 4px 2px !important;">
                                <div class="module-mini-card">
                                    <div class="card progress_2">
                                        <div class="card-body">
                                            <div class="ProgressBar-wrap position-relative">
                                                <div class="ProgressBar ProgressBar_2" data-progress="<?php echo $questions_progress['model_wise']['speaking']['percent_progress']; ?>">
                                                    <svg class="ProgressBar-contentCircle" viewBox="0 0 200 200">
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-background" cx="100" cy="100" r="8">
                                                        </circle>
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-circle" cx="100" cy="100" r="85"
                                                            style="stroke-dasharray: 534px; stroke-dashoffset: 133.5px;">
                                                        </circle>
                                                    </svg>

                                                    <span class="ProgressBar-percentage"><?php echo $questions_progress['model_wise']['speaking']['attempted']; ?></span>
                                                    <span class="ProgressBar-percentage--text">
                                                        Speaking Questions
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md " style=" padding:4px 2px 4px 2px !important;">
                                <div class="module-mini-card">
                                    <div class="card progress_3">
                                        <div class="card-body">
                                            <div class="ProgressBar-wrap position-relative">
                                                <div class="ProgressBar ProgressBar_3" data-progress="<?php echo $questions_progress['model_wise']['writing']['percent_progress']; ?>">
                                                    <svg class="ProgressBar-contentCircle" viewBox="0 0 200 200">
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-background" cx="100" cy="100" r="8">
                                                        </circle>
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-circle" cx="100" cy="100" r="85"
                                                            style="stroke-dasharray: 534px; stroke-dashoffset: 133.5px;">
                                                        </circle>
                                                    </svg>

                                                    <span class="ProgressBar-percentage"><?php echo $questions_progress['model_wise']['writing']['attempted']; ?></span>
                                                    <span class="ProgressBar-percentage--text">
                                                        Writing Questions
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md " style=" padding:4px 2px 4px 2px !important;">
                                <div class="module-mini-card">
                                    <div class="card progress_4">
                                        <div class="card-body">
                                            <div class="ProgressBar-wrap position-relative">
                                                <div class="ProgressBar ProgressBar_4" data-progress="<?php echo $questions_progress['model_wise']['listening']['percent_progress']; ?>">
                                                    <svg class="ProgressBar-contentCircle" viewBox="0 0 200 200">
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-background" cx="100" cy="100" r="8">
                                                        </circle>
                                                        <circle transform="rotate(135, 100, 100)"
                                                            class="ProgressBar-circle" cx="100" cy="100" r="85"
                                                            style="stroke-dasharray: 534px; stroke-dashoffset: 133.5px;">
                                                        </circle>
                                                    </svg>

                                                    <span class="ProgressBar-percentage"><?php echo $questions_progress['model_wise']['listening']['attempted']; ?></span>
                                                    <span class="ProgressBar-percentage--text">
                                                    Listening Questions
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        

                        </div>
                    </div>

                    <div class="accordionclass pt-2">
                        <button class="accordion practiceaccordian">View practice progress</button>
                        <div class="panel pt-2">
                            <div aria-labelledby="panel1-header" id="panel1-content" role="region" class=""
                                ownerstate="[object Object]"
                                style="opacity: 1; transition: opacity 400ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;">
                                <div class="">
                                    <p class="">
                                    <div class="subject-cards">
                                        <div class="subject-cards-left">
                                            <div class="sub-card-body">
                                                <div class="subject-header"><span style="color: rgb(236, 147, 95);"
                                                        class="spanmore">Speaking</span>
                                                    <div class="more-icon"><span></span></div>
                                                </div>
                                                <div class="subject-body none">
                                                    <div class="subject-left">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/read_alouds/">Read  Aloud</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['read_alouds']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['read_alouds']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['read_alouds']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/describe_images">Describe Image</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['describe_images']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['describe_images']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['describe_images']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/answer_questions">Answer Short Question</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['answer_questions']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['answer_questions']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['answer_questions']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="subject-right">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/repeat_sentences">Repeat Sentence</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['repeat_sentences']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['repeat_sentences']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['repeat_sentences']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($this->session->userdata('pte_type') == PTECORE) { ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/respond_situation">Respond to a Situation</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['respond_situation']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['respond_situation']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['respond_situation']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/retell_lectures">Re-Tell Lecture</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['retell_lectures']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['retell_lectures']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['retell_lectures']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sub-card-body">
                                                <div class="subject-header"><span style="color: rgb(81, 218, 97);"
                                                        class="spanmore">Reading</span>
                                                    <div class="more-icon"><span></span></div>
                                                </div>
                                                <div class="subject-body none">
                                                    <div class="subject-left">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/fib_wr">Reading &amp; Writing: Fill in the Blanks</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['fib_wr']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['fib_wr']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['fib_wr']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/r_mcs">Multiple Choice, Single Answer</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['r_mcs']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['r_mcs']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['r_mcs']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/ro">Re-order Paragraphs</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['ro']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['ro']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['ro']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="subject-right">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/r_mcm">Multiple Choice, Multiple Answers</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['r_mcm']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['r_mcm']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['r_mcm']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/fib_rd">Reading:Fill in the Blanks</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['fib_rd']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['fib_rd']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['fib_rd']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="subject-cards-right">
                                            <div class="sub-card-body">
                                                <div class="subject-header"><span style="color: rgb(103, 184, 252);"
                                                        class="spanmore">Writing</span>
                                                    <div class="more-icon"><span></span></div>
                                                </div>
                                                <div class="subject-body none">
                                                    <div class="subject-left">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/swtx">Summarize Written Text</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['swtx']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['swtx']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['swtx']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="subject-right">
                                                        <?php if ($this->session->userdata('pte_type') == PTECORE) { ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/email">Write Email</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['email']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['email']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['email']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/essays">Write Essay</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['essays']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['essays']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['essays']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="sub-card-body">
                                                <div class="subject-header"><span style="color: var(--listening_color);"
                                                        class="spanmore">Listening</span>
                                                    <div class="more-icon"><span></span></div>
                                                </div>
                                                <div class="subject-body none">
                                                    <div class="subject-left">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/ssts">Summarize Spoken Text</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['ssts']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['ssts']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['ssts']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/l_fib">Fill in the Blanks</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['l_fib']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['l_fib']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['l_fib']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/l_mcm">Multiple Choice, Multiple Answers</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['l_mcm']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['l_mcm']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['l_mcm']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/hiws">Highlight Incorrect Words</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['hiws']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['hiws']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['hiws']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="subject-right">
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/l_mcs">Multiple Choice, Single Answer</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['l_mcs']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['l_mcs']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['l_mcs']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php if ($this->session->userdata('pte_type') == PTEACADEMIC) { ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/l_hcs">Highlight Correct Summary</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['l_hcs']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['l_hcs']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['l_hcs']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/l_smw">Select Missing Word</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['l_smw']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['l_smw']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['l_smw']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="subject-details">
                                                            <div class="chapter-details">
                                                                <a class="chapter-title" href="<?php echo base_url() ?>user/wfds">Write from Dictation</a>
                                                                <span class="chapter-score"><?php echo $questions_progress['category_wise']['wfds']['attempted']; ?><span class="out-of-score">/<?php echo $questions_progress['category_wise']['wfds']['total']; ?></span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar" style="width: <?php echo $questions_progress['category_wise']['wfds']['percent_progress']; ?>%">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="sub-card-body">
                                                <div class="subject-header"><span style="color: rgb(232, 53, 43);"
                                                        class="spanmore">Mock
                                                        Tests</span>
                                                    <div class="more-icon"><span></span></div>
                                                </div>
                                                <div class="subject-body none">
                                                    <div class="subject-left">
                                                        <div class="subject-details">
                                                            <div class="chapter-details"><a class="chapter-title"
                                                                    href="<?php echo base_url() ?>mock/mocktestlist">Full
                                                                    Mock Tests</a><span class="chapter-score"
                                                                    style="color: rgb(232, 53, 43);">0<span
                                                                        class="out-of-score"
                                                                        style="color: rgb(232, 53, 43);">/101</span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar "
                                                                    style="width: <?php echo strlen($target[0]->reading) > 0 ? round($target[0]->reading / 90 * 100) . '%' : '0%'; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="subject-right">
                                                        <div class="subject-details">
                                                            <div class="chapter-details"><a class="chapter-title"
                                                                    href="<?php echo base_url() ?>mock/mocktestlist">Sectional
                                                                    Mock Tests</a><span class="chapter-score"
                                                                    style="color: rgb(232, 53, 43);">0<span
                                                                        class="out-of-score"
                                                                        style="color: rgb(232, 53, 43);">/184</span></span>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar "
                                                                    style="width: <?php echo strlen($target[0]->reading) > 0 ? round($target[0]->reading / 90 * 100) . '%' : '0%'; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="tab-pane" id="performanceprogress" role="tabpanel"></div>

            </div>
        </div>
    </div>


</section>

<section id ="featurevideos">
    <div class="panel-section-card py-20 px-25 mt-20 featurevideos">
        <div class="row">
            <h3 class="fs-20 text-black mb-2 ml-4 h3title">Free resources </h3>
        </div>

        <div class="row mt-3">

            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">
                            <iframe src="https://www.youtube.com/embed/GsEv_gneBRM" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">
                            <iframe src="https://www.youtube.com/embed/xpwYFc_txLA" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">
                            <iframe src="https://www.youtube.com/embed/bul-u-vH7yU" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">

                            <iframe src="https://www.youtube.com/embed/7IX2woKNPA4" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>


                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">
                            <iframe src="https://www.youtube.com/embed/kqp7Gx2MOYM" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-4 col-sm-4" id="video">
                <div class="card">

                    <div class="card-body" style="width: 100%;">
                        <div class="text-center">
                            <iframe src="https://www.youtube.com/embed/KLuFsIqV0bY" 
                                title="YouTube video player"
                                loading="lazy"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="panel-section-card py-20 px-25 mt-20">
        <div class="row">
            <h3 class="fs-20 text-black mb-2 ml-4 h3title">Offers</h3>
        </div>

        <div class="row">
            <div class="col-md-4 pt-3">
                <a href="https://oneaustraliagroup.com/" target="_blank"><img
                        src="<?php echo base_url() ?>assets/images/banners/banner1.jpeg" width="100%"
                        style="border-radius: 10px;"></a>
            </div>

            <div class="col-md-4 pt-3">
                <a href="https://oneaustraliagroup.com/" target="_blank"><img
                        src="<?php echo base_url() ?>assets/images/banners/banner2.jpeg" width="100%"
                        style="border-radius: 10px;"></a>
            </div>
            <div class="col-md-4 pt-3">
                <a href="https://oneaustraliagroup.com/" target="_blank"><img
                        src="<?php echo base_url() ?>assets/images/banners/banner3.jpeg" width="100%"
                        style="border-radius: 10px;"></a>
            </div>
            <div class="col-md-4 pt-3">
                <a href="https://oneaustraliagroup.com/" target="_blank"><img
                        src="<?php echo base_url() ?>assets/images/banners/banner4.jpeg" width="100%"
                        style="border-radius: 10px;"></a>
            </div>

        </div>



    </div>

</section>







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
                        <div class="scorestatsform" style="display:flex; justify-content: space-around; ">
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
                    <div class="col-md-10" style="display:flex; justify-content: center; flex-wrap: wrap;">
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


<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active-accordion");
        var panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
        } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
        }
    });
}


//line chart
var ctx = document.getElementById( "bar-chart" );
        var myChart = new Chart( ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($week_days); ?>,
                datasets: 
                    <?php
                        $datasets = [];
                        $bg_colors = array("reading" => "#F5767A","listening" => "#B13AFF","writing" => "#616DFF","speaking" => "#E583BB");
                        foreach ($this->data['last_week_practice_attempts'] as $key => $value) {
                            $dataset = [];
                            $dataset['label'] = ucwords($key);
                            $dataset['borderColor'] = $bg_colors[$key];
                            $dataset['borderWidth'] = "1";
                            $dataset['backgroundColor'] = $bg_colors[$key];
                            $dataset['data'] = array_values($value);
                            $datasets[] = $dataset;
                        }
                        echo json_encode($datasets);
                    ?>
                
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                tooltips: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [ {
                        display: true,
                        gridLines: {
                            display: false,
                            drawBorder: false,
                            color: 'rgb(227, 226, 236,0.4)'
                        },
                        ticks: {
                            fontColor: "#9493a9",

                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Month',
                        }
                            } ],
                    yAxes: [ {
                        display: true,
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            color: 'rgb(227, 226, 236,0.4)'
                        },
                        ticks: {
                            fontColor: "#9493a9",
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Value',
                            fontColor: "#9493a9",
                        }
                            } ]
                },
                title: {
                    display: false,
                    text: 'Normal Legend'
                }

            }
        } );
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
const siteUrl = '<?php echo base_url(); ?>';

$('#edit-target').click(() => {
    location.href = siteUrl + 'user/studycenter';
});
</script>

<!-- setTarget popup -->
<script src="<?php echo base_url() ?>assets/vendor/global/global.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/custom.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/deznav-init.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/vendor/canvas/canvas.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/vendor/flot/jquery.flot.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/parsley/parsley.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.1/parsley.min.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<!-- <script src="<?php echo base_url() ?>assets/js/Chart.min.js"></script> -->
<!-- <script src="<?php echo base_url() ?>assets/js/custom-chart.js"></script>    -->

<script>
const numbers = document.querySelectorAll('input[type="number"]');
const radios = document.querySelectorAll('input[name="target"]');

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
                    location.href = siteUrl + 'user/home';
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


