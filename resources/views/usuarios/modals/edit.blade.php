<!-- Modal -->
<div class="modal fade" id="editUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="editUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUsuarioModalLabel">Editar Usuario</h5>
        <div class="ml-auto mt-n2"> <!-- Ajuste de margen para alinear los radios con el título -->
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="editTipoUsuario" id="editComunidad" value="Comunidad" required>
            <label class="form-check-label" for="editComunidad">Comunidad</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="editTipoUsuario" id="editEscuela" value="Escuela" required>
            <label class="form-check-label" for="editEscuela">Escuela</label>
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-usuario-form" novalidate>
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="editNombreUsuario">Nombre</label>
            <input type="text" class="form-control" id="editNombreUsuario" name="NombreUsuario" required>
            <small id="errorNombreEdit" class="error-message text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label for="editApellidoUsuario">Apellido</label>
            <input type="text" class="form-control" id="editApellidoUsuario" name="ApellidoUsuario" required>
            <small id="errorApellidoEdit" class="error-message text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label for="editDireccionUsuario">Dirección</label>
            <input type="text" class="form-control" id="editDireccionUsuario" name="DireccionUsuario" required>
            <small id="errorDireccionEdit" class="error-message text-danger d-none"></small>
          </div>
          <div class="form-group">
            <label for="editTelefonoUsuario">Telefono</label>
            <input type="text" class="form-control" id="editTelefonoUsuario" name="TelefonoUsuario" required>
            <small id="errorTelefonoEdit" class="error-message text-danger d-none"></small>
          </div>
          <div class="form-group" id="edit-grado-group" style="display:none;">
              <label for="editGradoUsuario">Grado</label>
              <select class="form-control" id="editGradoUsuario" name="GradoUsuario" required>
                  <option value="No aplica">No aplica</option>
                  <option value="Parvulos">Párvulos</option>
                  <option value="Pre-Primaria">Pre-Primaria</option>
                  <option value="Primero-Primaria">Primero-Primaria</option>
                  <option value="Segundo-Primaria">Segundo-Primaria</option>
                  <option value="Tercero-Primaria">Tercero-Primaria</option>
                  <option value="Cuarto-Primaria">Cuarto-Primaria</option>
                  <option value="Quinto-Primaria">Quinto-Primaria</option>
                  <option value="Sexto-Primaria">Sexto-Primaria</option>
              </select>
          </div>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
      </div>
    </div>
  </div>
</div>
