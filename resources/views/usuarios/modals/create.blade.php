<!-- Modal -->
<div class="modal fade" id="addUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="addUsuarioModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUsuarioModalLabel">Agregar Usuario</h5>
                <div class="ml-auto mt-n2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoUsuario" id="Comunidad"
                            value="Comunidad">
                        <label class="form-check-label" for="Comunidad">Comunidad</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tipoUsuario" id="Escuela"
                            value="Escuela">
                        <label class="form-check-label" for="Escuela">Escuela</label>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-usuario-form" novalidate>
                    @csrf
                    <div class="form-group">
                        <label for="NombreUsuario">Nombre</label>
                        <input type="text" class="form-control" id="NombreUsuario" name="NombreUsuario" required>
                        <small id="errorNombre" class="error-message text-danger d-none"></small>
                    </div>
                    <div class="form-group">
                        <label for="ApellidoUsuario">Apellido</label>
                        <input type="text" class="form-control" id="ApellidoUsuario" name="ApellidoUsuario" required>
                        <small id="errorApellido" class="error-message text-danger d-none"></small>
                    </div>
                    <div class="form-group">
                        <label for="DireccionUsuario">Dirección</label>
                        <input type="text" class="form-control" id="DireccionUsuario" name="DireccionUsuario"
                            required>
                        <small id="errorDireccion" class="error-message text-danger d-none"></small>
                    </div>
                    <div class="form-group">
                        <label for="TelefonoUsuario">Teléfono</label>
                        <input type="text" class="form-control" id="TelefonoUsuario" name="TelefonoUsuario" required>
                        <small id="errorTelefono" class="error-message text-danger d-none"></small>
                    </div>
                    <div class="form-group" id="grado-group" style="display:none;">
                        <label for="GradoUsuario">Grado</label>
                        <select class="form-control" id="GradoUsuario" name="GradoUsuario">
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
                    <div class="form-group">
                        <label for="NacimientoUsuario">Fecha de Nacimiento</label>
                        <input type="date" class="form-control" id="NacimientoUsuario" name="NacimientoUsuario"
                            required>
                        <small id="errorNacimiento" class="error-message text-danger d-none"></small>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
