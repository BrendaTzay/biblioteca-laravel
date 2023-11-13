<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reporte Completo de Autores</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>

<body>
    <div class="header">
        <h2>Reporte Completo de Autores</h2>
    </div>
    @foreach ($autors as $autor)
        <div class="section">
            <h3>Autor: {{ $autor->NombreAutor }} {{ $autor->ApellidoAutor }}</h3>
            @if ($autor->libros->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Título del Libro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($autor->libros as $libro)
                            <tr>
                                <td>{{ $libro->TituloLibro }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Este autor aún no tiene libros asociados.</p>
            @endif
        </div>
    @endforeach
    <div class="footer">
        <p>Total de Autores: {{ $totalAutors }}</p>
    </div>
</body>

</html>
