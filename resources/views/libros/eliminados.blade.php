@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-trash-alt mr-2"></i>Libros Eliminados
                                </h5>
                            </div>
                            <div class="col-md-4 ml-auto">
                                <input type="text" id="search" class="form-control" placeholder="Buscar libro...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Autor</th>
                                        <th>Categoría</th>
                                        <th>Editorial</th>
                                        <th>Cantidad</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($librosEliminados as $libro)
                                        <tr>
                                            <td>{{ $libro->IdLibro }}</td>
                                            <td>{{ $libro->TituloLibro }}</td>
                                            <td>{{ $libro->autor ? $libro->autor->NombreAutor : 'N/A' }}</td>
                                            <td>{{ $libro->categoria ? $libro->categoria->NombreCategoria : 'N/A' }}</td>
                                            <td>{{ $libro->editorial ? $libro->editorial->NombreEditorial : 'N/A' }}</td>
                                            <td>{{ $libro->CantidadLibro }}</td>
                                            <td>
                                                <div class="text-truncate" title="{{ $libro->DescripcionLibro }}"
                                                    style="max-width: 100px;">
                                                    {{ $libro->DescripcionLibro }}
                                                </div>
                                            </td>
                                            <td>{{ $libro->EstadoLibro }}</td>
                                            <td>
                                                <button onclick="confirmRestore({{ $libro->IdLibro }})"
                                                    class="btn btn-outline-success btn-sm">Restaurar</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        //Campo de busqueda
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("table tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        function confirmRestore(id) {
            var url = `{{ url('') }}/libros/restore/${id}`;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres restaurar este libro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, restaurar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Restaurado!',
                                'El libro ha sido restaurado.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            if (xhr.status === 409) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se puede restaurar el libro porque ya existe un libro activo con los mismos detalles.',
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Algo salió mal!',
                                })
                            }
                        }
                    });
                }
            })
        }
    </script>
    </div>
@endsection
