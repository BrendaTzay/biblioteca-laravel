@extends('layouts.app')

@include('editorials.modals.create')
@include('editorials.modals.edit')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-building mr-2"></i>Editoriales
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addEditorialModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="window.location.href='{{ url('/editorials/report') }}'">
                                    <i class="fas fa-file-alt"></i> Generar Reporte
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar editorial...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="w-25">ID</th>
                                        <th class="w-50">Nombre</th>
                                        <th class="w-25">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($editorials as $editorial)
                                        <tr id="editorial-row-{{ $editorial->IdEditorial }}">
                                            <td>{{ $editorial->IdEditorial }}</td>
                                            <td>{{ $editorial->NombreEditorial }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $editorial->IdEditorial }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-md"
                                                        onclick="confirmDelete({{ $editorial->IdEditorial }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-md"
                                                        onclick="generateReport({{ $editorial->IdEditorial }})">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No hay editoriales registradas</td>
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

            //Generador del reporte
            window.generateReport = function(id) {
                window.location.href = `{{ url('/editorials/report') }}/${id}`;
            };

            //campo de busqueda
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#add-editorial-form').submit(function(e) {
                e.preventDefault();
                var nombre = $('#NombreEditorial').val().trim();

                // Validar que el campo no esté vacío
                if (nombre === "") {
                    $('#errorNombreEditorial').text('Debe ingresar el nombre de la editorial').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombreEditorial').addClass('d-none');
                }

                // Validar longitud mínima y máxima
                if (nombre.length < 3) {
                    $('#errorNombreEditorial').text('El nombre debe tener al menos 3 caracteres')
                        .removeClass('d-none');
                    return;
                } else if (nombre.length > 255) {
                    $('#errorNombreEditorial').text('El nombre no debe exceder los 255 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEditorial').addClass('d-none');
                }

                // Convertir a minúsculas y remover acentos
                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");


                $.ajax({
                    type: 'POST',
                    url: '{{ route('editorials.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        NombreEditorial: nombre,
                    },
                    success: function(response) {
                        Swal.fire('Creado!', 'Editorial creada con éxito!', 'success');

                        if ($('table tbody tr').length == 1 && $('table tbody tr td').text() ==
                            'No hay editoriales registradas') {
                            $('table tbody').empty();
                        }

                        var newEditorial = `<tr id="editorial-row-${response.data.IdEditorial}">
                                        <td>${response.data.IdEditorial}</td>
                                        <td>${response.data.NombreEditorial}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-warning" onclick="openEditModal(${response.data.IdEditorial})">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                            <button class="btn btn-danger" onclick="confirmDelete(${response.data.IdEditorial})">
                                                <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <button class="btn btn-info" onclick="generateReport(${response.data.IdEditorial})">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                        </td>
                                    </tr>`;
                        $('table tbody').append(newEditorial);
                        $('#add-editorial-form')[0].reset();
                    },
                    error: function(response) {
                        if (response.status === 409) {
                            Swal.fire('Error', 'Esta editorial ya existe', 'error');
                        }
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo crear la editorial';
                        Swal.fire('Error', errorMessage, 'error');
                        $('#add-editorial-form')[0].reset();
                    }
                });
            });

            window.confirmDelete = function(id) {
                Swal.fire({
                    title: '¿Estás seguro que deseas eliminarlo?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '¡Sí, eliminar!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteEditorial(id);
                    }
                });
            };

            function deleteEditorial(id) {
                $.ajax({
                    type: 'POST',
                    url: `{{ url('/editorials') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        Swal.fire('Eliminado!', 'Editorial eliminada con éxito!', 'success');
                        $(`#editorial-row-${id}`).remove();
                    },
                    error: function(response) {

                        if (response.status === 403) {
                            Swal.fire('Error',
                                'No se puede eliminar esta editorial porque está vinculada a uno o más libros.',
                                'error');
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar la editorial', 'error');

                        }
                    }
                });
            }

            window.openEditModal = function(id) {
                $.ajax({
                    type: 'GET',
                    url: `{{ url('/editorials') }}/${id}/edit`,
                    success: function(response) {
                        if (response.success) {
                            $('#editEditorialModal').modal('show');
                            $('#editNombreEditorial').val(response.data.NombreEditorial);
                            $('#edit-editorial-form').data('id', response.data.IdEditorial);
                        } else {
                            Swal.fire('Error', 'Error al cargar los datos de la editorial',
                                'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al cargar los datos de la editorial', 'error');
                    }
                });
            };

            $('#edit-editorial-form').submit(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var nombre = $('#editNombreEditorial').val().trim();

                // Validaciones
                if (nombre === "") {
                    $('#errorNombreEditorialEdit').text('Debe ingresar el nombre de la editorial')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEditorialEdit').addClass('d-none');
                }

                if (nombre.length < 3 || nombre.length > 255) {
                    $('#errorNombreEditorialEdit').text('El nombre debe tener entre 3 y 255 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEditorialEdit').addClass('d-none');
                }

                var regex = /^[a-zA-Z\s]*$/;
                if (!regex.test(nombre)) {
                    $('#errorNombreEditorialEdit').text('Solo se permiten letras y espacios').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombreEditorialEdit').addClass('d-none');
                }

                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");


                $.ajax({
                    type: 'PUT',
                    url: `{{ url('/editorials') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        NombreEditorial: nombre,
                    },
                    success: function(response) {
                        $('#editEditorialModal').modal('hide');
                        Swal.fire('Actualizado!', 'Editorial actualizada con éxito!',
                            'success');
                        $(`#editorial-row-${id} td:nth-child(2)`).text(nombre);
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo actualizar la editorial';
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });
        });
    </script>
@endsection
