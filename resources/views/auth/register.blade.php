@extends('layouts.main')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Регистрация</h2>

            <form id="register-form">
                <div class="mb-3">
                    <label for="name" class="form-label">Имя</label>
                    <input type="text" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля</label>
                    <input type="password" id="password_confirmation" class="form-control" required>
                </div>

                <div id="register-error" class="text-danger mb-2"></div>

                <button type="submit" class="btn btn-success w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
