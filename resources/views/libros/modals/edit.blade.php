<!-- Modal -->
<div id="ajax-url" data-url="{{ route('buscar') }}"></div>

<div class="modal fade" id="editLibroModal" tabindex="-1" role="dialog" aria-labelledby="editLibroModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLibroModalLabel">Editar Libro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-libro-form" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editTituloLibro">Título del Libro</label>
                                <input type="text" class="form-control" id="editTituloLibro" name="TituloLibro" required>
                                <small id="editErrorTituloLibro" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editAutor">Autor</label>
                                <input type="text" id="editAutor" name="editAutor" class="form-control" required>
                                <input type="hidden" id="editIdAutor" name="IdAutor">
                                <small id="editErrorAutor" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="editCategoria">Categoría</label>
                                <input type="text" id="editCategoria" name="editCategoria" class="form-control" required>
                                <input type="hidden" id="editIdCategoria" name="IdCategoria">
                                <small id="editErrorCategoria" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="editEditorial">Editorial</label>
                                <input type="text" id="editEditorial" name="editEditorial" class="form-control" required>
                                <input type="hidden" id="editIdEditorial" name="IdEditorial">
                                <small id="editErrorEditorial" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="editCantidadLibro">Cantidad de Libros</label>
                                <input type="number" class="form-control" id="editCantidadLibro" name="CantidadLibro" min="0" required>
                                <small id="editErrorCantidadLibro" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="editEstadoLibro">Estado</label>
                                <input type="text" id="editEstadoLibro" name="EstadoLibro" class="form-control" disabled
                                       required>
                                <input type="hidden" id="hiddenEditEstadoLibro" name="EstadoLibro" required>
                                <small id="editErrorEstadoLibro" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editDescripcionLibro">Descripción del Libro</label>
                        <textarea class="form-control" id="editDescripcionLibro" name="DescripcionLibro" required></textarea>
                        <small id="editErrorDescripcionLibro" class="error-message text-danger d-none"></small>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
