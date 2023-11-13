@extends('layouts.app')
@include('categorias.modals.create')
@include('categorias.modals.edit')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-layer-group mr-2"></i>Categorías
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addCategoriaModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="window.location.href='{{ url('/categorias/report') }}'">
                                    <i class="fas fa-file-alt"></i> Generar Reporte
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar categoría...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="w-25">ID</th>
                                        <th class="w-50">Nombre de Categoría</th>
                                        <th class="w-25">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categorias as $categoria)
                                        <tr id="categoria-row-{{ $categoria->IdCategoria }}">
                                            <td>{{ $categoria->IdCategoria }}</td>
                                            <td>{{ $categoria->NombreCategoria }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $categoria->IdCategoria }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-md"
                                                        onclick="confirmDelete({{ $categoria->IdCategoria }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-md"
                                                        onclick="generateReport({{ $categoria->IdCategoria }})">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No hay categorías registradas</td>
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

            //generar el reporte
            window.generateReport = function(id) {
                window.location.href = `{{ url('/categorias/report') }}/${id}`;
            };

            // Generar el reporte de todas las categorías
            window.generateFullReport = function() {
                window.location.href = `{{ url('/categorias/report') }}`;
            };


            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#add-categoria-form').submit(function(e) {
                e.preventDefault();
                var nombre = $('#NombreCategoria').val().trim();

                // Validar que el campo no esté vacío
                if (nombre === "") {
                    $('#errorNombre').text('Debe ingresar el nombre de la categoria').removeClass('d-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                // Validar longitud mínima y máxima
                if (nombre.length < 3) {
                    $('#errorNombre').text('El nombre de la categoria debe tener al menos 3 caracteres')
                        .removeClass('d-none');
                    return;
                } else if (nombre.length > 255) {
                    $('#errorNombre').text('El nombre de la editorial no debe exceder los 255 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");


                $.ajax({
                    type: 'POST',
                    url: '{{ route('categorias.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        NombreCategoria: nombre,
                    },
                    success: function(response) {
                        Swal.fire('Creado!', 'Categoría creada con éxito!', 'success');

                        if ($('table tbody tr').length == 1 && $('table tbody tr td').text() ==
                            'No hay categorías registradas') {
                            $('table tbody').empty();
                        }

                        var newCategoria = `<tr id="categoria-row-${response.data.IdCategoria}">
                                            <td>${response.data.IdCategoria}</td>
                                            <td>${response.data.NombreCategoria}</td>
                                            <td>
                                                <a href="javascript:void(0);" class="btn btn-warning" onclick="openEditModal(${response.data.IdCategoria})">
                                                    <i class="fas fa-edit"></i>
                                                    </a>
                                                <button class="btn btn-danger" onclick="confirmDelete(${response.data.IdCategoria})">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                    <button class="btn btn-info" onclick="generateReport(${response.data.IdCategoria})">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                            </td>
                                        </tr>`;
                        $('table tbody').append(newCategoria);
                        $('#add-categoria-form')[0].reset();
                    },
                    error: function(response) {
                        $('#add-categoria-form')[0].reset();
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ?
                            response.responseJSON.message :
                            'Ocurrió un error inesperado.';
                        Swal.fire('Error', errorMessage, 'error');
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
                        deleteCategoria(id);
                    }
                });
            };

            function deleteCategoria(id) {
                $.ajax({
                    type: 'POST',
                    url: `{{ url('/categorias') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        Swal.fire('Eliminado!', 'Categoría eliminada con éxito!', 'success');
                        $(`#categoria-row-${id}`).remove();
                    },
                    error: function(response) {

                        if (response.status === 403) {
                            Swal.fire('Error',
                                'No se puede eliminar esta categoría porque está vinculada a uno o más libros.',
                                'error');
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar la categoría', 'error');
                        }
                    }
                });
            }

            window.openEditModal = function(id) {
                $.ajax({
                    type: 'GET',
                    url: `{{ url('/categorias') }}/${id}/edit`,
                    success: function(response) {
                        if (response.success) {
                            $('#editCategoriaModal').modal('show');
                            $('#editNombreCategoria').val(response.data.NombreCategoria);
                            $('#edit-categoria-form').data('id', response.data.IdCategoria);
                        } else {
                            Swal.fire('Error', 'Error al cargar los datos de la categoría',
                                'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al cargar los datos de la categoría', 'error');
                    }
                });
            };

            $('#edit-categoria-form').submit(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var nombre = $('#editNombreCategoria').val().trim();

                // Validar que el campo no esté vacío
                if (nombre === "") {
                    $('#errorNombreEdit').text('Debe ingresar el nombre de la categoría').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                // Validar longitud mínima y máxima
                if (nombre.length < 3) {
                    $('#errorNombreEdit').text('El nombre de la categoría debe tener al menos 3 caracteres')
                        .removeClass('d-none');
                    return;
                } else if (nombre.length > 255) {
                    $('#errorNombreEdit').text(
                            'El nombre de la categoría no debe exceder los 255 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                // Validar que solo se ingresen letras, números y espacios
                var regex = /^[a-zA-Z0-9\s]+$/;
                if (!regex.test(nombre)) {
                    $('#errorNombreEdit').text(
                            'El nombre de la categoría solo debe contener letras, números y espacios')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                // Convertir a minúsculas y remover acentos
                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                $.ajax({
                    type: 'PUT',
                    url: `{{ url('/categorias') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        NombreCategoria: nombre,
                    },
                    success: function(response) {
                        $('#editCategoriaModal').modal('hide');
                        Swal.fire('Actualizado!', 'Categoría actualizada con éxito!',
                            'success');
                        $(`#categoria-row-${id} td:nth-child(2)`).text(nombre);
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo actualizar la categoría';
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });
        });
    </script>
@endsection
