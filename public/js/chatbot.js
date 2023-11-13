$(document).ready(function() {
    var consultaChatbotUrl = $('#ajax-url').data('url');

    $('#chatbot-form').on('submit', function(e) {
        e.preventDefault();
        var consulta = $('#consulta').val();
        $('#chat-container').append('<div class="user-message"><strong>Tú:</strong> ' + consulta + '</div>');

        // Agregar mensaje de procesamiento
        $('#chat-container').append('<div id="loading-message" class="bot-message"><strong>Procesando respuesta...</strong></div>');

        $.ajax({
            url: consultaChatbotUrl,
            type: 'POST',
            data: {consulta: consulta},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                // Quitar mensaje de procesamiento
                $('#loading-message').remove();

                // Convertir los saltos de línea en etiquetas <br> para la respuesta de OpenAI
                var respuestaFormateada = response.respuesta_openai.replace(/\n/g, '<br>');
                $('#chat-container').append('<div class="bot-message"><strong>Bot:</strong> ' + respuestaFormateada + '</div>');

                // Mostrar los resultados de los PDFs
                if(response.resultados_pdf && response.resultados_pdf.length > 0) {
                    response.resultados_pdf.forEach(function(pdf) {
                        $('#chat-container').append('<div class="bot-message"><strong>PDF:</strong> <a href="' + pdf.enlace + '">' + pdf.nombre + '</a><br>' + pdf.extracto + '</div>');
                    });
                }

                $('#consulta').val('');
                $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
            },
            error: function(error) {
                // Quitar mensaje de procesamiento
                $('#loading-message').remove();

                console.log(error);
                $('#chat-container').append('<div class="bot-message"><strong>Error:</strong> No se pudo obtener una respuesta</div>');
            }
        });
    });
});
