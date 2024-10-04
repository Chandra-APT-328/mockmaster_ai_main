function verifyanswers(){
    $('.blank').each(function(i) {
        var selectVal = $(this).find('span').text().trim();
        var answerVal = $(this).next('.answer-span').find('span').text().trim();

        if (selectVal === answerVal) {
            $(this).removeClass('answer-mismatch');
            $(this).addClass('answer-match');
            $(this).find('.marker').remove();
            $(this).find('div').prepend('<span class="marker" style="float: left; margin-left: 14px; "><i class="anticon custom-icon " style="font-size: 14px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');
        }else{
            $(this).removeClass('answer-match');
            $(this).addClass('answer-mismatch');
            $(this).find('.marker').remove();
            $(this).find('div').prepend('<span class="marker" style="float: left; margin-left: 14px; "><i class="anticon custom-icon " style="font-size: 14px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
        }
    });
}

function viewAnswer(){
    if($('#toggle-answer').is(':checked')){ 
        $('.answer-card').removeClass('d-none');     
        $('.blank').each(function(i) {
            $(this).after('<span class="answer-span">(Answer: <span class="blank-answer">' + answer[i] + '</span>)</span>');
            var selectVal = $(this).find('span').text().trim();
            var answerVal = $(this).next('.answer-span').find('span').text().trim();

            if (selectVal === answerVal) {
                $(this).removeClass('answer-mismatch');
                $(this).addClass('answer-match');
                $(this).find('.marker').remove();
                $(this).find('div').prepend('<span class="marker" float: left;margin-left: 14px; ><i class="anticon custom-icon " style="font-size: 14px; color: rgb(18, 211, 191);"><svg height="1em" viewBox="0 0 17 15" width="1em" fill="currentColor"><path d="M1.403 6.948l5 6.452 9-12" stroke="#12D3BF" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round" stroke-linejoin="round"></path></svg></i></span>');
            }else{
                $(this).removeClass('answer-match');
                $(this).addClass('answer-mismatch');
                $(this).find('.marker').remove();
                $(this).find('div').prepend('<span class="marker" style="float: left; margin-left: 14px; "><i class="anticon custom-icon " style="font-size: 14px; color: rgb(255, 102, 102);"><svg viewBox="0 0 13 13" width="1em" height="1em" fill="currentColor"><g stroke="#F66" stroke-width="2" fill="none" fill-rule="evenodd" stroke-linecap="round"><path d="M1.482 1.423l9.883 10M11.364 1.423l-9.882 10"></path></g></svg></i></span>');
            }
        });
    }else{
        $('.answer-card').addClass('d-none');   
        $('.answer-span').each(function() {
            $(this).remove();
        });

        $('.blank').each(function() {
            $(this).removeClass('answer-mismatch');
            $(this).removeClass('answer-match');
            $(this).find('.marker').remove();
        });
    }
}

$('#toggle-answer').change(function(){
    viewAnswer();
});

initListeners();

function initListeners(){
    let options = document.querySelectorAll('#options-container div');
    let blanks = document.querySelectorAll('.blank');
    let optionsContainer = document.getElementById("options-container");

    optionsContainer.addEventListener("dragenter", function(event) {
        event.preventDefault();
        optionsContainer.classList.add('hover');
    });

    optionsContainer.addEventListener("dragover", function(event) {
        event.preventDefault();
        optionsContainer.classList.add('hover');
    });

    optionsContainer.addEventListener("dragleave", function(event) {
        event.preventDefault();
        optionsContainer.classList.remove('hover');
    });

    optionsContainer.addEventListener("drop", function(e) {
        e.preventDefault();
        optionsContainer.classList.remove('hover');
        
        const dragging = document.querySelector('.dragging');

        if(dragging.classList.contains('dragging-from-blanks')){
            const option = document.createElement('div');
            option.innerText = dragging.querySelector('span:not(.marker)').innerText;
            option.classList.add('option');
            option.setAttribute('draggable', 'true');
            
            dragging.querySelector('span:not(.marker)').innerText = '';
            $(dragging).find('.marker').remove();

            option.addEventListener('dragstart', () => {
                option.classList.add('dragging');
                option.classList.add('dragging-from-options');
            });
            option.addEventListener('dragend', () => {
                checkAnswerStatus();
                option.classList.remove('dragging');
                option.classList.remove('dragging-from-options');
            });
            dragging.classList.remove('dragging');
            dragging.classList.remove('blank-move');
            optionsContainer.appendChild(option);
        }
    });

    options.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging');
            draggable.classList.add('dragging-from-options');
        });

        draggable.addEventListener('dragend', () => {
            checkAnswerStatus();
            draggable.classList.remove('dragging');
            draggable.classList.remove('dragging-from-options');
        });
    });

    blanks.forEach(blank => {
        blank.addEventListener('dragover', e => {
            e.preventDefault();
            blank.classList.add('hover');
        });

        blank.addEventListener('dragleave', (e) => {
            e.preventDefault();
            blank.classList.remove('hover');
        });

        blank.addEventListener('drop', e => {
            e.preventDefault();
            blank.classList.remove('hover');
            const dragging = document.querySelector('.dragging');

            if(dragging.classList.contains('dragging-from-options')){
                if(blank.querySelector('span:not(.marker)').innerText.length === 0){
                    blank.querySelector('span:not(.marker)').innerText = dragging.innerText;
                    dragging.remove();
                    blank.firstElementChild.setAttribute('draggable', 'true');
                    blank.firstElementChild.classList.add('blank-move');

                    if($('#toggle-answer').is(':checked')){
                        verifyanswers();
                    }
                    return;
                }
                if(blank.querySelector('span:not(.marker)').innerText.length > 0){
                    const temp = blank.querySelector('span:not(.marker)').innerText;
                    blank.querySelector('span:not(.marker)').innerText = dragging.innerText;
                    dragging.remove();
                    blank.firstElementChild.setAttribute('draggable', 'true');
                    blank.firstElementChild.classList.add('blank-move');

                    const option = document.createElement('div');
                    option.draggable = true;
                    option.innerText = temp;
                    option.classList.add('option');

                    option.addEventListener('dragstart', () => {
                        option.classList.add('dragging');
                        option.classList.add('dragging-from-options');
                    });
                    option.addEventListener('dragend', () => {
                        checkAnswerStatus();
                        option.classList.remove('dragging');
                        option.classList.remove('dragging-from-options');
                    });
                    optionsContainer.appendChild(option);

                    if($('#toggle-answer').is(':checked')){
                        verifyanswers();
                    }
                    return;
                }
            }
        });

        blank.addEventListener('dragstart', (e) => {
            if (blank.querySelector('span:not(.marker)').innerText.length === 0) {
                e.preventDefault();
                blank.firstElementChild.setAttribute('draggable', 'false');
                return;
            }
            if(blank.querySelector('span:not(.marker)').innerText.length > 0){
                if($('#toggle-answer').is(':checked')){
                    e.target.querySelector('.marker').remove();
                }
                blank.firstElementChild.classList.add('dragging');
                blank.firstElementChild.classList.add('dragging-from-blanks');
            }
        });

        blank.addEventListener('dragend', () => {
            checkAnswerStatus();
            if($('#toggle-answer').is(':checked')){
                verifyanswers();
            }
            blank.firstElementChild.classList.remove('dragging');
            blank.firstElementChild.classList.remove('dragging-from-blanks');
        });
    });
}

document.getElementById("submitbtn").addEventListener("click", function () {
    // getting new positions
    const form = document.getElementById("fib_rd");
    const allblanks = document.querySelectorAll('.blank');
    const blanksdata = [];

    allblanks.forEach((blank) => {
        blanksdata.push(blank.querySelector('span:not(.marker)').innerText);
    });
    document.getElementById("answer").value = JSON.stringify(blanksdata);
    form.submit();
});

// disable submit if no answer selected
function checkAnswerStatus(){
    let submit_disable = true;
    const allblanks = document.querySelectorAll('.blank');
    allblanks.forEach((blank) => {
        if(blank.querySelector('span:not(.marker)').innerText != ""){
            submit_disable = false;
        };
    });
    
    $('[name="submitbtn"]').prop('disabled',submit_disable);
}

function setPreviousFormData(){
    const allblanks = document.querySelectorAll('.blank');
    allblanks.forEach((blank, index) => {
        blank.querySelector('span:not(.marker)').innerText = _previous_answer[index];
        blank.querySelector('div').classList.add("blank-move");
        blank.querySelector('div').setAttribute('draggable', true);
    });
    viewAnswer();
}

function resetButtons(){
    $('[name="submitbtn"]').prop('disabled', true);
}

function resetAnswerCard(){
    if($('#toggle-answer').is(':checked')){
        $('#toggle-answer').prop("checked",false);
        viewAnswer();
    }
}
function resetPage(){
    document.getElementById('blanks-container').innerHTML = raw_blanks;
    document.getElementById("options-container").innerHTML = "";
    options.forEach((e)=>{
        var div = document.createElement("div");
        div.innerHTML = e; 
        div.classList.add("option"); 
        div.setAttribute('draggable', true);
        document.getElementById("options-container").appendChild(div);
    });
    resetAnswerCard();
    resetButtons();
    initListeners();
    startTimer();
}