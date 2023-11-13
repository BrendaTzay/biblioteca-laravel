<!-- Modal -->
<div id="ajax-url" data-url="{{ route('buscar') }}"></div>

<div class="modal fade" id="addPrestamoModal" tabindex="-1" role="dialog" aria-labelledby="addPrestamoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> <!-- Aumenta el tamaño del modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPrestamoModalLabel">Agregar Préstamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-prestamo-form" novalidate>
                    @csrf
                    <div class="row mb-3"> 
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="CodigoUsuario">Código de Usuario</label>
                                <input type="text" class="form-control" id="CodigoUsuario" name="CodigoUsuario" required oninput="buscarUsuario()">
                                <small id="errorCodigoUsuario" class="error-message text-danger d-none">Debe ingresar un código.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="IdUsuario">Usuario</label>
                                <select class="form-control" id="IdUsuario" name="IdUsuario" required style="display: none;">
                                </select>
                                <span id="usuarioMensaje" style="display:none; margin-top: 10px; display: block;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="IdLibro">Libro</label>
                                <input type="text" class="form-control" id="IdLibro" name="IdLibro" required>
                                <input type="hidden" id="hiddenIdLibro" name="hiddenIdLibro" value="">
                                <small id="errorIdLibro" class="error-message text-danger d-none">Debe seleccionar un libro.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="FechaSalida">Fecha de Salida</label>
                                <input type="date" class="form-control" id="FechaSalida" name="FechaSalida" required>
                                <small id="errorFechaSalida" class="error-message text-danger d-none">Debe seleccionar una fecha de salida.</small>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="FechaDevolucion">Fecha de Devolución</label>
                                <input type="date" class="form-control" id="FechaDevolucion" name="FechaDevolucion" required>
                                <small id="errorFechaDevolucion" class="error-message text-danger d-none">Debe seleccionar una fecha de devolución.</small>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="ObservacionPrestamo">Observaciones</label>
                        <textarea class="form-control" id="ObservacionPrestamo" name="ObservacionPrestamo" required></textarea>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>



function buscarUsuario() {
    var codigoUsuario = $('#CodigoUsuario').val();
    $('#IdUsuario').empty().hide(); // Limpiar el select en cada búsqueda
    $('#usuarioMensaje').hide();

    if(codigoUsuario.length >= 4) {
        $.ajax({
            type: 'GET',
            url: `{{ url('/buscar-usuario') }}/${codigoUsuario}`,
            success: function(response) {
                if(response.success) {
                    response.data.forEach(usuario => {
                        $('#IdUsuario').append(`<option value="${usuario.IdUsuario}">${usuario.NombreUsuario} ${usuario.ApellidoUsuario}</option>`);
                    });
                    $('#IdUsuario').show();
                } else {
                    // Manejar el caso en que no se encuentren usuarios
                    $('#usuarioMensaje').text(response.message).show();
                }
            },
            error: function() {
                // Manejar el caso de error en la solicitud
                $('#usuarioMensaje').text('Error en la búsqueda').show();
            }
        });
    } else if(codigoUsuario.length > 0) {
        // Manejar el caso en que el código es demasiado corto
        $('#usuarioMensaje').text('El código debe tener al menos 4 caracteres').show();
    } else {
        // Manejar el caso en que el campo está vacío
        $('#usuarioMensaje').text('').show();
    }
}

</script>