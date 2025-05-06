<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Laravel App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">MyApp</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item me-2">
                    <a class="btn btn-outline-primary" href="{{ route('login') }}">Вход</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="{{ route('register') }}">Регистрация</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
