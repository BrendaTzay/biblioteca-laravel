<!-- Modal -->
<div class="modal fade" id="addCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="addCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoriaModalLabel">Agregar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-categoria-form" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="NombreCategoria">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="NombreCategoria" name="NombreCategoria" required>
                        <small id="errorNombre" class="error-message text-danger d-none"></small>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" data-backdrop="false">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
