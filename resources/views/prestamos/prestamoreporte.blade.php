<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}"> 
</head>
<body>
    <div class="header">
        <h2>{{ $titulo }}</h2>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Libro</th>
                    <th>Fecha de Préstamo</th>
                    <th>Fecha de Devolución</th>
                    <th>Estado</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $prestamo)
                    <tr>
                        <td>{{ $prestamo->IdPrestamo }}</td>
                        <td>{{ $prestamo->usuario->NombreUsuario }} {{ $prestamo->usuario->ApellidoUsuario }}</td>
                        <td>{{ $prestamo->libro->TituloLibro }}</td>
                        <td>{{ $prestamo->FechaSalida }}</td>
                        <td>{{ $prestamo->FechaDevolucion }}</td>
                        <td>{{ $prestamo->EstadoPrestamo }}</td>
                        <td>{{ $prestamo->ObservacionPrestamo }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay préstamos registrados para este criterio.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Total de Préstamos: {{ $prestamos->count() }}</p>
    </div>
</body>
</html>
