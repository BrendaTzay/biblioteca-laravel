<!-- Modal -->
<div class="modal fade" id="editEditorialModal" tabindex="-1" role="dialog" aria-labelledby="editEditorialModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editEditorialModalLabel">Editar Editorial</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="edit-editorial-form" novalidate>
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="editNombreEditorial">Nombre de Editorial</label>
              <input type="text" class="form-control" id="editNombreEditorial" name="NombreEditorial" required>
              <span id="errorNombreEditorialEdit" class="text-danger d-none"></span>
            </div>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
