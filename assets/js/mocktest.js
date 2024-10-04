// const hiwsSelectedWords = [];
let recordingProgress = 0;
var progressBarInterval = null;
let progessBarTimeElapsed = 0;
let record = this;
// const recordingProgressBar = document.getElementById("recording-progress");

$(document).ready(function(){
    startExamTimer(3360);
    //   $("#count").click(counter);
      $("#text").change(counter);
      $("#text").keydown(counter);
      $("#text").keypress(counter);
      $("#text").keyup(counter);
      $("#text").blur(counter);
      $("#text").focus(counter);
});
    
counter = function () {
  var value = $("#text").val();

  if (value.length == 0) {
    $("#wordCount").html(0);
    return;
  }

  var regex = /\s+/gi;
  var wordCount = value.trim().replace(regex, " ").split(" ").length;

  $("#wordCount").html(wordCount);
};


// $('#back-to-pte').click(function(){
//     let siteUrl = $('#baseurl').val();
//     location.href = siteUrl+"user/home";
// });


// $('#hiws span').click( 
//     function() { 
//         $(this).toggleClass("highlight");

//         var word = this.innerText;
//         if(hiwsSelectedWords.includes(word)) {
//             hiwsSelectedWords.splice(hiwsSelectedWords.indexOf(word),1);
//         } else {
//             hiwsSelectedWords.push(word);
//             $("#submit").prop('disabled', false);
//         }
        
//         if(hiwsSelectedWords.length == 0){
//             $("#submit").prop('disabled', true);
//         }
//     }
// );

// $('#hiwsform').submit(function(e){
//     ($('[name="selections"]').val(JSON.stringify(hiwsSelectedWords)));
// })

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
    navigator.clipboard.readText().then(function(clipboardText) {
        var startPos = textarea.selectionStart;
        var endPos = textarea.selectionEnd;
        textarea.value = textarea.value.substring(0, startPos) + clipboardText + textarea.value.substring(endPos);
        textarea.selectionStart = startPos + clipboardText.length;
        textarea.selectionEnd = startPos + clipboardText.length;
        $('#text').focus();
    });
}

// function audiorecordingpreparetimer(){
//     var deadline = new Date().getTime() + (1000 * 5);
//     var now = new Date().getTime();

//     document.getElementById("record-prepare-text").innerText = "Recording in: ";

//     preparetimer = setInterval(() => {
//         var t = deadline - now;
//         var seconds = Math.floor((t % (1000 * 60)) / 1000);

//         document.getElementById("record-prepare-timer").innerText = seconds + "s ";

//         if (t < 1000) {
//             clearInterval(preparetimer);
//             document.getElementById("record-prepare-text").innerText = "Recording..";
//             document.getElementById("record-prepare-timer").remove();
//             initProgressBar(40);
//         }

//     }, 1000);
// }

// function audiorecordingtimer(){
//     alert('Continue');

//     var deadline = new Date().getTime() + (1000 * 42);
//     recordingtimer = setInterval(function() {
//         var now = new Date().getTime();
//         var t = deadline - now;
//         var seconds = Math.floor((t % (1000 * 60)) / 1000);
//         document.getElementById("recording-progress").style.color = seconds + "s ";
//         if (t < 1000) {
//             clearInterval(recordingtimer);
//             console.log('recording time over..');
//         }
//     }, 1000);
// }

function initProgressBar(duration){
    // console.log($('.csrfToken').attr('name'))
    progressBarInterval = setInterval(() => {
    progessBarTimeElapsed += 1;
    // var duration = 40;
    // console.log('start')
    updateProgressBar(duration);
    }, 1000);
}


function updateProgressBar(duration) {
    recordingProgress = (progessBarTimeElapsed / duration) * 100;

    document.getElementById("recording-progress").setAttribute("aria-valuenow", recordingProgress.toFixed(2));
    document.getElementById("recording-progress").style.width = recordingProgress.toFixed(2) + "%";
    
    if (progessBarTimeElapsed >= duration) {
        // console.log('stop')
        clearInterval(progressBarInterval);
        document.getElementById("record-prepare-text").textContent = "Recorded";
        // stopAudioRecording();
    }
}

function clearProgressBar(){
    clearInterval(progressBarInterval);
}

function startExamTimer(duration){
    let timeRemaining = duration;
  
    let minutes = Math.floor(timeRemaining / 60);
    let seconds = timeRemaining % 60;
    let timeString = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
    document.getElementById("exam-duration").textContent = timeString;

    updateExamTimer(timeRemaining);
  
    const examEndCountDownInterval = setInterval(() => {
      timeRemaining -= 1;

      updateExamTimer(timeRemaining);
  
      if (timeRemaining <= 0) {
        clearInterval(examEndCountDownInterval);
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



function startAudioRecordingPrepareTimer(duration) {

    let timeRemaining = duration;
  
    updateAudioRecordingPrepareTimer(timeRemaining);
  
    const countdownInterval = setInterval(() => {
      timeRemaining -= 1;

      updateAudioRecordingPrepareTimer(timeRemaining);
  
      if (timeRemaining <= 0) {
        clearInterval(countdownInterval);
        document.getElementById("record-prepare-text").textContent = "Recording..";
        document.getElementById("record-prepare-timer").remove();
        // initProgressBar(3);
        initAudioRecording(3);
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




  // ---------------------------  record rtc recording | start -----------------------


function initAudioRecording(duration){
    // if(!confirm('Continue ?')){return};
    // console.log(this)
    // resume()
    var recordingPlayer = document.querySelector('.user-speech');

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
            sampleRate: 44100,
            bufferSize: 0,
            numberOfAudioChannels: 1,
        });

        record.recordingEndedCallback = function(url) {
            var audio = new Audio();
            audio.src = url;
            audio.preload = false;
            // audio.class = 'audio';
            audio.controls = true;
            // recordingPlayer.innerHTML = "";
            recordingPlayer.parentNode.appendChild(document.createElement('br'));
            recordingPlayer.parentNode.appendChild(audio);
            // $('.user-speech').html(audio);
            // $('[name=studentAnswer]').val(url);
            // if(audio.paused) audio.play();
            
            audio.onended = function() {
                audio.pause();
                audio.src = URL.createObjectURL(record.recordRTC.blob);
            };
        };

        initProgressBar(duration);
        record.recordRTC.startRecording();

        record.recordRTC.setRecordingDuration(duration*1000).onRecordingStopped(function(url) {
                record.recordingEndedCallback(url);
                // clearProgressBar();
                console.log('auto-stop')
                // uploadUserAnswerToServer(record.recordRTC);
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
                console.log('timer-stop')
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

        // record.querySelector("span").textContent = 'Stop';
        // $('.audioMic').css('color','red');
        // $('#record').css('color','red');
    },
    onMediaStopped: function() {
        // record.querySelector("span").textContent = 'Start';
    },
    onMediaCapturingFailed: function(error) {
        $('.audio-error-container').removeClass('d-none')
        $('.recorder-container').addClass('d-none');
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
    // console.log(recordRTC);
    uploadToServer(recordRTC, function(progress, fileURL) {
        console.log(progress);
    });
}

// var listOfFilesUploaded = [];

function uploadToServer(recordRTC, callback) {
    var csrfName = $('.csrfToken').attr('name'); 
    var csrfHash = $('.csrfToken').val(); // CSRF hash
    // var csrfName = 'bd84b2000a35802d88d80ff6026ac032'; 
    // var csrfHash = '62267a6a932c5d0b44ea2b2ad96824cd'; // CSRF hash

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
    
    
    callback('Uploading ' + fileType + ' recording to server.');
    
    // var upload_url = 'https://your-domain.com/files-uploader/';
    var upload_url = siteUrl+'user/uploadSpeech/';

    // console.log(upload_url);

    // var upload_directory = upload_url;
    var upload_directory = 'uploads/';

    makeXMLHttpRequest(upload_url, formData, function(progress) {
        if (progress !== 'upload-ended') {
            callback(progress);
            return;
        }

        callback('ended', upload_directory + fileName);

        // to make sure we can delete as soon as visitor leaves
        // listOfFilesUploaded.push(upload_directory + fileName);
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
            // $('.csrfToken').val(data.token);
            var data = JSON.parse(request.response)
        }
    }

    request.open('POST', url);
    request.send(data);
}

  // ---------------------------------- end -----------------------------------------


