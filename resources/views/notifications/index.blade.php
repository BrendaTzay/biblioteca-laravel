@extends('layouts.app')

@section('title', 'Notificaciones')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-bell mr-2"></i>Notificaciones
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="dropdown mr-2">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        id="selectionDropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        Seleccionar
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="selectionDropdown">
                                        <a class="dropdown-item" href="#">Todo</a>
                                        <a class="dropdown-item" href="#">Nada</a>
                                        <a class="dropdown-item" href="#">Leído</a>
                                        <a class="dropdown-item" href="#">No leído</a>
                                    </div>
                                </div>
                                <button id="mark-read" class="btn btn-outline-primary btn-sm mr-2">Marcar como
                                    leído</button>
                                <button id="delete-selected" class="btn btn-outline-danger btn-sm mr-2">Eliminar</button>
                                <div class="search-container">
                                    <input type="text" id="search" class="form-control" placeholder="Buscar...">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="text-center py-5">
                            <span>No hay notificaciones.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            // Código de búsqueda
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".list-group li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function markAsRead(notificationId) {
                let link = "{{ route('notifications.read', ['id' => '_id_']) }}".replace('_id_', notificationId);
                $.ajax({
                    type: 'POST',
                    url: link,
                    success: function(data) {
                        if (data.success) {
                            $("#badge-" + notificationId).removeClass('badge-warning').addClass(
                                'badge-success').text('Leído');
                            $("input[value='" + notificationId + "']").closest('li').addClass('read')
                                .removeClass('unread');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un error al marcar la notificación como leída.',
                            'error');
                    }
                });
            }

            function deleteNotification(notificationId) {
                let link = "{{ route('notifications.delete', ['id' => '_id_']) }}".replace('_id_', notificationId);
                $.ajax({
                    type: 'DELETE',
                    url: link,
                    success: function(data) {
                        if (data.success) {
                            $("input[value='" + notificationId + "']").closest('li').remove();
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un error al eliminar la notificación.', 'error');
                    }
                });
            }

            $('#selectAllOption').click(function(e) {
                e.preventDefault();
                $('.notification-checkbox').prop('checked', true);
                $('li.list-group-item').addClass('highlighted-notification');
            });

            $('#deselectAllOption').click(function(e) {
                e.preventDefault();
                $('.notification-checkbox').prop('checked', false);
                $('li.list-group-item').removeClass('highlighted-notification');
            });

            $('#selectRead').click(function(e) {
                e.preventDefault();
                $('.notification-checkbox').prop('checked', false);
                $('li.list-group-item').removeClass('highlighted-notification');
                $('li.read .notification-checkbox').prop('checked', true);
                $('li.read').addClass('highlighted-notification');
            });

            $('#selectUnread').click(function(e) {
                e.preventDefault();
                $('.notification-checkbox').prop('checked', false);
                $('li.list-group-item').removeClass('highlighted-notification');
                $('li.unread .notification-checkbox').prop('checked', true);
                $('li.unread').addClass('highlighted-notification');
            });

            $('.notification-checkbox').change(function() {
                var listItem = $(this).closest('li.list-group-item');
                if ($(this).is(":checked")) {
                    listItem.addClass('highlighted-notification');
                } else {
                    listItem.removeClass('highlighted-notification');
                }
            });

            $('#mark-read').click(function() {
                $('.notification-checkbox:checked').each(function() {
                    markAsRead($(this).val());
                });
            });

            $('#delete-selected').click(function() {
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('.notification-checkbox:checked').each(function() {
                            deleteNotification($(this).val());
                        });
                        Swal.fire('Eliminado', 'Las notificaciones han sido eliminadas.',
                            'success');
                    }
                });
            });
        });
    </script>
@endsection
