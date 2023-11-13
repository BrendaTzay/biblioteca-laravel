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
                                    <i class="fas fa-book mr-2"></i>Libros en Préstamo
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
                                        <th>Código</th>
                                        <th>Usuario</th>
                                        <th>Título Libro</th>
                                        <th>Fecha Salida</th>
                                        <th>Fecha Devolución</th>
                                        <th>Estado</th>
                                        <th>Observación</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($prestamosActivos as $prestamo)
                                        <tr>
                                            <td>{{ $prestamo->usuario->CodigoUsuario }}</td>
                                            <td>{{ $prestamo->usuario->NombreUsuario }}
                                                {{ $prestamo->usuario->ApellidoUsuario }}</td>
                                            <td>{{ $prestamo->libro->TituloLibro }}</td>
                                            <td>{{ $prestamo->FechaSalida }}</td>
                                            <td>{{ $prestamo->FechaDevolucion }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $prestamo->EstadoPrestamo == 'Prestado' ? 'bg-danger' : 'bg-success' }}"
                                                    style="font-size: 0.9em">{{ $prestamo->EstadoPrestamo }}</span>
                                            </td>
                                            <td>
                                                <div class="text-truncate" title="{{ $prestamo->ObservacionPrestamo }}"
                                                    style="max-width: 100px;">
                                                    {{ $prestamo->ObservacionPrestamo }}
                                                </div>
                                            </td>
                                            <td>
                                                <button onclick="confirmDevolver({{ $prestamo->IdPrestamo }})"
                                                    class="btn btn-outline-primary btn-sm">Devolver</button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay préstamos por el momento.</td>
                                        </tr>
                                    @endforelse
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

        function confirmDevolver(id) {
            var url = `{{ url('') }}/prestamos/devolver/${id}`;

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres devolver este préstamo?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, devolver!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            Swal.fire(
                                'Devuelto!',
                                'El préstamo ha sido devuelto.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Algo salió mal!',
                            })
                        }
                    });
                }
            })
        }
    </script>
@endsection
