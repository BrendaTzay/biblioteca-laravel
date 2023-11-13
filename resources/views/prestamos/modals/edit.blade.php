<!-- Modal -->
<div class="modal fade" id="editPrestamoModal" tabindex="-1" role="dialog" aria-labelledby="editPrestamoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Aumenta el tamaño del modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPrestamoModalLabel">Editar Préstamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-prestamo-form">
                    @csrf
                    <div class="row mb-3"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editIdUsuario">Usuario</label>
                                <select class="form-control" id="editIdUsuario" name="IdUsuario" required disabled>
                                    @foreach($usuarios as $usuario)
                                        <option value="{{ $usuario->IdUsuario }}">{{ $usuario->NombreUsuario }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editIdLibro">Libro</label>
                                <select class="form-control" id="editIdLibro" name="IdLibro" required disabled>
                                    @foreach($libros as $libro)
                                        <option value="{{ $libro->IdLibro }}">{{ $libro->TituloLibro }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3"> <!-- Añade margen inferior a la fila -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editFechaSalida">Fecha de Salida</label>
                                <input type="date" class="form-control" id="editFechaSalida" name="FechaSalida" required readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editFechaDevolucion">Fecha de Devolución</label>
                                <input type="date" class="form-control" id="editFechaDevolucion" name="FechaDevolucion" required readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editEstadoPrestamo">Estado del Préstamo</label>
                        <select class="form-control" id="editEstadoPrestamo" name="EstadoPrestamo" required>
                            <option value="Devuelto">Devuelto</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="editObservacionPrestamo">Observaciones</label>
                        <textarea class="form-control" id="editObservacionPrestamo" name="ObservacionPrestamo"></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
