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

$('#toggle-answer').change(function(){
    $('.answer-card').toggleClass('d-none');
});

function startTimer(min, sec){
    var deadline = new Date().getTime() + (1000 * 60 * parseInt(min)) + (1000 * parseInt(sec));
    document.getElementById("timer-label").innerHTML = "Remain: ";
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

function prepareTimer(min, sec, myCallback){
    var deadline = new Date().getTime() + (1000 * 6);
    document.getElementById("timer-label").innerHTML = "Prepare: ";
    var x = setInterval(function() {
    var now = new Date().getTime();
    var t = deadline - now;
    var seconds = Math.floor((t % (1000 * 60)) / 1000);
    document.getElementById("timer").innerHTML = seconds + "s ";
        if (t < 1000) {
            clearInterval(x);
            document.getElementById('questionAudio').play();
            myCallback(min, sec);
        }
    }, 1000);
}

function checkResults(id,answerId){
    var csrfName = $('.csrfToken').attr('name'); 
    var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: siteUrl+"user/getuseranswer",    
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,         
            data: {answer:answerId,[csrfName]:csrfHash,model:'listening'},
            success: function(data) {
                data = JSON.parse(JSON.stringify(data));
                $('.csrfToken').val(data.token); 
                $('.myScore').text(data.result.score);
                $('.content').text(data.result.component_score.content);
                $('._form').text(data.result.component_score.form);
                $('.grammar').text(data.result.component_score.grammar);
                $('.spelling').text(data.result.component_score.spelling);
                $('.vocabulary').text(data.result.component_score.vocabulary); 
                $('.user-response').html(data.result.mistakes); 
                $("[data-toggle=popover]").popover();
            }

        })
    $('#resultModal').modal('show');
}

const clearAllIntervals = () => {
    // Get a reference to the last interval + 1
    const interval_id = window.setInterval(function(){}, Number.MAX_SAFE_INTEGER);

    // Clear any timeout/interval up to that id
    for (let i = 1; i < interval_id; i++) {
    window.clearInterval(i);
    }
}

function toogleTips(invoker){
    if(invoker == 'content'){
        $('.tip-score-guide').html("2 Provides a good summary of the text. All relevant aspects are mentioned<br>\
            1 Provides a fair summary of the text, but one or two aspects are missing<br>\
            0 Omits or misrepresents the main aspects");

        $('.tip-suggestion').html("In most cases, one SST passage contains around 5 - 6 key points.");
    }

    if(invoker == 'form'){
        $('.tip-score-guide').html("2 Contains 50-70 words<br>\
            1 Contains 40-49 words or 71-100 words<br>\
            0 Contains less than 40 words or more than 100 words. Summary is written in capital letters, contains no punctuation or consists only of bullet points or very short sentences");

        $('.tip-suggestion').html("You MUST get these two marks! You will get them simply by writing your answer within 50 - 70 words. There is no additional requirement.");
    }

    if(invoker == 'grammar'){
        $('.tip-score-guide').html("2 Has correct grammatical structure<br>\
            1 Contains grammatical errors but with no hindrance to communication<br>\
            0 Has defective grammatical structure which could hinder communication");

        $('.tip-suggestion').html("2 marks of grammar cannot be neglected. It is not worthy if you include a lot of key points in your answer but make many grammar mistakes.");
    }

    if(invoker == 'spelling'){
        $('.tip-score-guide').html("2 Correct spelling<br>\
            1 One spelling error<br>\
            0 More than one spelling error");

        $('.tip-suggestion').html("Spelling is very important. 1 mark will be deducted for each spelling error. So check your spelling carefully!");
    }

    if(invoker == 'vocabulary'){
        $('.tip-score-guide').html("2 Has appropriate choice of words<br>\
            1 Contains lexical errors but with no hindrance to communication<br>\
            0 Has defective word choice which could hinder communication");

        $('.tip-suggestion').html("You're not required to paraphrase. But do not make collocation errors.");
    }
    $('#tipsModel').modal('show');
}