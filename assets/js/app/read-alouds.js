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
        startAudioRecordingPrepareTimer(25,initAudioRecording,recordDuration);
    }
});

var button = document.getElementById("record");
const redo = document.getElementById("redo");
var recordingProgress = 0;
var progressBarInterval = null;
var prepareInterval = null;
var timerInterval = null;
var progessBarTimeElapsed = 0;
var timeElapsed = 0;
var record = this;
var recordDuration = 37;

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

function toogleTips(invoker){
    if(invoker == 'content'){
        $('.tip-score-guide').html("Each replacement, omission or insertion of a word counts as one error");
        $('.tip-suggestion').html("When you encounter unfamiliar or difficult words in the exam which may influence your fluency, you can choose to skip those words or replace them with other words (for example 'something'). The same score will be deducted no matter which option you take. It depends on you: just choose the most comfortable way to ensure your fluency.");
    }
    if(invoker == 'pronunciation'){
        $('.tip-score-guide').html("5 All vowels and consonants are produced in a manner that is easily understood by regular speakers of the language. The speaker uses assimilation and deletions appropriate to continuous speech. Stress is placed correctly in all words and sentence-level stress is fully appropriate<br>\
        4 Vowels and consonants are pronounced clearly and unambiguously. A few minor consonant, vowel or stress distortions do not affect intelligibility. All words are easily understandable. A few consonants or consonant sequences may be distorted. Stress is placed correctly on all common words, and sentence level stress is reasonable<br>\
        3 Most vowels and consonants are pronounced correctly. Some consistent errors might make a few words unclear. A few consonants in certain contexts may be regularly distorted, omitted or mispronounced. Stress-dependent vowel reduction may occur on a few words<br>\
        2 Some consonants and vowels are consistently mispronounced in a non-native like manner. At least 2/3 of speech is intelligible, but listeners might need to adjust to the accent. Some consonants are regularly omitted, and consonant sequences may be simplified. Stress may be placed incorrectly on some words or be unclear<br>\
        1 Many consonants and vowels are mispronounced, resulting in a strong intrusive foreign accent. Listeners may have difficulty understanding about 1/3 of the words. Many consonants may be distorted or omitted. Consonant sequences may be non-English. Stress is placed in a non-English manner; unstressed words may be reduced or omitted and a few syllables added or missed<br>\
        0 Pronunciation seems completely characteristic of another language. Many consonants and vowels are mispronounced, misordered or omitted. Listeners may find more than 1/2 of the speech unintelligible. Stressed and unstressed syllables are realized in a non-English manner. Several words may have the wrong number of syllables");
        $('.tip-suggestion').html("If you delve into Pearson's scoring rules, you will notice that the scoring of pronunciation tests much more than accurate pronunciation of words. You also need to avoid reading in a monotone or too exaggerative.");
    }
    if(invoker == 'fluency'){
        $('.tip-score-guide').html("5 Speech shows smooth rhythm and phrasing. There are no hesitations, repetitions, false starts or non-native phonological simplifications<br>\
        4 Speech has an acceptable rhythm with appropriate phrasing and word emphasis. There is no more than one hesitation, one repetition or a false start. There are no significant non- native phonological simplifications<br>\
        3 Speech is at an acceptable speed but may be uneven. There may be more than one hesitation, but most words are spoken in continuous phrases. There are few repetitions or false starts. There are no long pauses and speech does not sound staccato<br>\
        2 Speech may be uneven or staccato. Speech (if >= 6 words) has at least one smooth three-word run, and no more than two or three hesitations, repetitions or false starts. There may be one long pause, but not two or more<br>\
        1 Speech has irregular phrasing or sentence rhythm. Poor phrasing, staccato or syllabic timing, and/or multiple hesitations, repetitions, and/or false starts make spoken performance notably uneven or discontinuous. Long utterances may have one or two long pauses and inappropriate sentence-level word emphasis<br>\
        0 Speech is slow and labored with little discernable phrase grouping, multiple hesitations, pauses, false starts, and/or major phonological simplifications. Most words are isolated, and there may be more than one long pause.");
        $('.tip-suggestion').html("Being fluent does not equal to speaking without any pauses. In fact, speaking without any pauses in a monotone will affect your scores negatively. You need to avoid any unnatural pauses, and master skills such as linking of words, tone variations, and sense groups etc.");
    }
    $('#tipsModel').modal('show');
}

redo.addEventListener('click',(event) => {resetPage(event);});

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

function startAudioRecordingPrepareTimer(duration,callback,callbackduration) {

    let timeRemaining = duration;

    updateAudioRecordingPrepareTimer(timeRemaining);

    prepareInterval = setInterval(() => {
        timeRemaining -= 1;

        updateAudioRecordingPrepareTimer(timeRemaining);

        if (timeRemaining <= 0) {
            clearInterval(prepareInterval);
            document.getElementById("timer-label").textContent = "Time: ";
            document.getElementById("timer").textContent = "0";
            startTimer();
            callback(callbackduration);
        }
    }, 1000);
}

function updateAudioRecordingPrepareTimer(timeRemaining) {

    const seconds = timeRemaining % 60;
    const timeString = `${seconds.toString()}`;

    document.getElementById("timer-label").textContent = "Prepare: ";
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
    var recordingPlayer = document.getElementById('user-speech');

    var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    var oscillator = audioCtx.createOscillator();
    oscillator.type = 'sine';
    oscillator.frequency.value = 1200; // value in hertz
    oscillator.connect(audioCtx.destination);
    oscillator.start();

    setTimeout(function(){
    oscillator.stop();
    }, 300);

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
    formData.append('testType', 'read_alouds');
    
    
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
    startAudioRecordingPrepareTimer(25,initAudioRecording,recordDuration);
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