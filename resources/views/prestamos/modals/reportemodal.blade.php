<div class="modal fade" id="reportePrestamoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Préstamos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('prestamos.reporte') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="tipoReporte">Seleccione el tipo de reporte</label>
                        <select name="tipo" id="tipoReporte" class="form-control">
                            <option value="todos">Todos</option>
                            <option value="devuelto">Devuelto</option>
                            <option value="prestado">Prestado</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
