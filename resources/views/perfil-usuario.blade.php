@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

@section('content')
<body style="background-color: #F0F5F9 !important">

<div class="container" >

  <!-- Tarjeta de perfil del usuario -->
  <div class="row">
    <div class="col-md-9">
            
        <div class="card my-3" style="border:none; background-color: transparent;">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-user"></i> {{ Auth::user()->name }}</h5>
                <p class="card-text">Matrícula: {{Auth::user()->matricula}}</p>
            </div>
        </div>

    </div>

    <div class="col-md-3">

        <div class="row">
            <a href="{{ route('mis-productos') }}" class="">
                <div class="col-md-12 productos-botones btn btn-outline-dark" style="border-radius:8px;">Subir y/o ver productos</div>
            </a>

            <a href="{{ route('ver-pedidos') }}" class="">
                <div class="col-md-12 productos-botones btn btn-outline-dark" style="border-radius:8px;">Aceptar pedidos</div>
            </a>

            <a href="{{ route('chat.index') }}">
                <div class="col-md-12 col-md-12 productos-botones btn btn-outline-dark" style="border-radius:8px;">Mis conversaciones</div>
            </a>
        </div>
        

    </div>

  </div>


<!-- Histórico de Compras -->
<div class="container" style="margin-top:20px;">
    <div class="row">
        <!-- Sección Historial de Compras -->
        <div class="col-md-6">
            <h3 class="h2 text-center">Historial de Compras</h3>
            <div class="card-body">
                @if ($pedidos->isEmpty())
                    <p class="text-center text-muted">No hay compras aún.</p>
                @else
                    <div class="row">
                        @foreach ($pedidos as $pedidoAceptado)
                            @foreach ($pedidoAceptado->pedido->items as $item)
                                <div class="col-md-12 mb-4" style="border-radius:10px;">
                                    <div class="card h-100">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('storage/' . $item->producto->imagen_producto) }}" alt="{{ $item->producto->nombre_producto }}" style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p><b>Producto:</b> {{ $item->producto->nombre_producto }}</p>
                                                    <p><b>Fecha:</b> {{ \Carbon\Carbon::parse($pedidoAceptado->pedido->created_at)->format('d/m/Y H:i') }}</p>
                                                    <p><b>Cantidad:</b> {{ $item->cantidad }}</p>
                                                    <p><b>Precio:</b> ${{ $item->precio }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Sección Tus Pedidos -->
        <div class="col-md-6">
            <h3 class="h2 text-center">Tus Pedidos</h3>
            <div class="card-body">
                @if ($pedidosEnProceso->isEmpty())
                    <p class="text-center text-muted">No hay pedidos en proceso.</p>
                @else
                    <div class="row">
                        @foreach ($pedidosEnProceso as $pedidoAceptado)
                            @foreach ($pedidoAceptado->pedido->items as $item)
                                <div class="col-md-12 mb-4">
                                    <div class="card h-100">
                                        <div class="row no-gutters">
                                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('storage/' . $item->producto->imagen_producto) }}" alt="{{ $item->producto->nombre_producto }}" style="max-width: 100%; height: auto;">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="card-body">
                                                    <p><b>Producto:</b> {{ $item->producto->nombre_producto }}</p>
                                                    <p><b>Fecha:</b> {{ \Carbon\Carbon::parse($pedidoAceptado->pedido->created_at)->format('d/m/Y H:i') }}</p>
                                                    <p><b>Cantidad:</b> {{ $item->cantidad }}</p>
                                                    <p><b>Precio:</b> ${{ $item->precio }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>



</div>


@endsection
    

<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="{{ asset('js/scripts-temp.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
<!-- Core theme CSS (includes Bootstrap)-->
<link href="{{ asset('css/styles-temp.css') }}" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Incluir SweetAlert CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<!-- Incluir SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

<style>
    .productos-botones{
    margin-top: 1.1em;
    border: 1px solid;
    padding: 5px;
    text-align: center;
    }
</style>
</body>
    
</head>
</html>