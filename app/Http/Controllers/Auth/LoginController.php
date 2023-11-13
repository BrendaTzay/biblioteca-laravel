<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Autenticación exitosa, redireccionar.
            return redirect()->intended('administrador');
        }

        // Autenticación fallida, enviar mensajes de error.
        return back()->withInput($request->only('email'))
            ->withErrors([
                'email' => 'El correo ingresado es incorrecto.',
                'password' => 'La contraseña ingresada es incorrecta.',
            ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
