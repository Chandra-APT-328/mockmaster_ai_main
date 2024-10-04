<?php if($model == 'read_alouds'){ ?>
        <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
        <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
        <input type="hidden" name="response">

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="que-detail">
                    <!-- <h5>You will hear a short report. Write a summary for a fellow student who was not present. You should write 50-70 words</h5>
                </div>
                <div class="que-detail mt-3">
                    <h5>You have 10 minutes to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points presented in the lecture.</h5> -->
                    <h5><?php echo $category[0]->type_description; ?></h5>
                </div>
            </div>
        </div>

        
        <div class="player mt-3">
            <div class="recorder-container">
                <div class="heading">
                    <h4>Audio Recorder</h4>
                </div>
                <div class="heading pulsate">
                    <span id="record-prepare-text"></span>
                    <span id="record-prepare-timer"></span>
                </div>
            </div>
            <div class="audio-error-container d-none">
                <span>Microphone permission is not granted.</span>
            </div>
            <div class="progress-bar progress-bar-striped" id="recording-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0px; height:10px;" role="progressbar">
            </div>
        </div>


        <div class="row mb-4 mt-4 read-aloud-question">
            <div class="col-12">
                <?php echo $question[0]->question; ?>
            </div>
        </div>

        <div>
            <div class="user-speech"></div>
        </div>

        <script type="text/javascript">
            recordingProgress = 0;
            progressBarInterval = null;
            progessBarTimeElapsed = 0;
            startAudioRecordingPrepareTimer(25,initAudioRecording,37);
        </script>


<?php } ?>


<?php if($model == 'repeat_sentences' || $model == 'describe_images' || $model == 'retell_lectures' ||$model == 'respond_situation' || $model == 'answer_questions'){ ?>

        <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
        <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
        <input type="hidden" name="response">

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="que-detail">
                    <!-- <h5>You will hear a short report. Write a summary for a fellow student who was not present. You should write 50-70 words</h5>
                </div>
                <div class="que-detail mt-3">
                    <h5>You have 10 minutes to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points presented in the lecture.</h5> -->
                    <h5><?php echo $category[0]->type_description; ?></h5>
                </div>
            </div>
        </div>

        
        <div class="player mt-3">
            <?php if($model == 'repeat_sentences' || $model == 'retell_lectures' ||$model == 'respond_situation'  ||  $model == 'answer_questions'){ ?>
                <div class="imgbx">
                    <div class="heading">
                        <h4>Audio Player</h4>
                    </div>
                    <div class="heading pulsate">
                        <span id="audio-prepare-text"></span>
                        <span id="audio-prepare-timer"></span>
                    </div>
                </div>
                <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
                <audio onended="audioend();" onloadedmetadata="startAudioPlayTimer(3,this);">
                        <source src="<?php echo cache_bust_resource($question[0]->resourcePath); ?>" type="audio/mpeg">
                </audio>
            <?php } ?>
            <?php if($model == 'describe_images'){ ?>
                <img src="<?php echo cache_bust_resource($question[0]->resourcePath); ?>" alt="describe image" style="width:500px;">
            <?php } ?>
        </div>


        <div class="player mt-3">
            <div class="recorder-container">
                <div class="heading">
                    <h4>Audio Recorder</h4>
                </div>
                <div class="heading pulsate">
                    <span id="record-prepare-text"></span>
                    <span id="record-prepare-timer"></span>
                </div>
            </div>
            <div class="audio-error-container d-none">
                <span>Microphone permission is not granted.</span>
            </div>
            <div class="progress-bar progress-bar-striped" id="recording-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0px; height:10px;" role="progressbar">
            </div>
        </div>

        <div>
            <div class="user-speech"></div>
        </div>

        <?php if($model == 'describe_images'){ ?>
            <script type="text/javascript">
                recordingProgress = 0;
                progressBarInterval = null;
                progessBarTimeElapsed = 0;
                startAudioRecordingPrepareTimer(25,initAudioRecording,37);
            </script>
        <?php } ?>      
        <?php if($model == 'repeat_sentences' || $model == 'retell_lectures' ||$model == 'respond_situation' || $model == 'answer_questions'){ 
            switch($model){
                case 'repeat_sentences':
                    $prepare = 3;
                    $duration = 14;
                    break;
                case 'retell_lectures':
                    $prepare = 10;
                    $duration = 37;
                    break;
                case 'answer_questions':
                    $prepare = 3;
                    $duration = 10;
                    break;
                default:
                    $prepare = 3;
                    $duration = 37;
            }
        ?>
            <script type="text/javascript">
                countdownInterval = null;
                function audioend(){
                    recordingProgress = 0;
                    progressBarInterval = null;
                    progessBarTimeElapsed = 0;
                    startAudioRecordingPrepareTimer(<?php echo $prepare; ?>,initAudioRecording,<?php echo $duration; ?>);
                }
            </script>
        <?php } ?>      

<?php } ?>


<?php if($model == 'ssts' || $model == 'wfds' || $model == 'swtx' || $model == 'essays'|| $model == 'email'){ ?>

        <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
        <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
        <input type="hidden" name="response">

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="que-detail">
                    <!-- <h5>You will hear a short report. Write a summary for a fellow student who was not present. You should write 50-70 words</h5>
                </div>
                <div class="que-detail mt-3">
                    <h5>You have 10 minutes to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points presented in the lecture.</h5> -->
                    <h5><?php echo $category[0]->type_description; ?></h5>
                </div>
            </div>
        </div>

        <?php if($model == 'ssts' || $model == 'wfds'){ ?>
            <div class="player mt-3">
                <div class="imgbx">
                    <div class="heading">
                        <h4>Audio Player</h4>
                    </div>
                    <div class="heading pulsate">
                        <span id="audio-prepare-text"></span>
                        <span id="audio-prepare-timer"></span>
                    </div>
                </div>
                <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
                <audio onloadedmetadata="startAudioPlayTimer(3,this);">
                        <source src="<?php echo cache_bust_resource($question[0]->audioPath); ?>" type="audio/mpeg">
                </audio>
            </div>
        <?php } ?>
        

        <?php if($model == 'swtx' || $model == 'essays' || $model == 'email'){ ?>
            <div class="row mb-2 mt-3">
                <div class="col-12">
                    <h5><p><?php echo $question[0]->question; ?></p></h5>
                </div>
            </div>
        <?php } ?>


        <div class="row mt-3">
            <div class="col-md-12">
                <div class="answer">        
                    <div class="box d-flex" style="justify-content: space-between">
                        <div class="box-copy">
                            <button onclick="copyText()">Copy</button>
                            <button onclick="cutText()">Cut</button>
                            <button onclick="pasteText()">Paste</button>
                        </div>
                        
                        <div id="result">
                            <span id="wordCount">0</span> Word(s) <br/>
                        </div>     
                    </div>

                    <div id="border">
                        <textarea id="text" cols="60" spellcheck="false" autocomplete="off"></textarea>
                    </div>       
                </div>
            </div>
        </div>


        <script type="text/javascript">
            counter = function () {
                var value = $("#text").val();
                
                $('[name=response]').val(value);

                if (value.length == 0) {
                    $("#wordCount").html(0);
                    return;
                }

                var regex = /\s+/gi;
                var wordCount = value.trim().replace(regex, " ").split(" ").length;

                $("#wordCount").html(wordCount);
                };


            $("#text").change(counter);
            $("#text").keydown(counter);
            $("#text").keypress(counter);
            $("#text").keyup(counter);
            $("#text").blur(counter);
            $("#text").focus(counter);
        </script>
<?php } ?>


<?php if($model == 'l_mcm' || $model == 'r_mcm'){ ?>

    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
                <h5><?php echo $category[0]->type_description; ?></h5>
           </div>
        </div>
    </div>

    <?php if($model == 'l_mcm'){ ?>
        <div class="player mt-3">
            <div class="imgbx">
                <div class="heading">
                    <h4>Audio Player</h4>
                </div>
                <div class="heading pulsate">
                    <span id="audio-prepare-text"></span>
                    <span id="audio-prepare-timer"></span>
                </div>
            </div>
            <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
            <audio onloadedmetadata="startAudioPlayTimer(3,this);">
                    <source src="<?php echo cache_bust_resource($question[0]->audioPath); ?>" type="audio/mpeg">
            </audio>
        </div>
    <?php } ?>


    <div class="row mb-2 mt-3">
        <div class="col-12">
            <h5><p><?php echo $question[0]->question; ?></p></h5>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-12">
            <?php
                $options = json_decode($question[0]->options);
                $i = 65; $j = 1;
                foreach($options as $row){
                    $option = chr($i).") ".$row;
            ?>
                <div class="form-check mb-3">
                    <input type="hidden" name="optionSelected[]" id="optionSelection<?php echo $j; ?>" value="0">
                    <input class="form-check-input" type="checkbox" name="options[]" id="option<?php echo $j; ?>" value="<?php echo chr($i); ?>" onclick="ismultiplecheck(<?php echo $j; ?>)">
                    <label class="form-check-label check-option" for="option<?php echo $j; ?>"><?php echo $option; ?></label>
                </div>
                <?php $i++; $j++;} ?>
        </div>
    </div>

<?php } ?>


<?php if($model == 'l_mcs' || $model == 'l_hcs' || $model == 'l_smw' || $model == 'r_mcs'){ ?>

    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
           </div>
        </div>
    </div>


    <?php if($model == 'l_mcs' || $model == 'l_hcs' || $model == 'l_smw'){ ?>
        <div class="player mt-3">
            <div class="imgbx">
                <div class="heading">
                    <h4>Audio Player</h4>
                </div>
                <div class="heading pulsate">
                    <span id="audio-prepare-text"></span>
                    <span id="audio-prepare-timer"></span>
                </div>
            </div>
            <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
            <audio onloadedmetadata="startAudioPlayTimer(3,this);">
                    <source src="<?php echo cache_bust_resource($question[0]->audioPath); ?>" type="audio/mpeg">
            </audio>
        </div>
    <?php } ?>


    <div class="row mb-2 mt-3">
        <div class="col-12">
            <h5><p> <?php echo $question[0]->question; ?></p></h5>
        </div>
    </div>


    <div class="row mb-4">
        <div class="col-12">
            <?php
                $options = json_decode($question[0]->options);
                $i = 65; $j = 1;
                foreach($options as $row){
                    $option = chr($i).") ".$row;
            ?>
                <div class="radio mb-3 form-check">
                    <input type="hidden" name="optionSelected[]" id="optionSelection<?php echo $j; ?>" value="0">
                    <input class="form-check-input" type="radio" name="options" id="option<?php echo $j; ?>" value="<?php echo chr($i); ?>" onclick="issinglecheck(<?php echo $j; ?>)">
                    <label class="form-check-label radio-option" for="option<?php echo $j; ?>"><?php echo $option; ?></label>
                </div>
                <?php $i++; $j++;} ?>
        </div>
    </div>

<?php } ?>


<?php if($model == 'l_fib'){ ?>
    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
           </div>
        </div>
    </div>


    <div class="player mt-3">
        <div class="imgbx">
            <div class="heading">
                <h4>Audio Player</h4>
            </div>
            <div class="heading pulsate">
                <span id="audio-prepare-text"></span>
                <span id="audio-prepare-timer"></span>
            </div>
        </div>
        <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
        <audio onloadedmetadata="startAudioPlayTimer(3,this);">
            <source src="<?php echo cache_bust_resource($question[0]->audioPath); ?>" type="audio/mpeg">
        </audio>
    </div>


    <!-- <div class="row mb-2 mt-3">
        <div class="col-12">
            <h5><p>Which of the following statements about microplastics are incorrect?</p></h5>
        </div>
    </div> -->


    <div class="row mb-4">
        <div class="col-12">
            <h5>
                <p>
                    <?php
                        $input = "<input class='lfib-blank' type='text' name='blanks[]' onblur='validateblanks();' spellcheck='false' autocomplete='off'>";
                        $question = preg_replace("/\{(.*?)\}/", $input, $question[0]->question);
                        echo $question;
                    ?>
                </p>
            </h5>
        </div>
    </div>
    <script>
        var blank = [];  
        validateblanks();
        
        if(_tagArr == undefined || _tagArr == "undefined"){
            let _tagArr = document.getElementsByTagName("input");
        }else{
            _tagArr = document.getElementsByTagName("input");
        }
        
        for (let i = 0; i < _tagArr.length; i++) {
            _tagArr[i].autocomplete = 'off';
        }
    </script>
<?php } ?>


<?php if($model == 'fib_wr'){ ?>
    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
           </div>
        </div>
    </div>


    <!-- <div class="row mb-2 mt-3">
        <div class="col-12">
            <h5><p>Which of the following statements about microplastics are incorrect?</p></h5>
        </div>
    </div> -->


    <div class="row mb-4">
        <div class="col-12">
            <h5>
                <p>
                    <?php 
                        preg_match_all('/{(.*?)}/', $question[0]->question, $wrongWords);
                        $wrongWords = $wrongWords[1];
                        $text =$question[0]->question;
                        $options = json_decode($question[0]->options);
                        // var_dump($wrongWords);

                        $i = 0 ;
                        foreach ($options as $optionSet => $option) {
                            $select = '<select class="wrfib-blank" name="selectOptions[]" onchange="checkblank();">';
                            $select .= '<option value=""></option>';
                            // var_dump($option);echo'<br>';
                            foreach ($option as $key => $rowOption) {
                                $select .= '<option value="' . $rowOption . '">' . $rowOption . '</option>';
                            }
                            $select .= '</select>';
                            $text = str_replace('{' . $wrongWords[$i] . '}', $select, $text);
                            $i++;
                        }
                
                        echo $text;
                    ?>
                </p>
            </h5>
        </div>
    </div>
    <script>
        var blank = [];  
        checkblank();
    </script>
<?php } ?>

<?php if($model == 'fib_rd'){ ?>
    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
           </div>
        </div>
    </div>


    <!-- <div class="row mb-2 mt-3">
        <div class="col-12">
            <h5><p>Which of the following statements about microplastics are incorrect?</p></h5>
        </div>
    </div> -->


    <div class="row mb-4">
        <div class="col-12">
                <div id="fib-rd-blanks-container">
                    <?php echo $fitbquestion = preg_replace("/\{(.*?)\}/",'<div class="fib-rd-blank" ></div>', $question[0]->question);  ?>
                </div>

                <div id="fib-rd-options-container">
                    <?php
                        $options = json_decode($question[0]->options);
                        foreach ($options as $optionSet => $option) {
                    ?>
                        <div class="fib-rd-option"  draggable="true"><?php echo $option; ?></div>
                    <?php } ?>
                </div>
        </div>
    </div>
    <script>
        checkfibrdblank();

        var fibrdoptions,fitrdblanks,fitrdoptionsContainer = null;
        fibrdoptions = document.querySelectorAll('#fib-rd-options-container div');
        fitrdblanks = document.querySelectorAll('#fib-rd-blanks-container div');
        fitrdoptionsContainer = document.getElementById("fib-rd-options-container");

        fitrdoptionsContainer.addEventListener("dragenter", function(event) {
        event.preventDefault();
        fitrdoptionsContainer.classList.add('fib-rd-hover');
        });

        fitrdoptionsContainer.addEventListener("dragover", function(event) {
        event.preventDefault();
        fitrdoptionsContainer.classList.add('fib-rd-hover');
        });

        fitrdoptionsContainer.addEventListener("dragleave", function(event) {
        event.preventDefault();
        fitrdoptionsContainer.classList.remove('fib-rd-hover');
        });

        fitrdoptionsContainer.addEventListener("drop", function(e) {
            event.preventDefault();
            fitrdoptionsContainer.classList.remove('fib-rd-hover');
            
            const dragging = document.querySelector('.dragging');

            if(dragging.classList.contains('dragging-from-blanks')){
                const option = document.createElement('div');
                option.innerText = dragging.innerText;
                option.classList.add('fib-rd-option');
                option.setAttribute('draggable', 'true');
                
                dragging.innerText = '';

                option.addEventListener('dragstart', () => {
                    option.classList.add('dragging');
                    option.classList.add('dragging-from-options');
                });
                option.addEventListener('dragend', () => {
                    option.classList.remove('dragging');
                    option.classList.remove('dragging-from-options');
                });
                dragging.classList.remove('dragging');
                dragging.classList.remove('fib-rd-blank-move');
                fitrdoptionsContainer.appendChild(option);
                checkfibrdblank();
            }
        });

        fibrdoptions.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
            draggable.classList.add('dragging-from-options');
        });

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging');
            draggable.classList.remove('dragging-from-options');
        });
        });

        fitrdblanks.forEach(blank => {
        blank.addEventListener('dragover', e => {
            e.preventDefault();
            blank.classList.add('fib-rd-hover');
        });

        blank.addEventListener('dragleave', (e) => {
            e.preventDefault();
            blank.classList.remove('fib-rd-hover');
        });

        blank.addEventListener('drop', e => {
            e.preventDefault();
            blank.classList.remove('fib-rd-hover');
            const dragging = document.querySelector('.dragging');

            if(dragging.classList.contains('dragging-from-options')){
                if(blank.innerText.length === 0){
                    blank.innerText = dragging.innerText;
                    dragging.remove();
                    blank.setAttribute('draggable', 'true');
                    blank.classList.add('fib-rd-blank-move');
                    checkfibrdblank();
                    return;
                }
                if(blank.innerText.length > 0){
                    const temp = blank.innerText;
                    blank.innerText = dragging.innerText;
                    dragging.remove();
                    blank.setAttribute('draggable', 'true');
                    blank.classList.add('fib-rd-blank-move');

                    const option = document.createElement('div');
                    option.draggable = true;
                    option.innerText = temp;
                    option.classList.add('fib-rd-option');

                    option.addEventListener('dragstart', () => {
                        option.classList.add('dragging');
                        option.classList.add('dragging-from-options');
                    });
                    option.addEventListener('dragend', () => {
                        option.classList.remove('dragging');
                        option.classList.remove('dragging-from-options');
                    });
                    fitrdoptionsContainer.appendChild(option);
                    checkfibrdblank();
                    return;
                }
            }
        });

        blank.addEventListener('dragstart', (e) => {
            if (blank.innerText.length === 0) {
                e.preventDefault();
                blank.setAttribute('draggable', 'false');
                return;
            }
            if(blank.innerText.length > 0){
                blank.classList.add('dragging');
                blank.classList.add('dragging-from-blanks');
            }
        });

        blank.addEventListener('dragend', () => {
            blank.classList.remove('dragging');
            blank.classList.remove('dragging-from-blanks');
        });
        });

    </script>
<?php } ?>


<?php if($model == 'ro'){ ?>
    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
           </div>
        </div>
    </div>

    <div class="row mb-2 mt-4">
        <div class="col-12">
            <div class="ro-container">
                <div class="ro-dropzone ro-source">
                    <?php 
                        $paragraphs = json_decode($question[0]->options);
                        foreach ($paragraphs as $pkey => $paragraph) {
                    ?>
                        <div class="ro-draggable" data-order="<?php echo $pkey+1; ?>" draggable="true"><span style="margin-right: 5px;"><?php echo $pkey+1 .') '; ?></span><span><?php echo $paragraph; ?></span></div>
                    <?php } ?>
                </div>
                <div class="ro-dropzone ro-target">
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        updateROResponse();
        var dropzoneSource,dropzone,dropzones,draggables = null;
        dropzoneSource = document.querySelector(".ro-source");
        dropzone = document.querySelector(".ro-target");
        dropzones = [...document.querySelectorAll(".ro-dropzone")];
        draggables = [...document.querySelectorAll(".ro-draggable")];

        function getDragAfterElement(container, y) {
            const draggableElements = [
                ...container.querySelectorAll(".ro-draggable:not(.ro-is-dragging)")
            ];

            return draggableElements.reduce(
                (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return {
                    offset,
                    element: child
                    };
                } else {
                    return closest;
                }
                },
                { offset: Number.NEGATIVE_INFINITY }
            ).element;
        }

        draggables.forEach((draggable) => {
            draggable.addEventListener("dragstart", (e) => {
                draggable.classList.add("ro-is-dragging");
            });

            draggable.addEventListener("dragend", (e) => {
                draggable.classList.remove("ro-is-dragging");
            });
        });

        dropzones.forEach((zone) => {
            zone.addEventListener("dragover", (e) => {
                e.preventDefault();
                const afterElement = getDragAfterElement(zone, e.clientY);
                const draggable = document.querySelector(".ro-is-dragging");
                if (afterElement === null) {
                zone.appendChild(draggable);
                } else {
                zone.insertBefore(draggable, afterElement);
                }
                updateROResponse();
            });
        });

    </script>
<?php } ?>


<?php if($model == 'hiws'){ ?>
    <input type="hidden" id="category" value="<?php echo $modelcategory; ?>">
    <input type="hidden" id="model" value="<?php echo $question[0]->question_type; ?>">
    <input type="hidden" name="response">

    <div class="row mt-3">
        <div class="col-md-12">
           <div class="que-detail">
                <h5><?php echo $category[0]->type_description; ?></h5>
                <!-- <h5>Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.</h5> -->
           </div>
        </div>
    </div>


    <div class="player mt-3">
        <div class="imgbx">
            <div class="heading">
                <h4>Audio Player</h4>
            </div>
            <div class="heading pulsate">
                <span id="audio-prepare-text"></span>
                <span id="audio-prepare-timer"></span>
            </div>
        </div>
        <div class="progress-bar progress-bar-striped" id="audio-progress" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%; height:10px;" role="progressbar"></div>
        <audio onloadedmetadata="startAudioPlayTimer(3,this);">
            <source src="<?php echo cache_bust_resource($question[0]->audioPath); ?>" type="audio/mpeg">
        </audio>
    </div>


    <div class="row mb-2">
        <div class="col-12 noselect">
            <h4>
                <p id="hiws">
                    <?php 
                        echo str_replace(array("{", "}"), "", $question[0]->question);
                    ?>
                </p>
            </h4>
        </div>
    </div>


    <script type="text/javascript">
        hiwsSelectedWords = [];
        var words = document.getElementById("hiws").innerText.split(" ");
        var str = '';
        for (var i = 0; i < words.length; i++) {
            str += '<span>'+words[i]+'</span>';
        }

        $('#hiws').html(str);

        $('#hiws span').click( 
            function() { 
                $(this).toggleClass("highlight");

                var word = this.innerText;
                if(hiwsSelectedWords.includes(word)) {
                    hiwsSelectedWords.splice(hiwsSelectedWords.indexOf(word),1);
                } else {
                    hiwsSelectedWords.push(word);
                }

                if(hiwsSelectedWords.length > 0){
                    $('[name="response"]').val(JSON.stringify(hiwsSelectedWords));
                }else{
                    $('[name="response"]').val('');
                }
            }
        );
    </script>
<?php } ?>