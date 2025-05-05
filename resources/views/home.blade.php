@extends('layouts.main')

@section('content')
    <div class="text-center">
        <h1 class="mb-4">Добро пожаловать!</h1>
        <p>Если вы видите эту страницу со стилями Bootstrap — всё подключено и работает.</p>

        @auth
            <a href="{{ route('tasks') }}" class="btn btn-success me-2">Мои задания</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary me-2">Войти</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary">Регистрация</a>
        @endauth
    </div>
@endsection
