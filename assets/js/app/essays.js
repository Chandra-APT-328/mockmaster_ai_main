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
                $('.spelling').text(data.result.component_score.spelling);
                $('.vocabulary').text(data.result.component_score.vocabulary); 
                $('.linguistic-range').text(data.result.component_score.linguistic); 
                $('.structure').text(data.result.component_score.structure); 
                $('.user-response').html(data.result.mistakes); 
                $("[data-toggle=popover]").popover();
            }
        })
    $('#resultModal').modal('show');
}

function toogleTips(invoker){
    if(invoker == 'content'){
        $('.tip-score-guide').html("3 Adequately deals with the prompt<br>\
            2 Deals with the prompt but does not deal with one minor aspect<br>\
            1 Deals with the prompt but omits a major aspect or more than one minor aspect<br>\
            0 Does not deal properly with the prompt");

        $('.tip-suggestion').html("You do not need to write fancy arguments, which is a very difficult thing when you only have 20 minutes to complete one essay. However, if there are two topics in one essay question, you have to answer to both of them. Otherwise your content score will be deducted.");
    }

    if(invoker == 'form'){
        $('.tip-score-guide').html("2 Length is between 200 and 300 words<br>\
            1 Length is between 120 and 199 or between 301 and 380 words<br>\
            0 Length is less than 120 or more than 380 words. Essay is written in capital letters, contains no punctuation or only consists of bullet points or very short sentences");

        $('.tip-suggestion').html("You MUST get these two marks! You will get a full mark in form simply by writing your essay within 200 - 300 words. A full mark will be awarded in Form even if you copy and paste part of your essay to meet the 200 words requirement.");
    }
    
    if(invoker == 'grammar'){
        $('.tip-score-guide').html("2 Shows consistent grammatical control of complex language. Errors are rare and difficult to spot<br>\
            1 Shows a relatively high degree of grammatical control. No mistakes which would lead to misunderstandings<br>\
            0 Contains mainly simple structures and/or several basic mistakes");

        $('.tip-suggestion').html("Most people tend to ignore grammar in writing. 2 marks of grammar cannot be neglected, and they are not hard to obtain. It is highly recommended that you give yourself at least 3 minutes to check for grammar and spelling mistakes before submitting.");
    }

    if(invoker == 'spelling'){
        $('.tip-score-guide').html("2 Correct spelling<br>\
            1 One spelling error<br>\
            0 More than one spelling error");

        $('.tip-suggestion').html("Spelling is very important. 1 mark will be deducted for each spelling error. So check your spelling carefully!");
    }

    if(invoker == 'vocabulary'){
        $('.tip-score-guide').html("2 Good command of a broad lexical repertoire, idiomatic expressions and colloquialisms<br>\
        1 Shows a good range of vocabulary for matters connected to general academic topics. Lexical shortcomings lead to circumlocution or some imprecision<br>\
        0 Contains mainly basic vocabulary insufficient to deal with the topic at the required level");

        $('.tip-suggestion').html("Apply our essay template and you can easily get a full mark in this dimension.");
    }
    
    if(invoker == 'linguistic-range'){
        $('.tip-score-guide').html("2 Exhibits smooth mastery of a wide range of language to formulate thoughts precisely, give emphasis, differentiate and eliminate ambiguity. No sign that the test taker is restricted in what they want to communicate<br>\
        1 Sufficient range of language to provide clear descriptions, express viewpoints and develop arguments<br>\
        0 Contains mainly basic language and lacks precision");

        $('.tip-suggestion').html("Apply our essay template and you can easily get a full mark in this dimension.");
    }
    
    if(invoker == 'structure'){
        $('.tip-score-guide').html("2 Shows good development and logical structure<br>\
        1 Is incidentally less well structured, and some elements or paragraphs are poorly linked<br>\
        0 Lacks coherence and mainly consists of lists or loose elements");

        $('.tip-suggestion').html("Apply our essay template and you can easily get a full mark in this dimension.");
    }
    $('#tipsModel').modal('show');
}