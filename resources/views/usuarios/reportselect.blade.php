<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Usuarios</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}"> <!-- Asegúrate de tener un archivo CSS para estilos -->
</head>

<body>
    <div class="header">
        <h2>Reporte de Usuarios</h2>
    </div>

    <div class="section">
        <h3>Usuarios Registrados</h3>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Grado/Tipo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->CodigoUsuario }}</td>
                        <td>{{ $usuario->NombreUsuario }}</td>
                        <td>{{ $usuario->ApellidoUsuario }}</td>
                        <td>{{ $usuario->GradoUsuario ?? 'Comunidad' }}</td>
                        <td>{{ $usuario->TelefonoUsuario }}</td>
                        <td>{{ $usuario->DireccionUsuario }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay usuarios registrados para este criterio.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Total de Usuarios: {{ $usuarios->count() }}</p>
    </div>
</body>

</html>
