<!-- resources/views/chat/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="h3 text-center">Mensajes en la Conversación</h2>

    <div class="container-sm mx-auto my-auto">

    <ul class="list-group">
        @foreach ($conversacion->mensajes as $mensaje)
        <li class="list-group-item {{ $mensaje->user->id === Auth::id() ? 'message-sent' : 'message-received' }}" style="margin-top:6px; margin-bottom:6px;">
            <small class="">{{$mensaje->created_at->format('l j \d\e F H:i') }} - </small><strong>{{ $mensaje->user->id === Auth::id() ? 'Tú' : $mensaje->user->name }}:</strong> {{ $mensaje->mensaje }}
        </li>
        @endforeach
    </ul>



    <form action="{{ route('chat.store', $conversacion->id) }}" method="post">
        @csrf
        <div class="form-group">
            <label for="mensaje">Nuevo Mensaje:</label>
            <textarea id="mensaje" name="mensaje" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="background-color:#007bff !important">Enviar</button>
    </form>

    </div>
    
</div>
@endsection

<!-- Agrega enlaces a los estilos CSS en la sección de encabezado -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Estilos personalizados para el chat */
    .message-sent {
        background-color: #b9e0ff !important;
        /* Fondo para mensajes enviados */
    }

    .message-received {
        background-color: #C9D6DF !important;
        /* Fondo para mensajes recibidos */
    }
</style>

<!-- Agrega enlaces a los scripts JavaScript al final del cuerpo del documento -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    // Ejemplo de script para desplazarse automáticamente al último mensaje al cargar la página
    $(document).ready(function() {
        $('.list-group').scrollTop($('.list-group')[0].scrollHeight);
    });
</script>