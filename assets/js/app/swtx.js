function checkResults(id,answerId){
    var csrfName = $('.csrfToken').attr('name'); 
    var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: siteUrl+"user/getuseranswer",    
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,         
            data: {answer:answerId,[csrfName]:csrfHash,model:'writing'},
            success: function(data) {
                data = JSON.parse(JSON.stringify(data));
                $('.csrfToken').val(data.token); 
                $('.myScore').text(data.result.score);
                $('.content').text(data.result.component_score.content);
                $('._form').text(data.result.component_score.form);
                $('.grammar').text(data.result.component_score.grammar);
                $('.vocabulary').text(data.result.component_score.vocabulary); 
                $('.user-response').html(data.result.mistakes); 
                $("[data-toggle=popover]").popover();
            }
        })
    $('#resultModal').modal('show');
}

function toogleTips(invoker){
    if(invoker == 'content'){
        $('.tip-score-guide').html("2 Provides a good summary of the text. All relevant aspects are mentioned<br>\
            1 Provides a fair summary of the text, but one or two aspects are missing<br>\
            0 Omits or misrepresents the main aspects");

        $('.tip-suggestion').html("In most cases, one SST passage contains around 5 - 6 key points.");
    }

    if(invoker == 'form'){
        $('.tip-score-guide').html("1 Is written in one, single, complete sentence<br>\
            0 Not written in one, single, complete sentence or contains fewer than 5 or more than 75 words.<br>\
            Summary is written in capital letters");

        $('.tip-suggestion').html("You MUST get this one mark! The answer has to be within 5 - 75 words, and there has to be only one full stop. Please note that if there is more than one full stop in your answer, you will be marked 0 not only for Form, but also for Spelling and Grammar.");
    }

    if(invoker == 'grammar'){
        $('.tip-score-guide').html("2 Has correct grammatical structure<br>\
            1 Contains grammatical errors but with no hindrance to communication<br>\
            0 Has defective grammatical structure which could hinder communication");

        $('.tip-suggestion').html("Many people tend to ignore grammar and place too much emphasis on content. 2 marks of grammar cannot be neglected, and they are not hard to obtain. Take time to check your answer before submitting.");
    }

    if(invoker == 'vocabulary'){
        $('.tip-score-guide').html("2 Has appropriate choice of words<br>\
            1 Contains lexical errors but with no hindrance to communication<br>\
            0 Has defective word choice which could hinder communication");

        $('.tip-suggestion').html("PTE demands \"appropriate choice of words\" in regard to vocabulary. So using original words from the passage does not affect your score; it's not necessary to paraphrase!");
    }
    $('#tipsModel').modal('show');
}