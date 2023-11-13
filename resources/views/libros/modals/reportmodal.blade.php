<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generar Reporte de Libros</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Selecciona el tipo de reporte que deseas generar:</p>
                <div class="form-group">
                    <select id="reportType" class="form-control">
                        <option value="todos">Todos los Libros</option>
                        <option value="disponibles">Libros Disponibles</option>
                        <option value="nodisponibles">Libros No Disponibles</option>
                        <option value="eliminados">Libros Eliminados</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="generateReport()">Generar Reporte</button>
            </div>
        </div>
    </div>
</div>
