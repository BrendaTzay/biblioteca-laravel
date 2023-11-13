<div class="modal" id="reportModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Generar Reporte</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="reportType">Tipo de Reporte:</label>
                    <select id="reportType" class="form-control" onchange="toggleDireccionField()">
                        <option value="">Seleccionar</option>
                        <option value="direccion">Dirección</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="comunidad">Comunidad</option>
                        <option value="todos">Todos</option>
                        <!-- Aquí puedes agregar más opciones según necesites -->
                    </select>
                </div>
                <div class="form-group" id="direccionField" style="display: none;">
                    <label for="direccion">Dirección:</label>
                    <input type="text" id="direccion" class="form-control">
                </div>
                <div id="gradoField" class="form-group" style="display:none;">
                    <label for="grado">Grado</label>
                    <select id="grado" class="form-control">
                        <option value="todos">Todos los estudiantes</option>
                        <option value="Parvulos">Parvulos</option>
                        <option value="Pre-Primaria">Pre-Primaria</option>
                        <option value="Primero-Primaria">Primero-Primaria</option>
                        <option value="Segundo-Primaria">Segundo-Primaria</option>
                        <option value="Tercero-Primaria">Tercero-Primaria</option>
                        <option value="Cuarto-Primaria">Cuarto-Primaria</option>
                        <option value="Quinto-Primaria">Quinto-Primaria</option>
                        <option value="Sexto-Primaria">Sexto-Primaria</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="generateCustomReport()">Generar Reporte</button>
            </div>
        </div>
    </div>
</div>
