@extends('layouts.app')

@include('prestamos.modals.create')
@include('prestamos.modals.edit')
@include('prestamos.modals.reportemodal')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-exchange-alt mr-2"></i>Préstamos
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addPrestamoModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal"
                                    data-target="#reportePrestamoModal">
                                    Generar Reporte
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar préstamo...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Libro</th>
                                        <th>Fecha Salida</th>
                                        <th>Fecha Devolución</th>
                                        <th>Estado</th>
                                        <th>Observaciones</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($prestamos as $prestamo)
                                        <tr id="prestamo-row-{{ $prestamo->IdPrestamo }}">
                                            <td>{{ $prestamo->IdPrestamo }}</td>
                                            <td>{{ $prestamo->usuario->NombreUsuario }}
                                                {{ $prestamo->usuario->ApellidoUsuario }}</td>
                                            <td>
                                                @if ($prestamo->libro)
                                                    {{ $prestamo->libro->TituloLibro }}
                                                @else
                                                    Libro eliminado
                                                @endif
                                            </td>
                                            <td>{{ $prestamo->FechaSalida }}</td>
                                            <td>{{ $prestamo->FechaDevolucion }}</td>
                                            <td>
                                                @if ($prestamo->EstadoPrestamo == 'Prestado')
                                                    <span class="badge bg-danger">{{ $prestamo->EstadoPrestamo }}</span>
                                                @elseif($prestamo->EstadoPrestamo == 'Devuelto')
                                                    <span class="badge bg-success">{{ $prestamo->EstadoPrestamo }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="text-truncate" title="{{ $prestamo->ObservacionPrestamo }}"
                                                    style="max-width: 100px;">
                                                    {{ $prestamo->ObservacionPrestamo }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $prestamo->IdPrestamo }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-md"
                                                        onclick="generateReport({{ $prestamo->IdPrestamo }})">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay préstamos registrados</td>
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
        $(document).ready(function() {


            //Generacion de reporte
            function generateReport() {
                var reportType = document.getElementById('reportType').value;
                var url = "{{ url('/prestamos/reporte/') }}/" + reportType;
                window.location.href = url;
            }

            //Campo de busqueda
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });

        // Evento que se surge cuando el modal se está mostrando
        $('#addPrestamoModal').on('show.bs.modal', function(e) {
            // Limpiar todos los campos
            $('#CodigoUsuario').val('');
            $('#IdUsuario').val('').hide();
            $('#IdLibro').val('');
            $('#FechaSalida').val('');
            $('#FechaDevolucion').val('');
            $('#ObservacionPrestamo').val('');

            // Limpiar todos los mensajes de error
            $('.error-message').addClass('d-none');
        });

        $('#CodigoUsuario').on('keyup', function() {
            var CodigoUsuario = $(this).val();
            if (CodigoUsuario !== "") {
                $('#errorCodigoUsuario').addClass('d-none');
            } else {
                $('#errorCodigoUsuario').removeClass('d-none');
            }
        });

        //Realizacion de un nuevo prestamo
        $('#add-prestamo-form').submit(function(e) {
            e.preventDefault();
            var idUsuario = $('#IdUsuario').val();
            var idLibro = $('#IdLibro').val();
            var fechaSalida = $('#FechaSalida').val();
            var fechaDevolucion = $('#FechaDevolucion').val();
            var observacionPrestamo = $('#ObservacionPrestamo').val();

            // Validación de CodigoUsuario
            var CodigoUsuario = $('#CodigoUsuario').val();
            if (CodigoUsuario === "") {
                $('#errorCodigoUsuario').text('Debe ingresar un código.');
                $('#errorCodigoUsuario').removeClass('d-none');
                return false;
            } else {
                $('#errorCodigoUsuario').addClass('d-none');
            }

            // Validación de Libro
            var IdLibro = $('#IdLibro').val();
            if (IdLibro === "") {
                $('#errorIdLibro').text('Debe seleccionar un libro.');
                $('#errorIdLibro').removeClass('d-none');
                return false;
            } else {
                $('#errorIdLibro').addClass('d-none');
            }


            // Validación de FechaSalida
            var fechaSalida = $('#FechaSalida').val();
            if (fechaSalida === "") {
                $('#errorFechaSalida').text('Debe seleccionar una fecha de salida.');
                $('#errorFechaSalida').removeClass('d-none');
                return false;
            } else {
                $('#errorFechaSalida').addClass('d-none');
            }

            // Validación de FechaDevolucion
            var fechaDevolucion = $('#FechaDevolucion').val();
            var currentDate = new Date();
            currentDate.setHours(0, 0, 0, 0); // Establecer la hora, minutos y segundos a 0
            var selectedDate = new Date(fechaDevolucion);
            selectedDate.setHours(0, 0, 0, 0); // Establecer la hora, minutos y segundos a 0

            if (fechaDevolucion === "") {
                $('#errorFechaDevolucion').text('Debe seleccionar una fecha de devolución.');
                $('#errorFechaDevolucion').removeClass('d-none');
                return false;
            } else if (selectedDate < currentDate) {
                $('#errorFechaDevolucion').text('La fecha de devolución no puede ser anterior a la fecha actual.');
                $('#errorFechaDevolucion').removeClass('d-none');
                return false;
            } else {
                $('#errorFechaDevolucion').addClass('d-none');
            }


            //Si todas las validaciones estan bien, procede a realizar el prestamo
            var hiddenIdLibro = $('#hiddenIdLibro').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('prestamos.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    IdUsuario: idUsuario,
                    IdLibro: hiddenIdLibro,
                    FechaSalida: fechaSalida,
                    FechaDevolucion: fechaDevolucion,
                    ObservacionPrestamo: observacionPrestamo
                },
                success: function(response) {
                    $('#addPrestamoModal').modal('hide');
                    $('body').removeClass(
                        'modal-open'
                    );
                    $('.modal-backdrop').remove();
                    Swal.fire('Creado!', 'Préstamo creado con éxito!', 'success');

                    if ($('table tbody tr').length == 1 && $('table tbody tr td').text() ==
                        'No hay préstamos registrados') {
                        $('table tbody').empty();
                    }

                    var newPrestamo = `<tr id="prestamo-row-${response.data.IdPrestamo}">
                    <td>${response.data.IdPrestamo}</td>
                    <td>${response.data.usuario.NombreUsuario} ${response.data.usuario.ApellidoUsuario}</td>
                    <td>${response.data.libro.TituloLibro}</td>
                    <td>${response.data.FechaSalida}</td>
                    <td>${response.data.FechaDevolucion}</td>
                    <td>
                        <span class="badge ${response.data.EstadoPrestamo == 'Prestado' ? 'bg-danger' : 'bg-success'}" style="font-size: 0.9em">
                            ${response.data.EstadoPrestamo}
                        </span>
                    </td>
                    <td>
                        <div class="text-truncate" title="${response.data.ObservacionPrestamo}" style="max-width: 100px;">
                            ${response.data.ObservacionPrestamo}
                        </div>
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-outline-warning btn-md" onclick="openEditModal(${response.data.IdPrestamo})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-info btn-md" onclick="generateReport(${response.data.IdPrestamo})">
                                <i class="fas fa-file-pdf"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;


                    $('table tbody').append(newPrestamo);
                    $('#add-prestamo-form')[0].reset();
                },
                error: function(response) {
                    var errorMessage = 'No se puedo crear el préstamos';

                    if (response.responseJSON && response.responseJSON.error) {
                        errorMessage = response.responseJSON.error;
                    }

                    Swal.fire('Error', errorMessage, 'error');
                    $('#add-prestamo-form')[0].reset();
                    $('#IdUsuario').val('');
                    $('#IdLibro').val('');

                }
            });
        });

        window.generateReport = function(id) {
            window.location.href = `{{ url('/prestamos') }}/${id}/reporte`;
        };

        window.openEditModal = function(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('/prestamos') }}/${id}/edit`,
                success: function(response) {
                    if (response.success) {
                        $('#editPrestamoModal').modal('show');
                        $('#editIdUsuario').val(response.data.IdUsuario);
                        $('#editIdLibro').val(response.data.IdLibro);
                        $('#editFechaSalida').val(response.data.FechaSalida);
                        $('#editFechaDevolucion').val(response.data.FechaDevolucion);

                        // Ajustar las opciones del selector basándose en el estado actual
                        var estadoPrestamoSelect = $('#editEstadoPrestamo');
                        estadoPrestamoSelect.empty(); // Limpiar las opciones existentes

                        if (response.data.EstadoPrestamo == 'Prestado') {
                            estadoPrestamoSelect.append('<option value="Prestado">Prestado</option>');
                            estadoPrestamoSelect.append('<option value="Devuelto">Devuelto</option>');
                        } else {
                            estadoPrestamoSelect.append('<option value="Devuelto">Devuelto</option>');
                        }

                        estadoPrestamoSelect.val(response.data
                            .EstadoPrestamo); // Establecer el valor actual

                        $('#editObservacionPrestamo').val(response.data.ObservacionPrestamo);
                        $('#edit-prestamo-form').data('id', response.data.IdPrestamo);
                    } else {
                        Swal.fire('Error', 'Error al cargar los datos del préstamo', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error al cargar los datos del préstamo', 'error');
                }
            });
        };

        $('#edit-prestamo-form').submit(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var idUsuario = $('#editIdUsuario').val();
            var idLibro = $('#editIdLibro').val();
            var fechaSalida = $('#editFechaSalida').val();
            var fechaDevolucion = $('#editFechaDevolucion').val();
            var estadoPrestamo = $('#editEstadoPrestamo').val();
            var observacionPrestamo = $('#editObservacionPrestamo').val();

            $.ajax({
                type: 'PUT',
                url: `{{ url('/prestamos') }}/${id}`,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT',
                    IdUsuario: idUsuario,
                    IdLibro: idLibro,
                    FechaSalida: fechaSalida,
                    FechaDevolucion: fechaDevolucion,
                    EstadoPrestamo: estadoPrestamo,
                    ObservacionPrestamo: observacionPrestamo
                },
                success: function(response) {
                    $('#editPrestamoModal').modal('hide');
                    Swal.fire('Actualizado!', 'Préstamo actualizado con éxito!', 'success');
                    var updatedPrestamo = $(`#prestamo-row-${id}`);
                    updatedPrestamo.find('td:nth-child(2)').text(
                        `${response.data.usuario.NombreUsuario} ${response.data.usuario.ApellidoUsuario}`
                    );
                    updatedPrestamo.find('td:nth-child(3)').text(response.data.libro.TituloLibro);
                    updatedPrestamo.find('td:nth-child(4)').text(response.data.FechaSalida);
                    updatedPrestamo.find('td:nth-child(5)').text(response.data.FechaDevolucion);
                    updatedPrestamo.find('td:nth-child(6)').html(`<span class="badge ${response.data.EstadoPrestamo == 'Prestado' ? 'bg-danger' : 'bg-success'}" style="font-size: 0.9em">
                        ${response.data.EstadoPrestamo}</span>`);

                    updatedPrestamo.find('td:nth-child(7)').html(
                        `<div class="text-truncate" title="${response.data.ObservacionPrestamo}" style="max-width: 100px;">
                            ${response.data.ObservacionPrestamo}
                        </div>`
                    );
                },
                error: function(response) {
                    var errorMessage = response.responseJSON && response.responseJSON
                        .message ? response.responseJSON.message :
                        'No se pudo actualizar el préstamo';
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });
    </script>
@endsection
