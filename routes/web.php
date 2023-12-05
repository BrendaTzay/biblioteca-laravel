<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EditorialController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BusquedaController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/test-notifications', function () {
    app(\App\Console\Kernel::class)->generateOverdueNotifications();
    return 'Notifications generated!';
});

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::middleware(['auth'])->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');


    Route::post('chatbot/consultar', [ChatBotController::class, 'consultar'])->name('chatbot.consultar');
    Route::get('/chatbot', [ChatBotController::class, 'index'])->name('chatbot.index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


    Route::post('/prestamos/reporte', [PrestamoController::class, 'generarReporte'])->name('prestamos.reporte');
    Route::get('/prestamos/reporte/{tipo}', [PrestamoController::class, 'generarReportePrestamos']);
    Route::get('/prestamos/devolver/{id}', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');

    Route::get('/libros/reporte/{tipo}', [LibroController::class, 'generarReporte']);
    Route::get('/libros/restore/{id}', [LibroController::class, 'restore'])->name('libros.restore');
    Route::get('/buscar', [BusquedaController::class, 'buscar'])->name('buscar');

    Route::get('/autors/report/{id}', [AutorController::class, 'generateReport']);
    Route::get('/autors/report', [AutorController::class, 'generateFullReport']);
    Route::get('/usuarios/report/{id}', [UsuarioController::class, 'generateReport']);
    Route::get('/usuarios/customReport', [UsuarioController::class, 'generateCustomReport']);
    Route::get('/editorials/report/{id}', [EditorialController::class, 'generateReport']);
    Route::get('/categorias/report/{id}', [CategoriaController::class, 'generateReport']);
    Route::get('/categorias/report', [CategoriaController::class, 'generateFullReport']);
    Route::get('/editorials/report', [EditorialController::class, 'generateFullReport']);
    Route::get('libros/{id}/prestamos_activos', [LibroController::class, 'prestamosActivos'])->name('libros.prestamos_activos');
    Route::post('libros/{id}/eliminar_parcial', [LibroController::class, 'updatePartial'])->name('libros.eliminar_parcial');
    Route::get('/libros/eliminados', [LibroController::class, 'librosEliminados'])->name('libros.eliminados');
    Route::get('/libros/prestados', [LibroController::class, 'librosPrestados'])->name('libros.prestados');

    Route::resource('autors', AutorController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('editorials', EditorialController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('libros', LibroController::class);
    Route::resource('prestamos', PrestamoController::class);
    Route::get('/buscar-usuario/{codigo}', [UsuarioController::class, 'buscarPorCodigo']);
    Route::get('/prestamos/{id}/reporte', [PrestamoController::class, 'generateReport']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/administrador', [DashboardController::class, 'administrador'])->name('administrador');


});
