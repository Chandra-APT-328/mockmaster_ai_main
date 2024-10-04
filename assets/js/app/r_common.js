var timeElapsed = 0; 
var timerInterval = null; 

$(document).ready(function(){
    try{
        if(_showing_previous_answer){
        }else{
            startTimer();
        }
    }catch(e){
        startTimer();
    }
});

function startTimer() { 
    document.getElementById("timer-label").textContent = "Time: ";
    document.getElementById("timer").textContent = "0m : 0s";
    timerInterval = setInterval(updateTimer, 1000);
}

function updateTimer() {
    timeElapsed++;
    const minutes = Math.floor(timeElapsed / 60);
    const seconds = timeElapsed % 60;
    document.getElementById("timer").textContent = `${minutes.toString().padStart(1, "0")}m : ${seconds.toString().padStart(1, "0")}s`;
}

function toogleTips(){
    $('#tipsModel').modal('show');
}

$('[name="redo"]').click(function(e){
    clearInterval(timerInterval);
    timeElapsed = 0;
    resetPage();
});