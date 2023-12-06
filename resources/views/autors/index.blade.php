@extends('layouts.app')
@include('autors.modals.create')
@include('autors.modals.edit')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-pen mr-2"></i>Autores
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addAutorModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm"
                                    onclick="window.location.href='{{ url('/autors/report') }}'">
                                    <i class="fas fa-file-alt"></i> Generar Reporte Completo
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar autor...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($autors as $autor)
                                        <tr id="autor-row-{{ $autor->IdAutor }}">
                                            <td>{{ $autor->IdAutor }}</td>
                                            <td>{{ $autor->NombreAutor }}</td>
                                            <td>{{ $autor->ApellidoAutor }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $autor->IdAutor }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-md"
                                                        onclick="confirmDelete({{ $autor->IdAutor }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-md"
                                                        onclick="generateReport({{ $autor->IdAutor }})">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No hay autores registrados</td>
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

            // Generar el reporte de un autor especifico
            window.generateReport = function(id) {
                window.location.href = `{{ url('/autors/report') }}/${id}`;
            };

            //campo busqueda
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#add-autor-form').submit(function(e) {
                e.preventDefault();

                var nombre = $('#NombreAutor').val().trim();
                var apellido = $('#ApellidoAutor').val().trim();

                // Validar que los campos no estén vacíos
                if (nombre === "") {
                    $('#errorNombre').text('Debe ingresar el nombre').removeClass('d-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                if (apellido === "") {
                    $('#errorApellido').text('Debe ingresar el apellido').removeClass('d-none');
                    return;
                } else {
                    $('#errorApellido').addClass('d-none');
                }

                // Validar longitud mínima
                if (nombre.length < 3) {
                    $('#errorNombre').text('El nombre debe tener al menos 3 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                if (apellido.length < 4) {
                    $('#errorApellido').text('El apellido debe tener al menos 4 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorApellido').addClass('d-none');
                }

                // Validar que solo se ingresen letras y espacios
                var regex = /^[a-zA-Z\s]*$/;
                if (!regex.test(nombre)) {
                    $('#errorNombre').text('Solo se permiten letras').removeClass('d-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                if (!regex.test(apellido)) {
                    $('#errorApellido').text('Solo se permiten letras').removeClass('d-none');
                    return;
                } else {
                    $('#errorApellido').addClass('d-none');
                }

                // Convertir a minúsculas y remover acentos
                nombre = nombre.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                apellido = apellido.normalize("NFD").replace(/[\u0300-\u036f]/g, "");


                $.ajax({
                    type: 'POST',
                    url: '{{ route('autors.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        NombreAutor: nombre,
                        ApellidoAutor: apellido,
                    },
                    success: function(response) {
                        Swal.fire({
                            title: 'Creado',
                            text: 'Autor creado con éxito',
                            icon: 'success'
                        });

                        var newAutor = `<tr id="autor-row-${response.data.IdAutor}">
                                        <td>${response.data.IdAutor}</td>
                                        <td>${response.data.NombreAutor}</td>
                                        <td>${response.data.ApellidoAutor}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-outline-warning btn-md" onclick="openEditModal(${response.data.IdAutor})">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                            <button class="btn btn-outline-danger btn-md" onclick="confirmDelete(${response.data.IdAutor})">
                                                <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <button class="btn btn-outline-info btn-md" onclick="generateReport(${response.data.IdAutor})">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                        </td>
                                    </tr>`;
                        $('table tbody').append(newAutor);
                        $('#add-autor-form')[0].reset();
                    },
                    error: function(response) {
                        $('#add-autor-form')[0].reset();
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo crear el autor';
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
                        deleteAutor(id);
                    }
                });
            };

            function deleteAutor(id) {
                $.ajax({
                    type: 'POST',
                    url: `{{ url('/autors') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE',
                    },
                    success: function(response) {
                        Swal.fire('Eliminado!', 'Autor eliminado con éxito!', 'success');
                        $(`#autor-row-${id}`).remove();
                    },
                    error: function(response) {

                        if (response.status === 403) {
                            Swal.fire('Error',
                                'No se puede eliminar este autor porque está vinculado a uno o más libros.',
                                'error');
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar el autor', 'error');
                        }
                    }
                });
            }

            window.openEditModal = function(id) {
                $.ajax({
                    type: 'GET',
                    url: `{{ url('/autors') }}/${id}/edit`,
                    success: function(response) {
                        if (response.success) {
                            $('#editAutorModal').modal('show');
                            $('#editNombreAutor').val(response.data.NombreAutor);
                            $('#editApellidoAutor').val(response.data.ApellidoAutor);
                            $('#edit-autor-form').data('id', response.data.IdAutor);
                        } else {
                            Swal.fire('Error', 'Error al cargar los datos del autor', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al cargar los datos del autor', 'error');
                    }
                });
            };

            $('#edit-autor-form').submit(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var nombre = $('#editNombreAutor').val().trim();
                var apellido = $('#editApellidoAutor').val().trim();

                // Validar que los campos no estén vacíos
                if (nombre === "") {
                    $('#errorNombreEdit').text('Debe ingresar el nombre').removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                if (apellido === "") {
                    $('#errorApellidoEdit').text('Debe ingresar el apellido').removeClass('d-none');
                    return;
                } else {
                    $('#errorApellidoEdit').addClass('d-none');
                }

                // Validar longitud mínima
                if (nombre.length < 3) {
                    $('#errorNombreEdit').text('El nombre debe tener al menos 3 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                if (apellido.length < 4) {
                    $('#errorApellidoEdit').text('El apellido debe tener al menos 4 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorApellidoEdit').addClass('d-none');
                }

                // Validar que solo se ingresen letras y espacios
                var regex = /^[a-zA-Z\s]*$/;
                if (!regex.test(nombre)) {
                    $('#errorNombreEdit').text('Solo se permiten letras').removeClass('d-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                if (!regex.test(apellido)) {
                    $('#errorApellidoEdit').text('Solo se permiten letras').removeClass('d-none');
                    return;
                } else {
                    $('#errorApellidoEdit').addClass('d-none');
                }

                // Convertir a minúsculas y remover acentos
                nombre = nombre.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                apellido = apellido.normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                $.ajax({
                    type: 'PUT',
                    url: `{{ url('/autors') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        NombreAutor: nombre,
                        ApellidoAutor: apellido,
                    },
                    success: function(response) {
                        $('#editAutorModal').modal('hide');
                        Swal.fire('Actualizado!', 'Autor actualizado con éxito!', 'success');
                        $(`#autor-row-${id} td:nth-child(2)`).text(nombre);
                        $(`#autor-row-${id} td:nth-child(3)`).text(apellido);
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo actualizar el autor';
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            let selectedIdAutor = null;
        });
    </script>
@endsection
