$('#register-form').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/api/register',
        method: 'POST',
        data: {
            name: $('#name').val(),
            email: $('#email').val(),
            password: $('#password').val(),
            password_confirmation: $('#password_confirmation').val(),
        },
        success: function (response) {
            window.location.href = '/login';
        },
        error: function (xhr) {
            let msg = 'Ошибка регистрации';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            $('#register-error').text(msg);
        }
    });
});
