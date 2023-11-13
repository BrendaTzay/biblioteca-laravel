<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Prestamo;
use App\Models\Notification;


class Kernel extends ConsoleKernel
{

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->generateOverdueNotifications();
        })->daily();
    }

    public function generateOverdueNotifications()
    {
        $overdueLoans = Prestamo::with(['usuario', 'libro'])
            ->where('EstadoPrestamo', 'Prestado')
            ->where('FechaDevolucion', '<', now())
            ->get();

        foreach ($overdueLoans as $loan) {
            $tituloLibro = $loan->libro->TituloLibro;
            $nombreUsuario = $loan->usuario->NombreUsuario;
            $apellidoUsuario = $loan->usuario->ApellidoUsuario;

            $message = "El libro '{$tituloLibro}' con ID {$loan->IdLibro} ha excedido la fecha de devolución. Este libro fue prestado a {$nombreUsuario} {$apellidoUsuario}.";

            Notification::create([
                'message' => $message,
                'read' => false
            ]);
        }
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
