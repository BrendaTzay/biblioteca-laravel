<!-- Modal -->
<div id="ajax-url" data-url="{{ route('buscar') }}"></div>

<div class="modal fade" id="addLibroModal" tabindex="-1" role="dialog" aria-labelledby="addLibroModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Aumenta el tamaño del modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLibroModalLabel">Agregar Libro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-libro-form" novalidate>
                    @csrf
                    <div class="row mb-3"> <!-- Añade margen inferior a la fila -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="TituloLibro">Título del Libro</label>
                                <input type="text" class="form-control" id="TituloLibro" name="TituloLibro" required>
                                <small id="errorTituloLibro" class="error-message text-danger d-none"></small>                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="IdAutor">Autor</label>
                                <input type="text" id="autor" name="autor" class="form-control" required>
                                <input type="hidden" id="IdAutor" name="IdAutor" value="">
                                <small id="errorAutor" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="IdCategoria">Categoría</label>
                                <input type="text" id="categoria" name="categoria" class="form-control" required>
                                <input type="hidden" id="IdCategoria" name="IdCategoria" value="">
                                <small id="errorCategoria" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="IdEditorial">Editorial</label>
                                <input type="text" id="editorial" name="editorial" class="form-control" required>
                                <input type="hidden" id="IdEditorial" name="IdEditorial" value="">
                                <small id="errorEditorial" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="CantidadLibro">Cantidad de Libros</label>
                                <input type="number" class="form-control" id="CantidadLibro" name="CantidadLibro" min="0" required>
                                <small id="errorCantidadLibro" class="error-message text-danger d-none"></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3"> 
                        <label for="DescripcionLibro">Descripción del Libro</label>
                        <textarea class="form-control" id="DescripcionLibro" name="DescripcionLibro" required></textarea>
                        <small id="errorDescripcionLibro" class="error-message text-danger d-none"></small>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        data-backdrop="false">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>



