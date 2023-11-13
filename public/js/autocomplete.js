$(function() {
    // Definición de la URL y la función buscar fuera de los eventos de modal
    var url = $('#ajax-url').data('url');

    function buscar(term, tipo, response) {
        $.ajax({
            url: url,
            data: { term: term, tipo: tipo },
            dataType: 'json',
            success: function(data) {
                response(data);
            }
        });
    }

    // Evento shown.bs.modal para el modal de creación de libros
    $('#addLibroModal').on('shown.bs.modal', function () {
        $("#autor").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'autor', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#autor").val(ui.item.label);
                $("#IdAutor").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });

        $("#categoria").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'categoria', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#categoria").val(ui.item.label); 
                $("#IdCategoria").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });

        $("#editorial").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'editorial', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#editorial").val(ui.item.label);  
                $("#IdEditorial").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });
    });

    // Evento shown.bs.modal para el modal de edición de libros
    $('#editLibroModal').on('shown.bs.modal', function () {
        console.log('Modal de edición mostrado');  
        $("#editAutor").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'autor', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#editAutor").val(ui.item.label);
                $("#editIdAutor").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });

        $("#editCategoria").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'categoria', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#editCategoria").val(ui.item.label);
                $("#editIdCategoria").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });

        $("#editEditorial").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'editorial', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#editEditorial").val(ui.item.label);
                $("#editIdEditorial").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });
    });

    // Evento shown.bs.modal para el modal de creación de préstamos
    $('#addPrestamoModal').on('shown.bs.modal', function () {
        $("#IdLibro").autocomplete({
            source: function(request, response) {
                buscar(request.term, 'libro', response);
            },
            minLength: 2,
            select: function(event, ui) {
                event.preventDefault();
                $("#IdLibro").val(ui.item.label);
                $("#hiddenIdLibro").val(ui.item.value);  
            },
            open: function() {
                $(this).autocomplete("widget").css("z-index", 1052);
                return false;
            }
        });
    });   
});
