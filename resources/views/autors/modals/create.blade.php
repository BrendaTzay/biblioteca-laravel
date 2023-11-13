<!-- Modal -->
<div class="modal fade" id="addAutorModal" tabindex="-1" role="dialog" aria-labelledby="addAutorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAutorModalLabel">Agregar Autor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-autor-form" novalidate>
                    @csrf
                    
                    <div class="form-group">
                        <label for="NombreAutor">Nombre</label>
                        <input type="text" class="form-control" id="NombreAutor" name="NombreAutor" required>
                        <small id="errorNombre" class="error-message text-danger d-none"></small>
                    </div>
                    <div class="form-group">
                        <label for="ApellidoAutor">Apellido</label>
                        <input type="text" class="form-control" id="ApellidoAutor" name="ApellidoAutor" required>
                        <small id="errorApellido" class="error-message text-danger d-none"></small>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


