@extends('layouts.main')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">Вход</h2>

            <form id="login-form">
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" id="password" class="form-control" required>
                </div>

                <div id="login-error" class="text-danger mb-2"></div>

                <button type="submit" class="btn btn-primary w-100">Войти</button>
            </form>
        </div>
    </div>
@endsection
