@extends('layouts.app')

@include('libros.modals.create', [
    'autores' => $autores,
    'categorias' => $categorias,
    'editoriales' => $editoriales,
])
@include('libros.modals.edit', [
    'autores' => $autores,
    'categorias' => $categorias,
    'editoriales' => $editoriales,
])

@include('libros.modals.reportmodal')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h5 class="mb-0">
                                    <i class="fas fa-book mr-2"></i>Libros
                                </h5>
                            </div>
                            <div class="col-auto ml-auto">
                                <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal"
                                    data-target="#addLibroModal">
                                    <i class="fas fa-plus"></i> Añadir
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm ml-2" data-toggle="modal"
                                    data-target="#reportModal">
                                    Generar Reporte
                                </button>
                            </div>
                            <div class="col-md-4">
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
                                    @forelse($libros as $libro)
                                        <tr id="libro-row-{{ $libro->IdLibro }}">
                                            <td>{{ $libro->IdLibro }}</td>
                                            <td>{{ $libro->TituloLibro }}</td>
                                            <td>{{ $libro->autor->NombreAutor }} {{ $libro->autor->ApellidoAutor }}</td>
                                            <td>{{ $libro->categoria->NombreCategoria }}</td>
                                            <td>{{ $libro->editorial->NombreEditorial }}</td>
                                            <td>{{ $libro->CantidadLibro }}</td>
                                            <td>
                                                <div class="text-truncate" title="{{ $libro->DescripcionLibro }}"
                                                    style="max-width: 100px;">
                                                    {{ $libro->DescripcionLibro }}
                                                </div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge {{ $libro->EstadoLibro == 'Disponible' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $libro->EstadoLibro }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-outline-warning btn-md"
                                                        onclick="openEditModal({{ $libro->IdLibro }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-outline-danger btn-md"
                                                        onclick="confirmDelete({{ $libro->IdLibro }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No hay libros registrados</td>
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
        function generateReport() {
            var reportType = document.getElementById('reportType').value;
            var url = "{{ url('/libros/reporte/') }}/" + reportType;
            window.location.href = url;
        }
        // Campo de búsqueda
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Función para validar campos
        function validarCampo(campoId, errorId, mensajeError) {
            let valor = $(campoId).val();

            if (valor === "") {
                $(errorId).text(mensajeError);
                $(errorId).removeClass('d-none');
                return false;
            } else if ((campoId === '#CantidadLibro' || campoId === '#editCantidadLibro') && parseInt(valor) < 1) {
                $(errorId).text('Debe ingresar al menos 1 cantidad de libro y que no sea negativa.');
                $(errorId).removeClass('d-none');
                return false;
            }

            $(errorId).addClass('d-none');
            return true;
        }


        $('#addLibroModal').on('show.bs.modal', function(e) {
            $('.error-message').addClass('d-none');
            $('.error-message').text('');
        });

        $('#add-libro-form').submit(function(e) {
            e.preventDefault();

            const esTituloValido = validarCampo('#TituloLibro', '#errorTituloLibro',
                'Ingrese el título del libro.');
            const esAutorValido = validarCampo('#autor', '#errorAutor', 'Debe ingresar un autor.');
            const esCategoriaValida = validarCampo('#categoria', '#errorCategoria',
                'Debe ingresar una categoría.');
            const esEditorialValida = validarCampo('#editorial', '#errorEditorial',
                'Debe ingresar una editorial.');
            const esCantidadValida = validarCampo('#CantidadLibro', '#errorCantidadLibro',
                'Debe ingresar la cantidad del libro.');
            const esDescripcionValida = validarCampo('#DescripcionLibro', '#errorDescripcionLibro',
                'Debe ingresar una descripción del libro.');

            if (esTituloValido && esAutorValido && esCategoriaValida && esEditorialValida && esCantidadValida &&
                esDescripcionValida) {
                var titulo = $('#TituloLibro').val();
                var idAutor = $('#IdAutor').val();
                var idCategoria = $('#IdCategoria').val();
                var idEditorial = $('#IdEditorial').val();
                var cantidad = $('#CantidadLibro').val();
                var descripcion = $('#DescripcionLibro').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('libros.store') }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        TituloLibro: titulo,
                        IdAutor: idAutor,
                        IdCategoria: idCategoria,
                        IdEditorial: idEditorial,
                        CantidadLibro: cantidad,
                        DescripcionLibro: descripcion,
                    },
                    success: function(response) {
                        Swal.fire('Creado', '¡Libro creado con éxito!', 'success');

                        var estadoLibro = response.data.EstadoLibro || 'Disponible';
                        var estadoClass = estadoLibro == 'Disponible' ? 'bg-success' : 'bg-danger';

                        if ($('table tbody tr').length == 1 && $(
                                'table tbody tr td').text() ==
                            'No hay libros registrados') {
                            $('table tbody').empty();
                        }

                        var Libro = response.data;
                        var newLibro = `<tr id="libro-row-${response.data.IdLibro}">
                    <td>${response.data.IdLibro}</td>
                    <td>${response.data.TituloLibro}</td>
                    <td>${response.data.autor.NombreAutor} ${response.data.autor.ApellidoAutor}</td>
                    <td>${response.data.categoria.NombreCategoria}</td>
                    <td>${response.data.editorial.NombreEditorial}</td>
                    <td>${response.data.CantidadLibro}</td>
                    <td>
                        <div class="text-truncate" title="${response.data.DescripcionLibro}" style="max-width: 100px;">
                            ${response.data.DescripcionLibro}
                        </div>
                    </td>
                    <td>
                        <span class="badge ${estadoClass}" style="font-size: 0.9em">
                        ${estadoLibro}
                         </span>                             
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                        <a href="javascript:void(0);" class="btn btn-warning mr-2" onclick="openEditModal(${response.data.IdLibro})">
                            <i class="fas fa-edit"></i>    
                            </a>
                        <button class="btn btn-danger" onclick="confirmDelete(${response.data.IdLibro})">
                            <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>`;

                        $('table tbody').append(newLibro);
                        $('#add-libro-form')[0].reset();
                    },
                    error: function(response) {
                        if (response.status === 409) {
                            Swal.fire('Error', response.responseJSON.message, 'error');
                        } else {
                            Swal.fire('Error', 'No se pudo crear el libro.', 'error');
                        }
                    }
                });
            }
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
                    deleteLibro(id);
                }
            });
        };

        function deleteLibro(id) {
            $.ajax({
                type: 'POST',
                url: `{{ url('/libros') }}/${id}`,
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE',
                },
                success: function(response) {
                    Swal.fire('Eliminado!', 'Libro eliminado con éxito!', 'success');
                    $(`#libro-row-${id}`).remove();
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        }

        window.openEditModal = function(id) {
            $.ajax({
                type: 'GET',
                url: `{{ url('/libros') }}/${id}/edit`,
                success: function(response) {
                    if (response.success) {
                        $('#editLibroModal').modal('show');
                        $('#editTituloLibro').val(response.data.TituloLibro);

                        // Actualizar los campos de texto con los nombres del autor, categoría y editorial
                        $('#editAutor').val(response.data.autor.NombreAutor + ' ' + response.data.autor
                            .ApellidoAutor);
                        $('#editCategoria').val(response.data.categoria.NombreCategoria);
                        $('#editEditorial').val(response.data.editorial.NombreEditorial);

                        // Continúa estableciendo los valores de los campos ocultos
                        $('#editIdAutor').val(response.data.IdAutor);
                        $('#editIdCategoria').val(response.data.IdCategoria);
                        $('#editIdEditorial').val(response.data.IdEditorial);
                        $('#editCantidadLibro').val(response.data.CantidadLibro);
                        $('#editDescripcionLibro').val(response.data.DescripcionLibro);
                        $('#editEstadoLibro').val(response.data.EstadoLibro);
                        $('#hiddenEditEstadoLibro').val(response.data.EstadoLibro);
                        $('#edit-libro-form').data('id', response.data.IdLibro);

                    } else {
                        Swal.fire('Error', 'Error al cargar los datos del libro',
                            'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error al cargar los datos del libro',
                        'error');
                }
            });
        };

        $('#editLibroModal').on('show.bs.modal', function(e) {
            $('.error-message').addClass('d-none');
            $('.error-message').text('');
        });

        $('#edit-libro-form').submit(function(e) {
            e.preventDefault();

            const esTituloValido = validarCampo('#editTituloLibro', '#editErrorTituloLibro',
                'Ingrese el título del libro.');
            const esAutorValido = validarCampo('#editAutor', '#editErrorAutor', 'Debe ingresar un autor.');
            const esCategoriaValida = validarCampo('#editCategoria', '#editErrorCategoria',
                'Debe ingresar una categoría.');
            const esEditorialValida = validarCampo('#editEditorial', '#editErrorEditorial',
                'Debe ingresar una editorial.');
            const esCantidadValida = validarCampo('#editCantidadLibro', '#editErrorCantidadLibro',
                'Debe ingresar la cantidad del libro.');
            const esDescripcionValida = validarCampo('#editDescripcionLibro', '#editErrorDescripcionLibro',
                'Debe ingresar una descripción del libro.');

            if (esTituloValido && esAutorValido && esCategoriaValida && esEditorialValida && esCantidadValida &&
                esDescripcionValida) {

                var id = $(this).data('id');
                var titulo = $('#editTituloLibro').val();
                var idAutor = $('#editIdAutor').val();
                var idCategoria = $('#editIdCategoria').val();
                var idEditorial = $('#editIdEditorial').val();
                var cantidad = $('#editCantidadLibro').val();
                var descripcion = $('#editDescripcionLibro').val();
                var estado = $('#editEstadoLibro').val();

                $.ajax({
                    type: 'PUT',
                    url: `{{ url('/libros') }}/${id}`,
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        TituloLibro: titulo,
                        IdAutor: idAutor,
                        IdCategoria: idCategoria,
                        IdEditorial: idEditorial,
                        CantidadLibro: cantidad,
                        DescripcionLibro: descripcion,
                        EstadoLibro: estado
                    },
                    success: function(response) {
                        $('#editLibroModal').modal('hide');
                        Swal.fire('Actualizado!', 'Libro actualizado con éxito!',
                            'success');
                        var updatedLibro = $(`#libro-row-${id}`);
                        updatedLibro.find('td:nth-child(2)').text(titulo);
                        updatedLibro.find('td:nth-child(3)').text(
                            `${response.data.autor.NombreAutor} ${response.data.autor.ApellidoAutor}`
                        );
                        updatedLibro.find('td:nth-child(4)').text(response.data.categoria
                            .NombreCategoria);
                        updatedLibro.find('td:nth-child(5)').text(response.data.editorial
                            .NombreEditorial);
                        updatedLibro.find('td:nth-child(6)').text(cantidad);
                        updatedLibro.find('td:nth-child(7)').html(
                            `<div class="text-truncate" title="${descripcion}" style="max-width: 100px;">
                                ${descripcion}
                            </div>`
                        );
                        updatedLibro.find('td:nth-child(8)').html(`<span class="badge ${response.data.EstadoLibro == 'Disponible' ? 'bg-success' : 'bg-danger'}" style="font-size: 0.9em">
                            ${response.data.EstadoLibro}</span>`);
                    },
                    error: function(response) {
                        if (response.status === 409) {
                            Swal.fire('Error', response.responseJSON.message, 'error');
                        } else {
                            var errorMessage = response.responseJSON && response.responseJSON.message ?
                                response.responseJSON.message : 'No se pudo actualizar el libro';
                            Swal.fire('Error', errorMessage, 'error');
                        }

                    }
                });
            }
        });
    </script>
@endsection
