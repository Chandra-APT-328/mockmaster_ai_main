$('#toggle-answer').change(function(e){
    viewAnswer();
});

$('select').change(function(e) {
    checkAnswerStatus();
    if($('#toggle-answer').is(':checked')){
        var selectVal = $(this).val().trim();
        var answerVal = $(this).parent().find('.answer-span').find('span').text().trim();

        if (selectVal === answerVal) {
            $(this).removeClass('answer-mismatch');
            $(this).addClass('answer-match');
            $(this).parent().find('.answer-marker').remove();

            $(this).after('<span class="answer-marker" style="display: inline-block;"><i class="anticon custom-icon " style="font-size: 12px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');
        }else{
            $(this).removeClass('answer-match');
            $(this).addClass('answer-mismatch');
            $(this).parent().find('.answer-marker').remove();

            $(this).after('<span class="answer-marker" style="display: inline-block;"><i class="anticon custom-icon " style="font-size: 12px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
        }
    }
});

function viewAnswer(){
    if($('#toggle-answer').is(':checked')){
        $('.answer-card').removeClass('d-none');
        $('select').each(function(i) {
            $(this).after('<span class="answer-span">(Answer: <span class="blank-answer">' + answer[i] + '</span>)</span>');
            var selectVal = $(this).val().trim();
            var answerVal = $(this).parent().find('.answer-span').find('span').text().trim();

            if (selectVal === answerVal) {
                $(this).removeClass('answer-mismatch');
                $(this).addClass('answer-match');
                $(this).after('<span class="answer-marker" style="display: inline-block;"><i class="anticon custom-icon " style="font-size: 12px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');
            }else{
                $(this).removeClass('answer-match');
                $(this).addClass('answer-mismatch');
                $(this).after('<span class="answer-marker" style="display: inline-block;"><i class="anticon custom-icon " style="font-size: 12px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
            }
        });
    }else{
        $('.answer-card').addClass('d-none');
        $('.answer-span').each(function() {
            $(this).remove();
        });

        $('select').each(function() {
            $(this).removeClass('answer-mismatch');
            $(this).removeClass('answer-match');
        });

        $('.select-blank').each(function() {
            $(this).find('.answer-marker').remove();
        });
    }
}

function checkAnswerStatus(){
    let submit_disable = true;
    $('[name="selectOptions[]"]').each(function(i) {
        if($(this).val() != ""){
            submit_disable = false;
        }
    });
    
    $('input[type="submit"]').prop('disabled',submit_disable);
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
    $('[name="selectOptions[]"]').each(function(i) {
        $(this).val("");
    });
    resetAnswerCard();
    resetButtons();
    startTimer();
}

function setPreviousFormData(){
    viewAnswer();
}