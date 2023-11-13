<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Autor</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <div class="header">
        <img src="{{ public_path('path/to/your/logo.png') }}" alt="Logo" class="logo">
        <h2>Reporte de Autor</h2>
    </div>
    <div class="section">
        <h3>Datos del Autor</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
            </tr>
            <tr>
                <td>{{ $autor->IdAutor }}</td>
                <td>{{ $autor->NombreAutor }}</td>
                <td>{{ $autor->ApellidoAutor }}</td>
            </tr>
        </table>
    </div>
    <div class="section">
        <h3>Libros del Autor</h3>
        <table>
            <tr>
                <th>Título</th>
                <th>Categoría</th>
                <th>Editorial</th>
                <th>Cantidad</th>
            </tr>
            @foreach($libros as $libro)
            <tr>
                <td>{{ $libro->TituloLibro }}</td>
                <td>{{ $libro->categoria->NombreCategoria }}</td>
                <td>{{ $libro->editorial->NombreEditorial }}</td>
                <td>{{ $libro->CantidadLibro }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="section">
        <h3>Descripción de Libros</h3>
        @foreach($libros as $libro)
        <div class="description">
            <h4>{{ $libro->TituloLibro }}:</h4>
            <p>{{ $libro->DescripcionLibro }}</p>
        </div>
        @endforeach
    </div>
    <div class="footer">
        <p>Espacio para firma o sello</p>
        <p>Dirección de la Biblioteca</p>
    </div>
</body>
</html>
