<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuario</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <div class="header">

        <h2>Reporte de Usuario</h2>
    </div>
    <div class="section">
        <h3>Datos del Usuario</h3>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Teléfono</th>
            </tr>
            <tr>
                <td>{{ $usuario->CodigoUsuario }}</td>
                <td>{{ $usuario->NombreUsuario }}</td>
                <td>{{ $usuario->ApellidoUsuario }}</td>
                <td>{{ $usuario->GradoUsuario }}</td>
                <td>{{ $usuario->TelefonoUsuario }}</td>
            </tr>
        </table>
    </div>
    <div class="description">
        <h4>Dirección:</h4>
        <p>{{ $usuario->DireccionUsuario }}</p>
    </div>

    <div class="footer">
        <p>Espacio para firma o sello</p>
        <p>Dirección de la Biblioteca Comunitaria</p>
    </div>
</body>
</html>
