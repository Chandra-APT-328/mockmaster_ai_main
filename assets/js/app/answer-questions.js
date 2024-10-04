(function() {
    var params = {},
        r = /([^&=]+)=?([^&]*)/g;

    function d(s) {
        return decodeURIComponent(s.replace(/\+/g, ' '));
    }

    var match, search = window.location.search;
    while (match = r.exec(search.substring(1))) {
        params[d(match[1])] = d(match[2]);

        if(d(match[2]) === 'true' || d(match[2]) === 'false') {
            params[d(match[1])] = d(match[2]) === 'true' ? true : false;
        }
    }

    window.params = params;
})();

$(document).ready(function(){
    $("#submit").prop('disabled', true);    
    $("#redo").prop('disabled', false);    
    if(!sessionStorage.getItem("redo" + $('#redo').attr('data-id'))){
        $("#redo").prop('disabled', true);    
        startPrepareTimer(3);
    }
});

$('#toggle-answer').change(function(){
    $('.answer-card').toggleClass('d-none');
});

const redo = document.getElementById("redo");
var button = document.getElementById("record");
var recordingProgress = 0;
var progressBarInterval = null;
var timerInterval = null;
var progessBarTimeElapsed = 0;
var timeElapsed = 0;
var record = this;
var recordDuration = 10;

$('#previous').click(function(){
    sessionStorage.removeItem("redo" + $('#redo').attr('data-id'));
    location.href = base_url + $('#previous').attr('data-id');
});

$('#next').click(function(){
    sessionStorage.removeItem("redo" + $('#redo').attr('data-id'));
    location.href = base_url + $('#next').attr('data-id');
});

$('#record').click(function(){
    // button = document.getElementById("record");
    let buttonInnerText = button.innerText.trim();
    if(buttonInnerText === 'Start') {
        clearInterval(prepareInterval);
        document.getElementById("timer-label").textContent = "Time: ";
        startTimer();
        initAudioRecording(recordDuration);
    }
    if(buttonInnerText === 'Stop') {
        // clearInterval(timerInterval);
        stopAudioRecording();
    }
});

redo.addEventListener('click',(event) => {resetPage(event);});

function audioend(){
    clearInterval(prepareInterval);
    document.getElementById("timer-label").textContent = "Time: ";
    document.getElementById("timer").textContent = "0";
    startTimer();
    initAudioRecording(recordDuration);
}

function initProgressBar(duration){
    progressBarInterval = setInterval(() => {
    progessBarTimeElapsed += 1;
    updateProgressBar(duration);
    }, 1000);
}

function updateProgressBar(duration) {
    recordingProgress = (progessBarTimeElapsed / duration) * 100;

    document.getElementById("recording-progress").setAttribute("aria-valuenow", recordingProgress.toFixed(2));
    document.getElementById("recording-progress").style.width = recordingProgress.toFixed(2) + "%";
    
    if (progessBarTimeElapsed >= duration) {
        clearInterval(progressBarInterval);
    }
}

function startPrepareTimer(duration) {

    let timeRemaining = duration;
    updatePrepareTimer(timeRemaining);

    prepareInterval = setInterval(() => {
        timeRemaining -= 1;

        updatePrepareTimer(timeRemaining);

        if (timeRemaining <= 0) {
            clearInterval(prepareInterval);
            document.getElementById("timer").textContent = "";
            document.getElementById("timer-label").textContent = "Recording starts after audio ends..";
            document.getElementById('questionAudio').play();
        }
    }, 1000);
}

function updatePrepareTimer(timeRemaining) {

    const seconds = timeRemaining % 60;
    const timeString = `${seconds.toString()}`;

    document.getElementById("timer-label").textContent = "Starts in: ";
    document.getElementById("timer").textContent = timeString;
}

function startTimer() { timerInterval = setInterval(updateTimer, 1000);}

function updateTimer() {
    timeElapsed++;
    const minutes = Math.floor(timeElapsed / 60);
    const seconds = timeElapsed % 60;
    document.getElementById("timer").textContent = `${minutes.toString().padStart(1, "0")}m : ${seconds.toString().padStart(1, "0")}s`;
}

function initAudioRecording(duration){
    document.getElementById('questionAudio').pause();
    var recordingPlayer = document.getElementById('user-speech');

    // ticket 35
    // var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    // var oscillator = audioCtx.createOscillator();
    // oscillator.type = 'sine';
    // oscillator.frequency.value = 1200; // value in hertz
    // oscillator.connect(audioCtx.destination);
    // oscillator.start();

    // setTimeout(function(){
    // oscillator.stop();
    // }, 300);

    captureAudio(commonConfig);
    record.mediaCapturedCallback = function() {
        record.recordRTC = RecordRTC(record.stream, {
            type: 'audio',
            mimeType: 'audio/wav',
            recorderType: StereoAudioRecorder,
            bufferSize: 0,
            numberOfAudioChannels: 1,
        });

        record.recordingEndedCallback = function(url) {
            var audio = new Audio();
            audio.src = url;
            audio.preload = false;
            audio.controls = true;
            recordingPlayer.classList.remove('d-none');
            recordingPlayer.appendChild(audio);
            
            audio.onended = function() {
                audio.pause();
                audio.src = URL.createObjectURL(record.recordRTC.blob);
            };
        };

        initProgressBar(duration);
        record.recordRTC.startRecording();

        record.recordRTC.setRecordingDuration(duration*1000).onRecordingStopped(function(url) {
                record.recordingEndedCallback(url);
                // console.log('auto-stop')
                uploadUserAnswerToServer(record.recordRTC);

                clearInterval(timerInterval);
                // button = document.getElementById("record");
                button.querySelector("span").textContent = 'Done';
                $('.audioMic').css('color','grey');
                $('#record').css('color','grey');
        });
    };
}

function stopStream() {
    if(record.stream && record.stream.stop) {
        record.stream.stop();
        record.stream = null;
    }
}

function stopAudioRecording(){
    // button = document.getElementById("record");
    button.querySelector("span").textContent = 'Done';
    $('.audioMic').css('color','grey');
    $('#record').css('color','grey');

    if(record.recordRTC) {
        if(record.recordRTC.length) {
            record.recordRTC[0].stopRecording(function(url) {
                if(!record.recordRTC[1]) {
                    record.recordingEndedCallback(url);
                    stopStream();

                    uploadUserAnswerToServer(record.recordRTC[0]);
                    return;
                }

                record.recordRTC[1].stopRecording(function(url) {
                    record.recordingEndedCallback(url);
                    stopStream();
                });
            });
        }
        else {
            record.recordRTC.stopRecording(function(url) {
                record.recordingEndedCallback(url);
                stopStream();

                clearInterval(timerInterval);
                clearInterval(progressBarInterval);
                uploadUserAnswerToServer(record.recordRTC);
            });
        }
    }
    return false;
}
        
            
var commonConfig = {
    onMediaCaptured: function(stream) {
        record.stream = stream;
        if(record.mediaCapturedCallback) {
            record.mediaCapturedCallback();
        }

        // button = document.getElementById("record");
        button.querySelector("span").textContent = 'Stop';
        $('.audioMic').css('color','red');
        $('#record').css('color','red');
    },
    onMediaStopped: function() {
        // button = document.getElementById("record");
        button.querySelector("span").textContent = 'Start';
    },
    onMediaCapturingFailed: function(error) {
        $('.error-container').removeClass('d-none')
        $('.audio-container').addClass('d-none');

        console.log(error);
        if(error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
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
    captureUserMedia({audio: true}, function(audioStream) {
        // recordingPlayer.srcObject = audioStream;
        config.onMediaCaptured(audioStream);

        audioStream.onended = function() {
            config.onMediaStopped();
        };
    }, function(error) {
        config.onMediaCapturingFailed(error);
    });
}

function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
    navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
}

function uploadUserAnswerToServer(recordRTC){
    uploadToServer(recordRTC, function(progress, fileURL) {
        // console.log(progress);
    });
}

function uploadToServer(recordRTC, callback) {
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
    formData.append('testType', 'answer_questions');
    
    callback('Uploading ' + fileType + ' recording to server.');
    
    var upload_url = siteUrl+'user/uploadSpeech';
    var upload_directory = 'uploads/';

    makeXMLHttpRequest(upload_url, formData, function(progress) {
        if (progress !== 'upload-ended') {
            callback(progress);
            return;
        }

        callback('ended', upload_directory + fileName);
    });
}

function makeXMLHttpRequest(url, data, callback) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            callback('upload-ended');
        }
    };

    request.upload.onloadstart = function() {
        callback('Upload started...');
    };

    request.upload.onprogress = function(event) {
        callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
    };

    request.upload.onload = function() {
        callback('progress-about-to-end');
    };

    request.upload.onload = function() {
        callback('progress-ended');
    };

    request.upload.onerror = function(error) {
        callback('Failed to upload to server');
        console.error('XMLHttpRequest failed', error);
    };

    request.upload.onabort = function(error) {
        callback('Upload aborted.');
        console.error('XMLHttpRequest aborted', error);
    };

    request.onreadystatechange = () => {
        if (request.readyState === 4) {
            var data = JSON.parse(request.response)
            $('.csrfToken').val(data.token);
            $('[name=studentAnswer]').val(data.path);
            $("#submit").prop('disabled', false);
            $("#redo").prop('disabled', false);
            sessionStorage.setItem("redo" + $('#redo').attr('data-id'), true);
        }
    }

    request.open('POST', url);
    request.send(data);
}

function toogleTips(invoker){
    if(invoker == 'content'){
        $('.tip-score-guide').html("1 Appropriate word choice in response<br>\
        0 Inappropriate word choice in response");

        $('.tip-suggestion').html("ASQ is the only speaking question that does not score on fluency or pronunciation. You will get one mark as long as you give the correct answer.");
    }
    $('#tipsModel').modal('show');
}

function resetPage(e){
    recordingProgress = 0;
    progressBarInterval = null;
    prepareInterval = null;
    timerInterval = null;
    progessBarTimeElapsed = 0;
    timeElapsed = 0;
    resetMic();
    resetProgressBar();
    resetButtons();
    startPrepareTimer(3);
}

function resetMic(){
    button.querySelector("span").textContent = 'Start';
    $('.audioMic').css('color','green');
    $('#record').css('color','green');
    $('#user-speech').addClass('d-none');
    $('#user-speech').empty();
}

function resetProgressBar(){
    document.getElementById("recording-progress").setAttribute("aria-valuenow", 0);
    document.getElementById("recording-progress").style.width = 0 + "%";
}

function resetButtons(){
    sessionStorage.removeItem("redo" + $('#redo').attr('data-id'));
    $("#submit").prop('disabled', true);
    $("#redo").prop('disabled', true);
}