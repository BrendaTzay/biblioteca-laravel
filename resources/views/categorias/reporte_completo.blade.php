<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte Completo de Categorías</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>

<body>
    <div class="header">
        <h2>Reporte Completo de Categorías</h2>
    </div>
    @foreach ($categorias as $categoria)
        <div class="section">
            <h3>Categoría: {{ $categoria->NombreCategoria }}</h3>
            @if ($categoria->libros->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Cantidad</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoria->libros as $libro)
                            <tr>
                                <td>{{ $libro->TituloLibro }}</td>
                                <td>{{ $libro->autor->NombreAutor }} {{ $libro->autor->ApellidoAutor }}</td>
                                <td>{{ $libro->CantidadLibro }}</td>
                                <td>{{ $libro->EstadoLibro }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Esta categoría aún no tiene asociado un libro.</p>
            @endif
        </div>
    @endforeach
    <div class="footer">
        <p>Total de Categorías: {{ $totalCategorias }}</p>
    </div>
</body>
</html>
