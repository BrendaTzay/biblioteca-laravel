@extends('layouts.app')

@section('title', 'Chatbot Biblioteca')

@section('content')
    <div id="ajax-url" data-url="{{ route('chatbot.consultar') }}" style="display: none;"></div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-robot mr-2"></i>Chatbot de la Biblioteca
                        </h5>
                    </div>
                    <div class="card-body" style="background-color: #343A40;">
                        <div id="chat-container"
                            style="height: 400px; overflow-y: auto; background-color: #343A40; border: 1px solid #444; padding: 15px;">
                            <!-- Mensajes del chatbot -->
                        </div>
                        <form id="chatbot-form" class="mt-3">
                            <div class="input-group">
                                <input type="text" id="consulta" class="form-control"
                                    placeholder="Escribe tu pregunta aquí..." aria-label="Escribe tu pregunta aquí...">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Enviar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
