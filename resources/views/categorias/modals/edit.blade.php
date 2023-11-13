<!-- Modal -->
<div class="modal fade" id="editCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="editCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoriaModalLabel">Editar Categoría</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-categoria-form" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="editNombreCategoria">Nombre de la Categoría</label>
                        <input type="text" class="form-control" id="editNombreCategoria" name="NombreCategoria" required>
                        <span id="errorNombreEdit" class="text-danger d-none"></span>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </form>
            </div>
        </div>
    </div>
</div>
