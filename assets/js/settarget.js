


<script>
const numbers = document.querySelectorAll('input[type="number"]');
const radios = document.querySelectorAll('input[name="target"]');
const siteUrl = '<?php echo base_url(); ?>';

numbers.forEach(number => {
    number.onkeyup = () => {
        isNumber(event)
    }
});

$('.target-box').click(() => {
    $('#set-target-modal').modal('show');
});

$('[name="target"]').change((evt) => {
    val = evt.target.value

    $("input[name='target'] + .check-radio").removeClass('checked');
    $('input[name="target"]:checked + .check-radio').addClass('checked');

    if (val != 30) {
        numbers.forEach(number => {
            if (number.name == 'overall-target') {
                number.value = '';
            } else {
                number.value = val;
            }
        });
    } else if (val == 30) {
        numbers.forEach(number => {
            if (number.name != 'overall-target') {
                number.value = '';
            } else {
                number.value = val;
            }
        });
    }
});

$(function() {
    var today = new Date();
    var month = today.getMonth() + 1;
    var day = today.getDate();
    var year = today.getFullYear();
    if (month < 10)
        month = '0' + month.toString();
    if (day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;

    $('#exam-date').attr('min', maxDate);
    // $('#exam-date').val(maxDate);
});

$('#targetsubmit').click((e) => {
    e.target.disabled = true;
    let inputdata = [];

    numbers.forEach(number => {
        inputdata.push(number.value);
    });

    if (inputdata.some((input) => input > 0)) {
        var form = $('#target-form');
        var csrfName = $('.csrfToken').attr('name');
        var csrfHash = $('.csrfToken').val(); // CSRF hash
        $.ajax({
            url: siteUrl + "user/setexamtarget",
            type: "POST",
            crossDomain: true,
            dataType: 'json',
            cache: false,
            data: {
                [csrfName]: csrfHash,
                form: form.serialize()
            },
            success: function(data) {
                if (data.status == 1) {
                    $('.csrfToken').val(data.token);
                    toast('Target set successfully!');
                    // e.target.disabled = false;
                    // $('#set-target-modal').modal('hide');
                    location.href = siteUrl + 'user/studycenter';
                } else {
                    toast('Failed to set target!');
                    e.target.disabled = false;
                }
            }
        });
    } else {
        toast('Target score is required!');
        e.target.disabled = false;
    }
});

$('input[type="number"]').on('keyup change', (e) => {
    var inputdata = [];
    var inputText = e.target.value;

    numbers.forEach(number => {
        if (number.name != 'overall-target')
            inputdata.push(number.value);
    });

    var validate = inputdata.every((input) => {
        if (e.target.name == 'overall-target') {
            return;
        } else {
            input == inputText;
        }
    });

    $("input[name='target'] + .check-radio").removeClass('checked');

    if (inputdata.every((input) => input == inputText)) {
        radios.forEach(radio => {
            if (radio.value == inputText) {
                radio.checked = true;
                $('input[name="target"]:checked + .check-radio').addClass('checked');
            }
        });
    } else if (inputText == 30 && e.target.name == 'overall-target') {
        $('#overall-30').attr('checked', true);
        $('input[name="target"]:checked + .check-radio').addClass('checked');
    } else {
        $("input[name='target'] + .check-radio").removeClass('checked');
    }
});

function isNumber(evt) {

    var inputText = evt.target.value;

    if (inputText > 90) {
        evt.target.value = 90;
    }

    if (inputText.length > 1) {
        event.preventDefault();
    }

    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        event.preventDefault();
    }
}

function toast(message) {
    Toastify({
        text: message,
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "#fff",
            color: "#000"
        }
    }).showToast();
}
</script>