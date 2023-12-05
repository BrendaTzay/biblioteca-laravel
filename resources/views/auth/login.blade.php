@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-container">
        <div class="login-box">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen de Login" class="login-image">

            <div class="login-form">
                <div class="login-header">
                    <h2>Iniciar Sesión</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>Correo</label>
                        <input id="email" type="email" name="email" class="form-control"
                            placeholder="Ingrese su correo" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Contraseña</label>
                        <input id="password" type="password" name="password" class="form-control"
                            placeholder="Ingrese su contraseña" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark btn-block">{{ __('Ingresar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="login-footer">
        Desarrollado por: Brenda Marina Tzay Cuxulic
    </footer>
@endsection
