<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Prestamo;
use Illuminate\Notifications\DatabaseNotification;


class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.dashboard');
    }

    public function administrador()
    {
        $numLibrosEliminados = Libro::onlyTrashed()->count();
        $numLibrosPrestados = Prestamo::where('EstadoPrestamo', 'Prestado')->count();
        $numNotificaciones = DatabaseNotification::where('read', 0)->count();


        return view('administrador', [
            'numLibrosEliminados' => $numLibrosEliminados,
            'numLibrosPrestados' => $numLibrosPrestados,
            'numNotificaciones' => $numNotificaciones
        ]);
    }
}
