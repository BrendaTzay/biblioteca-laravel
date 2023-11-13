@extends('layouts.app')

@section('title', 'Administrador')

@section('content')
    <h1 class="mb-4">Bienvenido al panel de administrador</h1>

    <div class="row">
        <div class="col-md-4">
            <a href="{{ route('libros.eliminados') }}" class="card-link">
                <div class="card custom-card card-libros-eliminados">
                    <div class="card-top-bar green-bar"></div>
                    <div class="card-body">
                        <h5 class="card-title">Libros Eliminados</h5>
                        <p class="card-text">Número de libros eliminados: {{ $numLibrosEliminados }}</p>
                    </div>
                    <div class="card-icon">
                        <i class="fa fa-trash"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('libros.prestados') }}" class="card-link">
                <div class="card custom-card card-libros-prestados">
                    <div class="card-top-bar orange-bar"></div>
                    <div class="card-body">
                        <h5 class="card-title">Libros en Préstamo</h5>
                        <p class="card-text">Número de libros prestados: {{ $numLibrosPrestados }}</p>
                    </div>
                    <div class="card-icon loan-icon">
                        <i class="fa fa-book"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('chatbot.index') }}" class="card-link">
                <div class="card custom-card card-chatbot">
                    <div class="card-top-bar blue-bar"></div>
                    <div class="card-body">
                        <h5 class="card-title">Chatbot</h5>
                        <p class="card-text">Acceder a la vista del chatbot.</p>
                    </div>
                    <div class="card-icon chatbot-icon">
                        <i class="fa fa-robot"></i>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('notifications.index') }}" class="card-link">
                <div class="card custom-card card-notificaciones">
                    <div class="card-top-bar purple-bar"></div>
                    <div class="card-body">
                        <h5 class="card-title">Notificaciones</h5>
                        <p class="card-text">Tienes {{ $numNotificaciones }} notificaciones sin leer.</p>
                    </div>
                    <div class="card-icon notification-icon">
                        <i class="fa fa-bell"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
