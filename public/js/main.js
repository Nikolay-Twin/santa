

$("document").ready(function() {
    $('#present_form').on('submit', function (e) {
        e.preventDefault();
        $("#form_success").empty();
        $("#form_errors").empty();
        let data = dataToJson(new Map([
            ['present', $('input[name="form[presents]"]:checked').val()],
            ['name', $("#form_name").val()],
            ['email', $("#form_email").val()]
        ]));
        send('/api/v1/felicitate', data);
    });

    $('#sender_form').on('submit', function (e) {
        e.preventDefault();
        $("#form_success").empty();
        $("#form_errors").empty();
        let data = dataToJson(new Map([['send', 'go']]));
        send('/api/v1/begin', data);
    });
});

function dataToJson(data) {
    return JSON.stringify(Object.fromEntries(data));
}

function send(path, formData) {
    $("#form_success").html('<img src="/img/preload.gif">');
    $.ajax({
        url: path,
        method: 'POST',
        dataType: 'json',
        data: formData,
        success: function(data) {
            $("#form_success").empty();
            if (data.status == 'ok') {
                $("#form_success").append(data.message);
                $("#form_name").val('');
                $("#form_email").val('');
            } else {
                badRequest();
            }
        },
        error: function(data) {
            $("#form_success").empty();
            $("#form_errors").empty();
            let answer = data.responseJSON;
            if (answer.status == 'failed') {
                $.each(answer.errors, (index, value) => {
                    if (typeof value.message != 'undefined') {
                        $("#form_errors").append(value.message + '<br>');
                    } else {
                        badRequest();
                        return false;
                    }
                })
            } else {
                badRequest();
            }
        }
    });
}

function badRequest() {
    $("#form_errors").html('Неизвестная ошибка, попробуйте позже');
}
