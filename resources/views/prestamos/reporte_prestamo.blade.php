<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Préstamo</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <div class="header">
        <img src="{{ public_path('path/to/your/logo.png') }}" alt="Logo" class="logo">
        <h2>Reporte de Préstamo</h2>
    </div>
    <div class="section">
        <h3>Datos del Usuario</h3>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Grado</th>
                <th>Teléfono</th>
                <th>Dirección</th>
            </tr>
            <tr>
                <td>{{ $prestamo->usuario->CodigoUsuario }}</td>
                <td>{{ $prestamo->usuario->NombreUsuario }} {{ $prestamo->usuario->ApellidoUsuario }}</td>
                <td>{{ $prestamo->usuario->GradoUsuario }}</td>
                <td>{{ $prestamo->usuario->TelefonoUsuario }}</td>
                <td>{{ $prestamo->usuario->DireccionUsuario }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
    <h3>Datos del Libro</h3>
    <table>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Editorial</th>
            <th>Categoría</th>
        </tr>
        <tr>
            <td>{{ $prestamo->libro->TituloLibro }}</td>
            <td>{{ $prestamo->libro->autor->NombreAutor }} {{ $prestamo->libro->autor->ApellidoAutor }}</td>
            <td>{{ $prestamo->libro->Editorial->NombreEditorial }}</td>
            <td>{{ $prestamo->libro->categoria->NombreCategoria }}</td>
        </tr>
    </table>
    <div class="description">
        <h4>Descripción:</h4>
        <p>{{ $prestamo->libro->DescripcionLibro }}</p>
    </div>
</div>

<div class="section">
    <h3>Información de Préstamo</h3>
    <table>
        <tr>
            <th>Fecha de Salida</th>
            <th>Fecha de Devolución</th>
        </tr>
        <tr>
            <td>{{ $prestamo->FechaSalida }}</td>
            <td>{{ $prestamo->FechaDevolucion }}</td>
        </tr>
    </table>
    <div class="description">
        <h4>Observación:</h4>
        <p>{{ $prestamo->ObservacionPrestamo }}</p>
    </div>
</div>

    <div class="footer">
        <p>Espacio para firma o sello</p>
        <p>Dirección de la Biblioteca Comunitaria</p>
    </div>
</body>
</html>
