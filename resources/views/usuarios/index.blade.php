@extends('layouts.app')
@include('usuarios.modals.create')
@include('usuarios.modals.edit')
@include('usuarios.modals.reportemoda')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0"> <!-- Título con estilo de Bootstrap para mantener la consistencia -->
                                    <i class="fa fa-user mr-2"></i>Usuarios
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addUsuarioModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal"
                                    data-target="#reportModal">
                                    Generar Reporte
                                </button>
                            </div>
                            <div class="col-md-4">
                                <input type="text" id="search" class="form-control" placeholder="Buscar usuario...">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Código</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Dirección</th>
                                        <th>Grado</th>
                                        <th>Teléfono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($usuarios as $usuario)
                                        <tr id="usuario-row-{{ $usuario->IdUsuario }}">
                                            <td>{{ $usuario->CodigoUsuario }}</td>
                                            <td>{{ $usuario->NombreUsuario }}</td>
                                            <td>{{ $usuario->ApellidoUsuario }}</td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 150px;">
                                                    {{ $usuario->DireccionUsuario }}</div>
                                            </td>
                                            <td>{{ $usuario->GradoUsuario }}</td>
                                            <td>{{ $usuario->TelefonoUsuario }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="javascript:void(0)" class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $usuario->IdUsuario }})">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger btn-md"
                                                        onclick="confirmDelete({{ $usuario->IdUsuario }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <button class="btn btn-outline-info btn-md"
                                                        onclick="generateReport({{ $usuario->IdUsuario }})">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No hay usuarios registrados</td>
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
        //Generador de reporte por Dirección
        function toggleDireccionField() {
            let reportType = document.getElementById('reportType').value;
            let direccionField = document.getElementById('direccionField');
            let gradoField = document.getElementById('gradoField');

            if (reportType === 'direccion') {
                direccionField.style.display = 'block';
                gradoField.style.display = 'none';
            } else if (reportType === 'estudiante') {
                gradoField.style.display = 'block';
                direccionField.style.display = 'none';
            } else if (reportType == 'comunidad') {
                direccionField.style.display = 'none';
                gradoField.style.display = 'none';
            }
        }

        function generateCustomReport() {
            let reportType = document.getElementById('reportType').value;
            let direccion = document.getElementById('direccion').value;
            let grado = document.getElementById('grado').value;

            if (reportType === 'direccion' && direccion) {
                window.location.href = `{{ url('/usuarios/customReport') }}?tipo=direccion&valor=${direccion}`;
            } else if (reportType === 'estudiante' && grado) {
                window.location.href = `{{ url('/usuarios/customReport') }}?tipo=estudiante&valor=${grado}`;
            } else if (reportType === 'comunidad') {
                window.location.href = `{{ url('/usuarios/customReport') }}?tipo=comunidad`;
            } else if (reportType === 'todos') {
                window.location.href = `{{ url('/usuarios/customReport') }}?tipo=todos`;
            }
        }

        $('#reportModal').on('hidden.bs.modal', function(e) {
            // Restablecer el selector
            $('#reportType').val('');

            // Ocultar los campos
            $('#direccionField').hide();
            $('#gradoField').hide();
        });



        $(document).ready(function() {

            //generador de reporte usuario
            window.generateReport = function(id) {
                window.location.href = `{{ url('/usuarios/report') }}/${id}`;
            };

            //campo de busqueda
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            //Radio para la selección de tipo de usuario
            $('input[type=radio][name=tipoUsuario]').change(function() {
                if (this.value == 'Escuela') {
                    $('#grado-group').show();
                    $('#GradoUsuario').attr('required', true);
                } else {
                    $('#grado-group').hide();
                    $('#GradoUsuario').removeAttr('required');
                }
            });

            $('input[type=radio][name=editTipoUsuario]').change(function() {
                if (this.value == 'Escuela') {
                    $('#edit-grado-group').show();
                    $('#editGradoUsuario').attr('required', true);
                } else {
                    $('#edit-grado-group').hide();
                    $('#editGradoUsuario').removeAttr('required');
                    $('#editGradoUsuario').val(
                        'No aplica');
                }
            });

            $('#add-usuario-form').submit(function(e) {
                e.preventDefault();

                var tipoUsuario = $("input[name='tipoUsuario']:checked").val();
                var grado = (tipoUsuario == 'Comunidad') ? 'No aplica' : $('#GradoUsuario').val();

                var nombre = $('#NombreUsuario').val().trim();
                var apellido = $('#ApellidoUsuario').val().trim();
                var direccion = $('#DireccionUsuario').val().trim();
                var telefono = $('#TelefonoUsuario').val().trim();
                var codigo = nombre.substring(0, 2) + apellido + $('#IdUsuario').val();

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

                if (direccion === "") {
                    $('#errorDireccion').text('Debe ingresar la dirección').removeClass('d-none');
                    return;
                } else {
                    $('#errorDireccion').addClass('d-none');
                }

                if (telefono === "") {
                    $('#errorTelefono').text('Debe ingresar el teléfono').removeClass('d-none');
                    return;
                } else {
                    $('#errorTelefono').addClass('d-none');
                }

                // Validar longitud mínima
                if (nombre.length < 3) {
                    $('#errorNombre').text('El nombre debe tener al menos 3 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombre').addClass('d-none');
                }

                if (apellido.length < 3) {
                    $('#errorApellido').text('El apellido debe tener al menos 3 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorApellido').addClass('d-none');
                }

                // Validar longitud mínima y máxima
                if (direccion.length < 5 || direccion.length > 100) {
                    $('#errorDireccion').text('La dirección debe tener entre 5 y 100 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorDireccion').addClass('d-none');
                }

                // Validar caracteres permitidos
                var regexDireccion = /^[a-zA-Z0-9\s\.,\-]*$/;
                if (!regexDireccion.test(direccion)) {
                    $('#errorDireccion').text('Caracteres inválidos en la dirección').removeClass('d-none');
                    return;
                } else {
                    $('#errorDireccion').addClass('d-none');
                }

                // Validar que el teléfono solo contenga números y tenga 8 dígitos
                var regexTelefono = /^[0-9]{8}$/;
                if (!regexTelefono.test(telefono)) {
                    $('#errorTelefono').text('El teléfono debe contener solo 8 números').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorTelefono').addClass('d-none');
                }

                // Validar que solo se ingresen letras y espacios
                var regex = /^[a-zA-ZñÑ\s]*$/;
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

                //ingresa los datos en minuscula
                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                apellido = apellido.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                direccion = direccion.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                $.ajax({
                    type: 'POST',
                    url: '{{ route('usuarios.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        NombreUsuario: nombre,
                        ApellidoUsuario: apellido,
                        DireccionUsuario: direccion,
                        GradoUsuario: grado,
                        TelefonoUsuario: telefono,
                        CodigoUsuario: codigo,
                    },
                    success: function(response) {
                        Swal.fire('Creado!', 'Usuario creado con éxito!', 'success');
                        if ($('table tbody tr').length == 1 && $('table tbody tr td').text() ==
                            'No hay usuarios registrados') {
                            $('table tbody').empty();
                        }

                        var newUsuario = `<tr id="usuario-row-${response.data.IdUsuario}">
                                        <td>${response.data.CodigoUsuario}</td>
                                        <td>${response.data.NombreUsuario}</td>
                                        <td>${response.data.ApellidoUsuario}</td>
                                        <td>${response.data.DireccionUsuario}</td>
                                        <td>${response.data.GradoUsuario}</td>
                                        <td>${response.data.TelefonoUsuario}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-warning" onclick="openEditModal(${response.data.IdUsuario})">
                                                <i class="fas fa-edit"></i>
                                                </a>
                                            <button class="btn btn-danger" onclick="confirmDelete(${response.data.IdUsuario})">
                                                <i class="fas fa-trash-alt"></i>
                                                </button>
                                            <button class="btn btn-primary" onclick="generateReport(${response.data.IdUsuario})">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>  
                                        </td>
                                    </tr>`;
                        $('table tbody').append(newUsuario);
                        $('#add-usuario-form')[0].reset();
                    },
                    error: function(response) {
                        $('#add-autor-form')[0].reset();
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo crear el usuario';
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            window.openEditModal = function(id) {
                $.ajax({
                    type: 'GET',
                    url: `{{ url('/usuarios') }}/${id}/edit`,
                    success: function(response) {
                        if (response.success) {

                            $('#editUsuarioModal').modal('show');
                            $('#editNombreUsuario').val(response.data.NombreUsuario);
                            $('#editApellidoUsuario').val(response.data.ApellidoUsuario);
                            $('#editDireccionUsuario').val(response.data.DireccionUsuario);
                            $('#editTelefonoUsuario').val(response.data.TelefonoUsuario);
                            $('#edit-usuario-form').data('id', response.data.IdUsuario);

                            // Establecer el radio button y la visibilidad del campo Grado basado en el tipo de usuario
                            if (response.data.GradoUsuario != 'No aplica') {
                                $('#editEscuela').prop('checked', true);
                                $('#edit-grado-group').show();
                                $('#editGradoUsuario').val(response.data.GradoUsuario).attr(
                                    'required', true);
                            } else {
                                $('#editComunidad').prop('checked', true);
                                $('#edit-grado-group').hide();
                                $('#editGradoUsuario').removeAttr('required');
                            }
                        } else {
                            Swal.fire('Error', 'Error al cargar los datos del usuario', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al cargar los datos del usuario', 'error');
                    }
                });
            };

            $('#edit-usuario-form').submit(function(e) {
                e.preventDefault();
                var id = $(this).data(
                    'id'); // Asegúrate de tener un campo oculto o alguna manera de obtener el IdUsuario
                var nombre = $('#editNombreUsuario').val();
                var apellido = $('#editApellidoUsuario').val();
                var direccion = $('#editDireccionUsuario').val();
                var grado = $('#editGradoUsuario').val();
                var telefono = $('#editTelefonoUsuario').val();
                var codigo = nombre.substring(0, 2) + apellido + id;

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

                if (direccion === "") {
                    $('#errorDireccionEdit').text('Debe ingresar la dirección').removeClass('d-none');
                    return;
                } else {
                    $('#errorDireccionEdit').addClass('d-none');
                }

                if (telefono === "") {
                    $('#errorTelefonoEdit').text('Debe ingresar el teléfono').removeClass('d-none');
                    return;
                } else {
                    $('#errorTelefonoEdit').addClass('d-none');
                }

                // Validar longitud mínima
                if (nombre.length < 3) {
                    $('#errorNombreEdit').text('El nombre debe tener al menos 3 caracteres').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorNombreEdit').addClass('d-none');
                }

                if (apellido.length < 3) {
                    $('#errorApellidoEdit').text('El apellido debe tener al menos 3 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorApellidoEdit').addClass('d-none');
                }


                // Validar longitud mínima y máxima
                if (direccion.length < 5) {
                    $('#errorDireccionEdit').text('La dirección debe tener al menos 5 caracteres')
                        .removeClass('d-none');
                    return;
                } else if (direccion.length > 100) {
                    $('#errorDireccionEdit').text('La dirección no debe exceder los 100 caracteres')
                        .removeClass('d-none');
                    return;
                } else {
                    $('#errorDireccionEdit').addClass('d-none');
                }

                // Validar caracteres permitidos
                var regexDireccion = /^[a-zA-Z0-9\s\.,\-]*$/;
                if (!regexDireccion.test(direccion)) {
                    $('#errorDireccionEdit').text('Caracteres inválidos en la dirección').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorDireccionEdit').addClass('d-none');
                }

                // Validar que el teléfono solo contenga números y tenga 8 dígitos
                var regexTelefono = /^[0-9]{8}$/;
                if (!regexTelefono.test(telefono)) {
                    $('#errorTelefonoEdit').text('El teléfono debe contener solo 8 números').removeClass(
                        'd-none');
                    return;
                } else {
                    $('#errorTelefonoEdit').addClass('d-none');
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

                nombre = nombre.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                apellido = apellido.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                direccion = direccion.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");

                $.ajax({
                    type: 'PUT',
                    url: `{{ url('/usuarios') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        NombreUsuario: nombre,
                        ApellidoUsuario: apellido,
                        DireccionUsuario: direccion,
                        GradoUsuario: grado,
                        TelefonoUsuario: telefono,
                        CodigoUsuario: codigo,
                    },
                    success: function(response) {
                        $('#editUsuarioModal').modal('hide');
                        Swal.fire('Actualizado!', 'Usuario actualizado con éxito!', 'success');
                        $(`#usuario-row-${id} td:nth-child(1)`).text(codigo);
                        $(`#usuario-row-${id} td:nth-child(2)`).text(nombre);
                        $(`#usuario-row-${id} td:nth-child(3)`).text(apellido);
                        $(`#usuario-row-${id} td:nth-child(4)`).text(direccion);
                        $(`#usuario-row-${id} td:nth-child(5)`).text(grado);
                        $(`#usuario-row-${id} td:nth-child(6)`).text(telefono);
                    },
                    error: function(response) {
                        var errorMessage = response.responseJSON && response.responseJSON
                            .message ? response.responseJSON.message :
                            'No se pudo actualizar el usuario';
                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            });

            window.confirmDelete = function(id) {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, bórralo!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: `{{ url('/usuarios') }}/${id}`,
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                Swal.fire(
                                    'Eliminado!',
                                    'El usuario ha sido eliminado.',
                                    'success'
                                );
                                $(`#usuario-row-${id}`).remove();
                            },
                            error: function(xhr) {
                                if (xhr.status === 409) {
                                    Swal.fire(
                                        'Error',
                                        xhr.responseJSON.error,
                                        'error'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'No se pudo eliminar el usuario.',
                                        'error'
                                    );
                                }
                            }
                        });
                    }
                });
            };
        });
    </script>
@endsection
