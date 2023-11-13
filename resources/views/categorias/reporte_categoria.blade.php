<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Categoría</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <div class="header">
        <h2>Reporte de Categoría</h2>
    </div>
    <div class="section">
        <h3>Categoría: {{ $categoria->NombreCategoria }}</h3>
    </div>
    <div class="section">
        <h3>Libros asociados</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libros as $libro)
                    <tr>
                        <td>{{ $libro->IdLibro }}</td>
                        <td>{{ $libro->TituloLibro }}</td>
                        <td>{{ $libro->autor->NombreAutor }} {{ $libro->autor->ApellidoAutor }}</td>
                        <td>{{ $libro->CantidadLibro }}</td>
                        <td>{{ $libro->EstadoLibro }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
