var words = document.getElementById("question").innerText.split(" ");
var str = '';
const selectedWords = [];
for (var i = 0; i < words.length; i++) {
    str += '<span>'+words[i]+'</span>';
}

$('#question').html(str);

initListeners();

$('#hiws').submit(function(e){
    $('[name="selections"]').val(JSON.stringify(selectedWords));
    $('[name="formHTML"]').val($('#question').html());
});

$('#toggle-answer').change(function(){
    viewAnswer();
});

function initListeners(){
    $('#question span').click( 
        function() { 
            $(this).toggleClass("highlight");
    
            if($('#toggle-answer').is(':checked')){
    
                var answerVal = $(this).next('.answer-span').find('span').text().trim();
    
                if($(this).hasClass('highlight') && answer.includes(answerVal)){
                    $(this).removeClass('answer-state-missing');
                    $(this).addClass('answer-state-correct');
                    $(this).prepend('<span class="answer-state-correct-marker"><i class="anticon custom-icon " style="font-size: 14px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');
    
                }else if($(this).hasClass('highlight') && !answer.includes(answerVal)){
                    $(this).removeClass('answer-state-missing');
                    $(this).addClass('answer-show answer-state answer-state-missing');
                    $(this).addClass('answer-state-wrong');
                    $(this).prepend('<span class="answer-state-wrong-marker"><i class="anticon custom-icon " style="font-size: 14px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
    
                }else{
                    if(answer.includes(answerVal)){
                        $(this).addClass('answer-state-missing');
                        $(this).removeClass('answer-state-correct');
                        $(this).find('.answer-state-correct-marker').remove();
                    }else{
                        $(this).addClass('answer-state-missing');
                        $(this).removeClass('answer-show answer-state answer-state-missing');
                        $(this).removeClass('answer-state-wrong');
                        $(this).find('.answer-state-wrong-marker').remove();
                    }
                }            
            }
    
            var word = this.innerText;
            if(selectedWords.includes(word)) {
                selectedWords.splice(selectedWords.indexOf(word),1);
            } else {
                selectedWords.push(word);
                $("#submit").prop('disabled', false);
            }
            
            if(selectedWords.length == 0){
                $("#submit").prop('disabled', true);
            }
        }
    );
}

function resetButtons(){
    $('[name="submit"]').prop('disabled', true);
}

function resetAnswerCard(){
    if($('#toggle-answer').is(':checked')){
        $('#toggle-answer').prop("checked",false);
        viewAnswer();
    }
}

function resetPage(){
    selectedWords.length = 0;
    $('.highlight').each(function(i) {
        $(this).removeClass("highlight");
    });
    resetAnswerCard();
    resetButtons();
    startPrepareTimer(3);
}

function setPreviousFormData(){
    document.getElementById("question").innerHTML = _previous_answer;
    initListeners();
    viewAnswer();
}

function viewAnswer(){
    let tempAnswer=[];

    if($('#toggle-answer').is(':checked')){
        let i = 0;
        $('#question span').each(function() {

            let selectedWord = $(this).text().trim().replace(/[^\w\s]|_/g, "").replace(/\s+/g, " ");
            
            if((wrongwords.includes(selectedWord))&&(tempAnswer.includes(selectedWord)!=true)){
                $(this).addClass('answer-show answer-state answer-state-missing');
                $(this).after('<span class="answer-span">(Answer: <span>' + answer[i] + '</span>)</span>');
                i++;
                tempAnswer.push(selectedWord);
            }

            var answerVal = $(this).next('.answer-span').find('span').text().trim();

            if($(this).hasClass('highlight') && answer.includes(answerVal)){
                $(this).removeClass('answer-state-missing');
                $(this).addClass('answer-state-correct');
                $(this).prepend('<span class="answer-state-correct-marker"><i class="anticon custom-icon " style="font-size: 14px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');

            }else if($(this).hasClass('highlight') && !answer.includes(answerVal)){
                $(this).removeClass('answer-state-missing');
                $(this).addClass('answer-show answer-state answer-state-missing');
                $(this).addClass('answer-state-wrong');
                $(this).prepend('<span class="answer-state-wrong-marker"><i class="anticon custom-icon " style="font-size: 14px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
            }
        });
    }else{
        $('.answer-span').each(function() {
            $(this).remove();
        });

        $('#question span').each(function() {
            $(this).removeClass('answer-show answer-state answer-state-missing answer-state-correct answer-state-wrong');
            $(this).find('.answer-state-wrong-marker').remove();
            $(this).find('.answer-state-correct-marker').remove();
        });
    }
};