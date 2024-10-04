<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mock Test</title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/one-aus-logo.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="<?php echo base_url("assets/css/mock-loading-spinner.css"); ?>" rel="stylesheet">
    <link href="<?php echo base_url("assets/css/mock-layout.css"); ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://www.webrtc-experiment.com/DetectRTC.js"> </script>
    <script src="https://www.webrtc-experiment.com/RecordRTC.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</head>

<body class="noselect">

    <div class="modal" id="modal-loading" data-bs-backdrop="static" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loading-spinner mb-2"></div>
                    <div id="loader-message">Loading</div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" class="csrfToken" name="<?php echo $this->security->get_csrf_token_name(); ?>"
        value="<?php echo $this->security->get_csrf_hash(); ?>">
    <nav class="navbar navbar-light">
        <div class="container">
            <a class="navbar-brand" href="<?php echo base_url(); ?>user/home"><i class="fa fa-home"
                    style="color: #FFFFFF;"></i></a>
            <div class="d-flex" style="align-items: center;">
                <!-- <a class="" href="#">Contact</a> -->
                <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                <input type="hidden" id="mocktestid" value="<?php echo $mocktestid; ?>">
                <button class="btn" id="back-to-pte" type="button">Back to myPTE</button>
            </div>
        </div>
    </nav>

    <section class="mt-3">
        <div class="container">
            <div class="d-flex test flex-wrap justify-content-between ">
                <div class="col-md-8 test-name">
                    <h2> <?php echo $mockdata[0]->title; ?> </h2>
                </div>

                <div class="col-md-2 right-side">
                    <div class="paginate">
                        <h4><span id="attempted"></span></h4>
                    </div>
                </div>

                <div class="col-md-2 timer d-none">
                    <h5><span> <i class="fa fa-clock-o"></i> </span> <span id="exam-timer"></span><span
                            id="exam-duration"></span></h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped" id="exam-progress" aria-valuenow="0"
                            aria-valuemin="0" aria-valuemax="100" style="width:0px; height:10px;" role="progressbar">
                        </div>
                    </div>
                </div>

                <div id="question-box">
                    <div class="row mt-4">
                        <h1>Click to start test.</h1>
                        <?php if($mockdata[0]->test_type == "full-test"){ ?>
                            <h5>Note: The test might take 2 hours to complete. Once the test is started you cannot stop untill it is completed. Leaving in between may affect your progress.</h5>
                        <?php } ?>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="d-flex" style="justify-content: space-between;">
                            <div class="save-btn" id="saveandexitbtn" onclick="saveandexit();" style="display:none;">
                                <input type="button" value="Save and Exit">
                            </div>
                            <div class="next-btn" onclick="validateresponse();" id="nextbtn" style="display:none;">
                                <input type="button" value="Next">
                            </div>
                            <div class="next-btn" onclick="start();" id="start">
                                <input type="button" value="Start">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="text-center" id="blockmicrophone"
        style="display: none;background: rgba(0,0,0,0.80);height: 100%;width: 100%;position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: 1000;">
        <div class="d-flex justify-content-center align-items-center h-100 enable-image"></div>
    </div>
    <!-- alert modal -->
    <div class="modal fade alert-modal" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="alert-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <span aria-hidden="true" aria-label="Close" data-dismiss="modal"
                                style="float:right; font-size:24px; cursor:pointer;">&times;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-3 text-center">
                            <h5>
                                <p>You need to finish answering this question before going to the next.</p>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="button" class="btn btn-secondary" data-dismiss="modal" style="float:right;"
                                value="Close" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- confirm modal -->
    <div class="modal fade confirm-modal" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="alert-modal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <span aria-hidden="true" aria-label="Close" data-dismiss="modal"
                                style="float:right; font-size:24px; cursor:pointer;">&times;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-3 text-center">
                            <h5>
                                <p>Are you sure if you want to submit this answer and go to the next question?</p>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="button" class="btn btn-secondary" id="confirm-modal-btn-submit"
                                style="float:right;" value="Yes">
                            <input type="button" class="btn btn-danger" id="confirm-modal-btn-cancel"
                                data-dismiss="modal" style="float:right;" value="No">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- save and exit confirm modal -->
    <div class="modal fade saveandexit-confirm-modal" id="saveandexit-confirm-modal" tabindex="-1" role="dialog"
        aria-labelledby="alert-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <span aria-hidden="true" aria-label="Close" data-dismiss="modal"
                                style="float:right; font-size:24px; cursor:pointer;">&times;</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-3 text-center">
                            <h5>
                                <p>Are you sure to save and exit the test?</p>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <input type="button" class="btn btn-secondary" id="saveandexit-modal-btn-submit"
                                style="float:right;" value="Yes">
                            <input type="button" class="btn btn-danger" id="saveandexit-modal-btn-cancel"
                                data-dismiss="modal" style="float:right;" value="No">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var params = {},
                r = /([^&=]+)=?([^&]*)/g;

            function d(s) {
                return decodeURIComponent(s.replace(/\+/g, ' '));
            }

            var match, search = window.location.search;
            while (match = r.exec(search.substring(1))) {
                params[d(match[1])] = d(match[2]);

                if (d(match[2]) === 'true' || d(match[2]) === 'false') {
                    params[d(match[1])] = d(match[2]) === 'true' ? true : false;
                }
            }

            window.params = params;
        })();

        $.ajaxSetup({
            cache: false
        });

        const submitresponse = createThrottleFunction(appSubmitResponse, 5000);

        var recordingProgress = 0;
        var progressBarInterval = null;
        var countdownInterval = null;
        var audioPlayingCountdownInterval = null;
        var examEndCountDownInterval = null;
        var progessBarTimeElapsed = 0;
        var record = this;
        var examPortal;
        const browser = checkBrowser();
        const siteUrl = $('#baseurl').val();
        let hiwsSelectedWords = [];

        if (browser == "Safari") {
            let img = document.createElement('img');
            img.src = siteUrl + "assets/images/mic-permission/allow-mac.png";
            img.style.width = "50%";
            img.classList.add("iosblockedimg");
            document.getElementsByClassName('enable-image')[0].appendChild(img);
        } else if (browser == "Edge") {
            let img = document.createElement('img');
            img.src = siteUrl + "assets/images/mic-permission/allow-edge.jpg";
            img.classList.add("blockedimg");
            document.getElementsByClassName('enable-image')[0].appendChild(img);
        } else if (browser == "Firefox") {
            let img = document.createElement('img');
            img.src = siteUrl + "assets/images/mic-permission/allow-firefox.jpg";
            img.classList.add("blockedimg");
            document.getElementsByClassName('enable-image')[0].appendChild(img);
        } else if (browser == "Chrome") {
            let img = document.createElement('img');
            img.src = siteUrl + "assets/images/mic-permission/allow-chrome.jpg";
            img.classList.add("blockedimg");
            document.getElementsByClassName('enable-image')[0].appendChild(img);
        }

        // var examDuration = <?php echo $mockdata[0]->exam_duration; ?> * 60 - 1;

        $('#back-to-pte').click(function () {
            location.href = siteUrl + "mock/myattempts";
        });

        $('[data-dismiss="modal"]').click(function () {
            $('#alert-modal').modal('hide');
            $('#confirm-modal').modal('hide');
            $('#saveandexit-confirm-modal').modal('hide');
        });


        var modalConfirm = function (callback) {
            $("#confirm-modal-btn-submit").off().click(function () {
                callback(true);
                $("#confirm-modal").modal('hide');
            });

            $("#confirm-modal-btn-cancel").off().click(function () {
                callback(false);
                $("#confirm-modal").modal('hide');
            });
        };

        var modalSavenExitConfirm = function (callback) {
            $("#saveandexit-modal-btn-submit").off().click(function () {
                callback(true);
                $("#saveandexit-confirm-modal").modal('hide');
            });

            $("#saveandexit-modal-btn-cancel").off().click(function () {
                callback(false);
                $("#saveandexit-confirm-modal").modal('hide');
            });
        };

        $('#modal-loading').on('hidden.bs.modal', function () {
            $("#nextbtn input[type='button']").attr('disabled',false);
            $("#start input[type='button']").attr('disabled',false);
            $("#saveandexitbtn input[type='button']").attr('disabled',false);
        });
        
        $('#modal-loading').on('show.bs.modal', function () {
            $("#confirm-modal").modal('hide');
            $("#nextbtn input[type='button']").attr('disabled',true);
            $("#start input[type='button']").attr('disabled',true);
            $("#saveandexitbtn input[type='button']").attr('disabled',true);
        });

        $(document).ready(function () {
            showLoading("Getting resources");
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: siteUrl + "mock/getresources",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: { [csrfName]: csrfHash },
                success: function (data) {
                    $('.csrfToken').val(data.token);
                    examPortal = new MockTest(data.questionData);
                    // console.log(examPortal)
                },
                complete: function (data) {
                    hideLoading();
                }
            })
        });

        function copyText() {
            var textarea = document.getElementById("text");
            var selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
            if (selectedText !== "") {
                navigator.clipboard.writeText(selectedText);
                $('#text').focus();
            }
        }

        function cutText() {
            var textarea = document.getElementById("text");
            var selectedText = textarea.value.substring(textarea.selectionStart, textarea.selectionEnd);
            if (selectedText !== "") {
                navigator.clipboard.writeText(selectedText);
                textarea.value = textarea.value.substring(0, textarea.selectionStart) + textarea.value.substring(textarea.selectionEnd);
                $('#text').focus();
            }
        }

        function pasteText() {
            var textarea = document.getElementById("text");
            navigator.clipboard.readText().then(function (clipboardText) {
                var startPos = textarea.selectionStart;
                var endPos = textarea.selectionEnd;
                textarea.value = textarea.value.substring(0, startPos) + clipboardText + textarea.value.substring(endPos);
                textarea.selectionStart = startPos + clipboardText.length;
                textarea.selectionEnd = startPos + clipboardText.length;
                $('#text').focus();
            });
        }

        function initProgressBar(duration) {
            progressBarInterval = setInterval(() => {
                progessBarTimeElapsed += 1;
                // var duration = 40;
                updateProgressBar(duration);
            }, 1000);
        }

        function updateProgressBar(duration) {
            recordingProgress = (progessBarTimeElapsed / duration) * 100;

            document.getElementById("recording-progress").setAttribute("aria-valuenow", recordingProgress.toFixed(2));
            document.getElementById("recording-progress").style.width = recordingProgress.toFixed(2) + "%";

            if (progessBarTimeElapsed >= duration) {
                clearInterval(progressBarInterval);
                document.getElementById("record-prepare-text").textContent = "Recorded";
                // stopAudioRecording();
            }
        }

        function startExamTimer(duration) {
            let timeRemaining = duration;

            let minutes = Math.floor(timeRemaining / 60);
            let seconds = timeRemaining % 60;
            let timeString = ` / ${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
            document.getElementById("exam-duration").textContent = timeString;

            updateExamTimer(timeRemaining);

            examEndCountDownInterval = setInterval(() => {
                timeRemaining -= 1;

                updateExamTimer(timeRemaining);

                if (timeRemaining <= 0) {
                    // auto submit or submit response then submit part
                    examPortal.markSectionAsComplete();
                    let response = $('[name=response]').val();
                    if (response.length > 0) {
                        appSubmitResponse();
                    }else{
                        next();
                    }
                }
            }, 1000);
        }

        function updateExamTimer(timeRemaining) {

            const examMinutes = Math.floor(timeRemaining / 60);
            const examSeconds = timeRemaining % 60;

            const timeString = `${examMinutes.toString().padStart(2, "0")}:${examSeconds.toString().padStart(2, "0")}`;
            // const timeString = `${seconds.toString()}`;

            document.getElementById("exam-timer").textContent = timeString;
        }

        function stopExam(status, part) {
            clearInterval(examEndCountDownInterval);
            if (status === 2) {
                $('#saveandexitbtn').hide();
                $('#nextbtn').hide();
                $('#question-box').html('<div class="row mt-4"><h1>Part ' + part + ' Completed.</h1><h5 class="mt-4">Click on Start to continue the next Part.</h5></div>');
                $('#start').show();
                saveExam(() => { });
            } else if (status === 0) {
                $('#saveandexitbtn').hide();
                $('#nextbtn').hide();
                $('#question-box').html('<div class="row mt-4"><h1>Test Over!!!</h1></div>');
                submitExam();
            } else if (status === 3) {
                $('#saveandexitbtn').hide();
                $('#nextbtn').hide();
                $('#question-box').html('<div class="row mt-4"><h1>Test Over!!!</h1></div>');
                submitExam();
            }
        }

        function startAudioRecordingPrepareTimer(duration, callback, callbackduration) {
            countdownInterval = null;
            let timeRemaining = duration;

            updateAudioRecordingPrepareTimer(timeRemaining);

            countdownInterval = setInterval(() => {
                timeRemaining -= 1;

                updateAudioRecordingPrepareTimer(timeRemaining);

                if (timeRemaining <= 0) {
                    clearInterval(countdownInterval);
                    countdownInterval = true;
                    document.getElementById("record-prepare-text").textContent = "Recording..";
                    document.getElementById("record-prepare-timer").remove();
                    // initProgressBar(3);
                    callback(callbackduration);
                }
            }, 1000);
        }

        function updateAudioRecordingPrepareTimer(timeRemaining) {

            // const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;

            // const timeString = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
            const timeString = `${seconds.toString()}`;

            document.getElementById("record-prepare-text").textContent = "Recording in: ";
            document.getElementById("record-prepare-timer").textContent = timeString;
        }

        function startAudioPlayTimer(duration, e) {
            audioPlayingCountdownInterval = null;
            let timeRemaining = duration;

            updateAudioPlayTimer(timeRemaining);

            audioPlayingCountdownInterval = setInterval(() => {
                timeRemaining -= 1;

                updateAudioPlayTimer(timeRemaining);

                if (timeRemaining <= 0) {
                    document.getElementById("audio-prepare-text").remove();
                    document.getElementById("audio-prepare-timer").remove();
                    clearInterval(audioPlayingCountdownInterval);
                    e.play();
                    audioprogress();
                }
            }, 1000);
        }

        function updateAudioPlayTimer(timeRemaining) {

            // const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;

            // const timeString = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
            const timeString = `${seconds.toString()}`;

            document.getElementById("audio-prepare-text").textContent = "Starts in: ";
            document.getElementById("audio-prepare-timer").textContent = timeString;
        }

        function ismultiplecheck(id) {
            if ($('#option' + id).is(":checked")) {
                $('#optionSelection' + id).val('1');
            } else {
                $('#optionSelection' + id).val('0');
            }

            let response = $("input[name='optionSelected[]']").map(function () { return $(this).val(); }).get();
            if (response.includes('1')) {
                $('[name="response"]').val(JSON.stringify(response));
            } else {
                $('[name="response"]').val('');
            }
        }

        function issinglecheck(id) {
            var i = 0;

            $(':radio').each(function () {
                i++;
            });

            for (let index = 1; index <= i; index++) {
                $('#optionSelection' + index).val('0');
            }
            if ($('#option' + id).is(":checked")) {
                $('#optionSelection' + id).val('1');
            } else {
                $('#optionSelection' + id).val('0');
            }

            let response = $("input[name='optionSelected[]']").map(function () { return $(this).val(); }).get();
            if (response.includes('1')) {
                $('[name="response"]').val(JSON.stringify(response));
            } else {
                $('[name="response"]').val('');
            }
        }

        function validateblanks() {
            let i = 0;
            let response = $("input[name='blanks[]']").map(function () {
                if ($(this).val() == '') {
                    return blank[i] = '';
                } else {
                    return blank[i] = $(this).val();
                }
                i++;
            }).get();

            if (response.length > 0) {
                $('[name="response"]').val(JSON.stringify(response));
            } else {
                $('[name="response"]').val('');
            }
        }

        function checkblank() {
            let i = 0;
            let response = $("[name='selectOptions[]'] option:selected").map(function () {
                if ($(this).val() == '') {
                    return blank[i] = '';
                } else {
                    return blank[i] = $(this).val();
                }
                i++;
            }).get();

            if (response.length > 0) {
                $('[name="response"]').val(JSON.stringify(response));
            } else {
                $('[name="response"]').val('');
            }
        }

        function checkfibrdblank() {
            var allblanks = document.querySelectorAll('#fib-rd-blanks-container div');
            var blanksdata = [];

            allblanks.forEach((blank) => {
                blanksdata.push(blank.innerText);
            });

            if (blanksdata.length > 0) {
                $('[name="response"]').val(JSON.stringify(blanksdata));
            } else {
                $('[name="response"]').val('');
            }
        }

        function updateROResponse() {
            var totalParagraphs = document.querySelectorAll('.ro-draggable');
            var targetParagraphs = document.querySelectorAll('.ro-target div')
            let newPositions = [];

            if (targetParagraphs.length === totalParagraphs.length) {
                targetParagraphs.forEach((paragraph, index) => {
                    newPositions.push(paragraph.dataset.order);
                });
                $('[name="response"]').val(JSON.stringify(newPositions));
            } else {
                $('[name="response"]').val('');
            }
        }

        function audioprogress() {
            let audioPlayer = document.getElementsByTagName('audio');
            let audioProgressBar = document.getElementById('audio-progress');

            audioPlayer[0].addEventListener('timeupdate', function () {
                let audioProgress = audioPlayer[0].currentTime / audioPlayer[0].duration;
                audioProgressBar.style.width = (audioProgress * 100) + '%';
                audioProgressBar.setAttribute("aria-valuenow", (audioProgress * 100));
            });
        }
        // ---------------------------  record rtc recording | start -----------------------


        function initAudioRecording(duration) {
            var recordingPlayer = document.querySelector('.user-speech');

            if ($('#model').val() != 'answer_questions' && $('#model').val() != 'repeat_sentences') {
                var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                var oscillator = audioCtx.createOscillator();
                oscillator.type = 'sine';
                oscillator.frequency.value = 1200; // value in hertz
                oscillator.connect(audioCtx.destination);
                oscillator.start();

                setTimeout(function () {
                    oscillator.stop();
                }, 300);
            }

            captureAudio(commonConfig);
            record.mediaCapturedCallback = function () {
                record.recordRTC = RecordRTC(record.stream, {
                    type: 'audio',
                    mimeType: 'audio/wav',
                    recorderType: StereoAudioRecorder,
                    // sampleRate: 44100,
                    bufferSize: 0,
                    numberOfAudioChannels: 1,
                });

                record.recordingEndedCallback = function (url) {
                    // var audio = new Audio();
                    // audio.src = url;
                    // audio.preload = false;
                    // audio.controls = true;
                    // recordingPlayer.parentNode.appendChild(document.createElement('br'));
                    // recordingPlayer.parentNode.appendChild(audio);

                    // audio.onended = function() {
                    //     audio.pause();
                    //     audio.src = URL.createObjectURL(record.recordRTC.blob);
                    // };
                };

                initProgressBar(duration);
                record.recordRTC.startRecording();

                record.recordRTC.setRecordingDuration(duration * 1000).onRecordingStopped(function (url) {
                    record.recordingEndedCallback(url);
                    // clearProgressBar();
                    // console.log('auto-stop')
                    if (browser !== "Safari")
                        uploadUserAnswerToServer(record.recordRTC);
                });
            };
        }

        function stopStream() {
            if (record.stream && record.stream.stop) {
                record.stream.stop();
                record.stream = null;
            }
        }

        function stopAudioRecording() {
            if (record.recordRTC) {
                if (record.recordRTC.state == "stopped") {
                    uploadUserAnswerToServer(record.recordRTC);
                    return;
                }
                if (record.recordRTC.length) {
                    record.recordRTC[0].stopRecording(function (url) {
                        if (!record.recordRTC[1]) {
                            record.recordingEndedCallback(url);
                            stopStream();

                            uploadUserAnswerToServer(record.recordRTC[0]);
                            return;
                        }

                        record.recordRTC[1].stopRecording(function (url) {
                            record.recordingEndedCallback(url);
                            stopStream();
                        });
                    });
                }
                else {
                    record.recordRTC.stopRecording(function (url) {
                        record.recordingEndedCallback(url);
                        stopStream();
                        // console.log('timer-stop')
                        clearInterval(progressBarInterval);
                        clearInterval(countdownInterval);
                        uploadUserAnswerToServer(record.recordRTC);
                    });
                }
            }
            return false;
        }


        var commonConfig = {
            onMediaCaptured: function (stream) {
                record.stream = stream;
                if (record.mediaCapturedCallback) {
                    record.mediaCapturedCallback();
                }
            },
            onMediaStopped: function () { },
            onMediaCapturingFailed: function (error) {
                $('.audio-error-container').removeClass('d-none')
                $('.recorder-container').addClass('d-none');

                console.log(error);
                if (error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                    InstallTrigger.install({
                        'Foo': {
                            // https://addons.mozilla.org/firefox/downloads/latest/655146/addon-655146-latest.xpi?src=dp-btn-primary
                            URL: 'https://addons.mozilla.org/en-US/firefox/addon/enable-screen-capturing/',
                            toString: function () {
                                return this.URL;
                            }
                        }
                    });
                }

                commonConfig.onMediaStopped();
            }
        };

        function captureAudio(config) {
            captureUserMedia({ audio: true }, function (audioStream) {
                // recordingPlayer.srcObject = audioStream;
                config.onMediaCaptured(audioStream);

                audioStream.onended = function () {
                    config.onMediaStopped();
                };
            }, function (error) {
                config.onMediaCapturingFailed(error);
            });
        }

        function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
            navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
        }

        function uploadUserAnswerToServer(recordRTC) {
            uploadToServer(recordRTC, function (progress, fileURL) {
                // console.log(progress);
            });
        }

        function uploadToServer(recordRTC, callback) {
            showLoading();
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash

            var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
            var fileType = blob.type.split('/')[0] || 'audio';
            var fileName = (Math.random() * 1000).toString().replace('.', '');

            if (fileType === 'audio') {
                fileName += '.wav';
            }
            // create FormData
            var formData = new FormData();
            formData.append(fileType + '-filename', fileName);
            formData.append(fileType + '-blob', blob);
            formData.append([csrfName], csrfHash);
            formData.append('testType', $('#model').val());

            callback('Uploading ' + fileType + ' recording to server.');

            var upload_url = siteUrl + 'user/uploadSpeech';
            var upload_directory = 'uploads/';

            makeXMLHttpRequest(upload_url, formData, function (progress) {
                if (progress !== 'upload-ended') {
                    callback(progress);
                    return;
                }

                callback('ended', upload_directory + fileName);
            });
        }

        function makeXMLHttpRequest(url, data, callback) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    callback('upload-ended');
                }
            };

            request.upload.onloadstart = function () {
                callback('Upload started...');
            };

            request.upload.onprogress = function (event) {
                callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
            };

            request.upload.onload = function () {
                callback('progress-about-to-end');
            };

            request.upload.onload = function () {
                callback('progress-ended');
            };

            request.upload.onerror = function (error) {
                callback('Failed to upload to server');
                showLoading('Failed to upload response');
                console.error('XMLHttpRequest failed', error);
            };

            request.upload.onabort = function (error) {
                callback('Upload aborted.');
                showLoading('Upload aborted');
                console.error('XMLHttpRequest aborted', error);
            };

            request.onreadystatechange = () => {
                if (request.readyState === 4 && request.status == 200) {
                    var data = JSON.parse(request.response)
                    $('.csrfToken').val(data.token);
                    $('[name=response]').val(data.path);
                    hideLoading();
                    submitresponse();
                } else if (request.status == 500) {
                    showLoading('Failed to upload response');
                }
            }

            request.open('POST', url);
            request.send(data);
        }

        function showLoading($message = "Loading") {
            if ($('#modal-loading').data('bs.modal')?.isShown) {
                setLoadingMessage($message);
            } else {
                $("#loader-message").text($message);
                $('#modal-loading').modal('show');
            }
        }

        function hideLoading() {
            $('#modal-loading').modal('hide');
        }

        function setLoadingMessage($message = "Loading") {
            $("#loader-message").text($message);
        }
        // ---------------------------------- end -----------------------------------------


        class MockTest {
            constructor(questionData) {
                this.mockSeries = questionData.series;
                this.mockTestId = questionData.mock_test_id;
                this.mockTestType = questionData.mock_test_type;
                this.listeningQuestions = questionData.listening;
                this.readingQuestions = questionData.reading;
                this.speakingQuestions = questionData.speaking;
                this.writingQuestions = questionData.writing;

                this.speakingDuration = questionData.speakingDuration;
                this.readingDuration = questionData.readingDuration;
                this.writingDuration = questionData.writingDuration;
                this.listeningDuration = questionData.listeningDuration;

                this.countSpeakingQuestions = questionData?.counts?.speaking;
                this.countReadingQuestions = questionData?.counts?.reading;
                this.countWritingQuestions = questionData?.counts?.writing;
                this.countListeningQuestions = questionData?.counts?.listening;

                this.attempted = 0;
                this.totalQuestions = 0;
                this.currentCategoryDuration = 0;
                this.currentCategory = questionData.startCategory;
                this.previousModelId;
                this.previousCategory;
                this.resume = questionData.resume ? questionData.resume : false;
                this.over = false;
            }

            getNextQuestion() {
                if (this.currentCategory === 'speaking') {
                    if (this.speakingQuestions.length == 0) {
                        if (this.mockTestType != 'full-test' && this.speakingQuestions.length == 0) {
                            return { status: 3, part: null };
                        }
                        this.currentCategoryDuration = this.writingDuration;
                        clearInterval(examEndCountDownInterval);
                        startExamTimer(this.currentCategoryDuration - 1);
                        this.currentCategory = 'writing';
                    } else {
                        this.previousModelId = this.speakingQuestions.shift();
                        this.previousCategory = 'speaking';
                        return { status: 1, modelId: this.previousModelId, category: 'speaking' };
                    }
                }

                if (this.currentCategory === 'writing') {
                    if (this.writingQuestions.length == 0) {
                        if (this.mockTestType != 'full-test' && this.writingQuestions.length == 0) {
                            return { status: 3, part: null };
                        }
                        this.currentCategory = 'reading';
                        // if(this.resume){
                        //     clearInterval(examEndCountDownInterval);
                        //     saveExam(()=>{});
                        // }else{
                        return { status: 2, part: 'A' };
                        // }
                    } else {
                        this.previousModelId = this.writingQuestions.shift();
                        this.previousCategory = 'writing';
                        return { status: 1, modelId: this.previousModelId, category: 'writing' };
                    }
                }

                if (this.currentCategory === 'reading') {
                    if (this.readingQuestions.length == 0) {
                        if (this.mockTestType != 'full-test' && this.readingQuestions.length == 0) {
                            return { status: 3, part: null };
                        }
                        this.currentCategory = 'listening';
                        // if(this.resume){
                        //     clearInterval(examEndCountDownInterval);
                        //     saveExam(()=>{});
                        // }else{
                        return { status: 2, part: 'B' };
                        // }
                    } else {
                        this.previousModelId = this.readingQuestions.shift();
                        this.previousCategory = 'reading';
                        return { status: 1, modelId: this.previousModelId, category: 'reading' };
                    }
                }

                if (this.currentCategory === 'listening') {
                    if (this.listeningQuestions.length == 0) {
                        if (this.mockTestType != 'full-test' && this.listeningQuestions.length == 0) {
                            return { status: 3, part: null };
                        }
                        this.currentCategory = null;
                        return { status: 0, part: 'D' };
                    } else {
                        this.previousModelId = this.listeningQuestions.shift();
                        this.previousCategory = 'listening';
                        return { status: 1, modelId: this.previousModelId, category: 'listening' };
                    }
                }
            }

            markSectionAsComplete(){
                switch (this.currentCategory) {
                    case 'speaking':
                        this.speakingQuestions.length = 0;
                        break;
                    case 'writing':
                        this.writingQuestions.length = 0;
                        break;
                    case 'reading':
                        this.readingQuestions.length = 0;
                        break;
                    case 'listening':
                        this.listeningQuestions.length = 0;
                        break;
                }
            }

            getProgress() {
                switch (this.previousCategory) {
                    case 'speaking':
                        this.totalQuestions = this.countSpeakingQuestions;
                        this.attempted = this.countSpeakingQuestions - this.speakingQuestions.length;
                        return Math.round((this.attempted / this.countSpeakingQuestions) * 100);
                        break;
                    case 'writing':
                        this.totalQuestions = this.countWritingQuestions;
                        this.attempted = this.countWritingQuestions - this.writingQuestions.length;
                        return Math.round((this.attempted / this.countWritingQuestions) * 100);
                        break;
                    case 'reading':
                        this.totalQuestions = this.countReadingQuestions;
                        this.attempted = this.countReadingQuestions - this.readingQuestions.length;
                        return Math.round((this.attempted / this.countReadingQuestions) * 100);
                        break;
                    case 'listening':
                        this.totalQuestions = this.countListeningQuestions;
                        this.attempted = this.countListeningQuestions - this.listeningQuestions.length;
                        return Math.round((this.attempted / this.countListeningQuestions) * 100);
                        break;
                }
            }
        }

        function next() {
            let next = examPortal.getNextQuestion();
            // console.log(next);
            clearInterval(progressBarInterval);
            clearInterval(countdownInterval);

            if (next.status === 0 || next.status === 2 || next.status === 3) {
                stopExam(next.status, next.part);
                return;
            }
            showLoading();
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: siteUrl + "mock/next",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: { [csrfName]: csrfHash, category: next.category, modelId: next.modelId },
                success: function (data) {
                    let progress = examPortal.getProgress();
                    $('.csrfToken').val(data.token);
                    $('#question-box').html(data.view);

                    document.getElementById("exam-progress").setAttribute("aria-valuenow", progress);
                    document.getElementById("exam-progress").style.width = progress + "%";

                    $('#attempted').text('Question ' + examPortal.attempted + ' of ' + examPortal.totalQuestions);
                },
                complete: function (data) {
                    hideLoading();
                }
            })
        }

        function validateresponse() {
            let category = $('#category').val();
            let response = $('[name=response]').val();
            if (category === 'speaking') {
                if (countdownInterval !== true) {
                    $('#alert-modal').modal('show');
                    return false;
                }

                $("#confirm-modal").modal('show');
                modalConfirm(function (confirm) {
                    if (confirm) {
                        stopAudioRecording();
                    }
                });
            } else {

                let audio = document.getElementsByTagName('audio');
                if (audio[0]) {
                    let isAudioPlaying = audio[0].paused;
                    if (!isAudioPlaying) {
                        $('#alert-modal').modal('show');
                        return false;
                    }
                }

                let response = $('[name=response]').val();
                if (!response.length > 0) {
                    $('#alert-modal').modal('show');
                    return false;
                }

                $("#confirm-modal").modal('show');
                modalConfirm(function (confirm) {
                    if (confirm) {
                        submitresponse();
                    }
                });
            }
            return false;
        }


        function appSubmitResponse() {
            showLoading('Submitting response');
            let category = examPortal.previousCategory;
            let modelId = examPortal.previousModelId;
            let response = $('[name=response]').val();
            let model = $('#model').val();

            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            var timer = $('#exam-timer').text();
            var [minutes, seconds] = timer.split(':');
            var minutes_int = parseInt(minutes, 10);
            var seconds_int = parseInt(seconds, 10);
            var timestamp = minutes_int * 60 + seconds_int;

            $.ajax({
                url: siteUrl + "mock/submitresponse",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: { [csrfName]: csrfHash, category: category, model: model, modelId: modelId, response: response, timestamp: timestamp },
                success: function (data) {
                    $('.csrfToken').val(data.token);
                    unloadResourceFilesAndNext(() => next());
                },
                complete: function (data) {
                    hideLoading();
                }
            })
        }


        function start() {
            $('#start').hide();
            if(examPortal.mockTestType != "full-test"){
                $('#saveandexitbtn').show();
            }
            $('#nextbtn').show();
            $('.timer').removeClass('d-none');

            if (examPortal.currentCategory === 'speaking') {
                examPortal.currentCategoryDuration = examPortal.speakingDuration;
            }
            if (examPortal.currentCategory === 'writing') {
                examPortal.currentCategoryDuration = examPortal.writingDuration;
            }
            if (examPortal.currentCategory === 'reading') {
                examPortal.currentCategoryDuration = examPortal.readingDuration;
            }
            if (examPortal.currentCategory === 'listening') {
                examPortal.currentCategoryDuration = examPortal.listeningDuration;
            }
            startExamTimer(examPortal.currentCategoryDuration - 1);
            next();
        }

        navigator.mediaDevices.getUserMedia({
            audio: true
        })
            .then(async function (stream) {
                if (browser != "Firefox") {
                    const micPermissionStatus = await navigator.permissions.query({ name: "microphone" });
                    micPermissionStatus.addEventListener("change", micPermissionChangeHandler);
                    if (micPermissionStatus.state == "prompt" || micPermissionStatus.state == "granted") {
                        console.log("permission granted")
                        document.getElementById("blockmicrophone").style.display = "none";
                    }
                }
            })
            .catch(function (err) {
                console.log(err);
                console.log("No microphone found");
                document.getElementById("blockmicrophone").style.display = "block";
            });

        const micPermissionChangeHandler = (e) => {
            checkMicSettings(e.currentTarget);
        }

        function checkMicSettings(micPermissionStatus) {
            if (micPermissionStatus.state == "prompt" || micPermissionStatus.state == "granted") {
                console.log("permission granted")
                document.getElementById("blockmicrophone").style.display = "none";
            }
            if (micPermissionStatus.state == "denied") {
                console.log("permission denied")
                document.getElementById("blockmicrophone").style.display = "block";
            }
        }

        function submitExam() {
            showLoading('Submitting test');
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: siteUrl + "mock/submittest",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: { [csrfName]: csrfHash },
                success: function (data) {
                    $('.csrfToken').val(data.token);
                },
                complete: function (data) {
                    hideLoading();
                }
            })
        }

        function saveExam(callback) {
            showLoading("Saving progress");
            var csrfName = $('.csrfToken').attr('name');
            var csrfHash = $('.csrfToken').val(); // CSRF hash
            $.ajax({
                url: siteUrl + "mock/savetest",
                type: "POST",
                crossDomain: true,
                dataType: 'json',
                cache: false,
                data: { [csrfName]: csrfHash },
                success: function (data) {
                    $('.csrfToken').val(data.token);
                },
                complete: function (data) {
                    hideLoading();
                    callback();
                }
            })
        }

        function saveandexit() {
            $("#saveandexit-confirm-modal").modal('show');
            modalSavenExitConfirm(function (confirm) {
                if (confirm) {
                    saveExam(() => {
                        location.href = siteUrl + "mock/myattempts";
                    });
                }
            });
        }

        function checkBrowser() {
            if ((navigator.userAgent.indexOf("Opera") || navigator.userAgent.indexOf('OPR')) != -1) {
                return 'Opera';
            } else if (navigator.userAgent.indexOf("Edg") != -1) {
                return 'Edge';
            } else if (navigator.userAgent.indexOf("Chrome") != -1) {
                return 'Chrome';
            } else if (navigator.userAgent.indexOf("Safari") != -1) {
                return 'Safari';
            } else if (navigator.userAgent.indexOf("Firefox") != -1) {
                return 'Firefox';
            } else if ((navigator.userAgent.indexOf("MSIE") != -1) || (!!document.documentMode == true)) //IF IE > 10
            {
                return 'IE';
            } else {
                return 'unknown';
            }
        }

        const unloadResourceFilesAndNext = (cb) => {
            var audioElement = document.getElementsByTagName('audio');
            if (audioElement[0]) {
                console.log("unloading resource files")
                audioElement = audioElement[0];
                let isAudioPaused = audioElement.paused;
                if (!isAudioPaused) {
                    audioElement.pause();
                }
                audioElement.removeAttribute('src'); // empty source
                audioElement.parentNode.removeChild(audioElement);
            }
            cb();
        }

        function createThrottleFunction(func, limit) {
            let lastCall = 0;
            return function(...args) {
                const now = Date.now();
                if (now - lastCall >= limit) {
                    lastCall = now;
                    return func.apply(this, args);
                }
            };
        }

        window.addEventListener('beforeunload', function (event) {
            event.preventDefault();
            event.returnValue = '';
        });
    </script>
    <!-- <script src="<?php echo base_url() ?>assets/js/mocktest.js"></script> -->
</body>

</html>