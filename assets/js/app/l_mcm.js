function ischeck(id) {
    if ($('#option' + id).is(":checked")) {
        $('#optionSelection' + id).val('1');
    } else {
        $('#optionSelection' + id).val('0');
    }

    if($('#toggle-answer').is(':checked')){
        
        $('[name="optionSelected[]"]').each(function(i) {

            if(answer[i] == 1 && $(this).val() == 1){
                $(this).next().next().removeClass('check-state-missing');
                $(this).next().next().addClass('check-state-correct');
            }
            else if(answer[i] == 1 && $(this).val() == 0){
                $(this).next().next().removeClass('check-state-correct');
                $(this).next().next().addClass('check-state-missing');
            }
            else if(answer[i] == 0 && $(this).val() == 1){
                $(this).next().next().removeClass('check-state-missing');
                $(this).next().next().addClass('check-state-wrong');
            }else{
                $(this).next().next().removeClass('check-state-wrong');
            }
        });
    }
}

$('#toggle-answer').change(function(){
    $('.answer-card').toggleClass('d-none');

    if($('#toggle-answer').is(':checked')){
        
        $('[name="optionSelected[]"]').each(function(i) {

            if(answer[i] == 1 && $(this).val() == 1){
                $(this).next().next().addClass('check-state-correct');
            }
            else if(answer[i] == 1 && $(this).val() == 0){
                $(this).next().next().addClass('check-state-missing');
            }
            else if(answer[i] == 0 && $(this).val() == 1){
                $(this).next().next().addClass('check-state-wrong');
            }
        });
    }else{
        $('[name="optionSelected[]"]').each(function() {
            $(this).next().next().removeClass('check-state-correct check-state-missing check-state-wrong');
        });
    }
});