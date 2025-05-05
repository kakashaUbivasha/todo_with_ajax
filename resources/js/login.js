$('#login-form').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/api/login',
        method: 'POST',
        data: {
            email: $('#email').val(),
            password: $('#password').val(),
        },
        success: function (response) {
            localStorage.setItem('api_token', response.token);
            window.location.href = '/tasks';
        },
        error: function () {
            $('#login-error').text('Неверный email или пароль');
        }
    });
});
