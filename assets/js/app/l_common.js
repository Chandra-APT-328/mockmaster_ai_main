var timeElapsed = 0;
var timerInterval = null; 
var prepareInterval = null; 
$(document).ready(function(){
    try{
        Audio.prototype.play = (function(play) {
            return function () {
                var audio = this,
                    args = arguments,
                    promise = play.apply(audio, args);
                if (promise !== undefined) {
                promise.catch(_ => {
                    console.log('User need to interact first to autoplay audio');
                });
                }
            };
        })(Audio.prototype.play);
        
        if(!_showing_previous_answer){
            startPrepareTimer(3);
        }
    }catch(e){
        Audio.prototype.play = (function(play) {
            return function () {
                var audio = this,
                    args = arguments,
                    promise = play.apply(audio, args);
                if (promise !== undefined) {
                promise.catch(_ => {
                    console.log('User need to interact first to autoplay audio');
                });
                }
            };
        })(Audio.prototype.play);
        startPrepareTimer(3);
    }
});

function toogleTips(){
    $('#tipsModel').modal('show');
}

function startPrepareTimer(duration) {

    let timeRemaining = duration;

    updatePrepareTimer(timeRemaining);

    prepareInterval = setInterval(() => {
        timeRemaining -= 1;

        updatePrepareTimer(timeRemaining);

        if (timeRemaining <= 0) {
            clearInterval(prepareInterval);
            document.getElementById("timer-label").textContent = "Time: ";
            document.getElementById("timer").textContent = "0m : 0s";
            document.getElementById('questionAudio').play();
            startTimer();
        }
    }, 1000);
}

function updatePrepareTimer(timeRemaining) {

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

$('[name="redo"]').click(function(e){
    timeElapsed = 0;
    clearInterval(prepareInterval);
    clearInterval(timerInterval);
    timerInterval = null; 
    prepareInterval = null;
    document.getElementsByTagName('audio')[0].pause();
    document.getElementsByTagName('audio')[0].currentTime = 0;
    resetPage();
});