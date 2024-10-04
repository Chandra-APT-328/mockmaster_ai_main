$('#toggle-answer').change(function(){
    $('.answer-card').toggleClass('d-none');
});

function startTimer(min, sec){
    var deadline = new Date().getTime() + (1000 * 60 * parseInt(min)) + (1000 * parseInt(sec));
    var x = setInterval(function() {
    var now = new Date().getTime();
    var t = deadline - now;
    var minutes = Math.floor((t % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((t % (1000 * 60)) / 1000);
    document.getElementById("timer").innerHTML = minutes + "m " + seconds + "s ";
        if (t < 0) {
            clearInterval(x);
            document.getElementById("timer").innerHTML = "Time Over";
        }
    }, 1000);
}

counter = function () {
    var value = $("#answerText").val();
  
    if (value.length == 0) {
        $("#wordCount").html(0);
        return;
    }

    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, " ").split(" ").length;

    $("#wordCount").html(wordCount);
};
  
$(document).ready(function(){
    $("#answerText").change(counter);
    $("#answerText").keydown(counter);
    $("#answerText").keypress(counter);
    $("#answerText").keyup(counter);
    $("#answerText").blur(counter);
    $("#answerText").focus(counter);
});