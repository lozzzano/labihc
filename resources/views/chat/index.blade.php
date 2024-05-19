<!-- resources/views/chat/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="h2"  style="padding:16px;">Conversaciones</h2>
    <ul class="list-group">
        @foreach ($conversaciones as $conversacion)
            <li class="list-group-item">
                <a href="{{ route('chat.show', $conversacion->id) }}">
                    Conversación con 
                    @if ($conversacion->id_comprador == Auth::id())
                        {{ $conversacion->vendedor->name }}
                    @else
                        {{ $conversacion->comprador->name }}
                    @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
