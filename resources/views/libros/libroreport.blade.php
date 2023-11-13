<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Libros</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>

<body>
    <<div class="header">
        <h2>{{ $titulo }}</h2>
    </div>
    
    <div class="section">
        <h3>Libros</h3>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Categoría</th>
                    <th>Editorial</th>
                    <th>Cantidad</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($libros as $libro)
                    <tr>
                        <td>{{ $libro->IdLibro }}</td>
                        <td>{{ $libro->TituloLibro }}</td>
                        <td>{{ $libro->autor->NombreAutor }} {{ $libro->autor->ApellidoAutor }}</td>
                        <td>{{ $libro->categoria->NombreCategoria }}</td>
                        <td>{{ $libro->editorial->NombreEditorial }}</td>
                        <td>{{ $libro->CantidadLibro }}</td>
                        <td>{{ $libro->EstadoLibro }}</td>
                        <!-- ... tus otras columnas ... -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay libros registrados para este criterio.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Total de Libros: {{ $libros->count() }}</p>
    </div>
</body>

</html>
