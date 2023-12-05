<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Biblioteca')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src=https://cdn.jsdelivr.net/npm/sweetalert2@11.9.0/dist/sweetalert2.all.min.js></script>
    @stack('styles')
</head>

<body id="body-pd">
    @if (auth()->check())
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>
            <div class="header__logout">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i>
                    <span>Cerrar Sesión</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </header>
        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>
                    <div class="nav__logo">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="logo">
                        <span class="nav__title">Buena Vista</span>
                    </div>
                    <div class="nav__divider"></div>
                    <div class="nav__list">
                        <a href="{{ route('administrador') }}" class="nav__link">
                            <i class="fas fa-tachometer-alt nav__icon"></i>
                            <span class="nav__name">Admin</span>
                        </a>
                        <a href="{{ route('usuarios.index') }}" class="nav__link">
                            <i class="fas fa-user nav__icon"></i>
                            <span class="nav__name">Usuarios</span>
                        </a>
                        <a href="{{ route('prestamos.index') }}" class="nav__link">
                            <i class="fas fa-exchange-alt nav__icon"></i>
                            <span class="nav__name">Préstamos</span>
                        </a>
                        <a href="{{ route('libros.index') }}" class="nav__link">
                            <i class="fas fa-book nav__icon"></i>
                            <span class="nav__name">Libros</span>
                        </a>
                        <a href="{{ route('autors.index') }}" class="nav__link">
                            <i class="fas fa-pen nav__icon"></i>
                            <span class="nav__name">Autores</span>
                        </a>
                        <a href="{{ route('editorials.index') }}" class="nav__link">
                            <i class="fas fa-building nav__icon"></i>
                            <span class="nav__name">Editoriales</span>
                        </a>
                        <a href="{{ route('categorias.index') }}" class="nav__link">
                            <i class="fas fa-layer-group nav__icon"></i>
                            <span class="nav__name">Categorias</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    @endif

    <section id="content" class="flex-grow-1 p-3">
        @yield('content')
    </section>



    <script src="{{ asset('js/autocomplete.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/chatbot.js') }}"></script>

</body>

</html>
