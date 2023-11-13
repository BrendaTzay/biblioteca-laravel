<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte Completo de Editoriales</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>

<body>
    <div class="header">
        <h2>Reporte Completo de Editoriales</h2>
    </div>
    @foreach ($editorials as $editorial)
        <div class="section">
            <h3>Editorial: {{ $editorial->NombreEditorial }}</h3>
            @if ($editorial->libros->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Categoría</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($editorial->libros as $libro)
                            <tr>
                                <td>{{ $libro->TituloLibro }}</td>
                                <td>{{ $libro->autor->NombreAutor }} {{ $libro->autor->ApellidoAutor }}</td>
                                <td>{{ $libro->categoria->NombreCategoria }}</td>
                                <td>{{ $libro->CantidadLibro }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Esta editorial aún no tiene libros asociados.</p>
            @endif
        </div>
    @endforeach
    <div class="footer">
        <p>Total de Editoriales: {{ $totalEditorials }}</p>
    </div>
</body>

</html>
