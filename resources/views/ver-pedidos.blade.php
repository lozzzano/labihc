@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

@section('content')

<body>

    <div class="container">

        <div class="container">
            <h1 class="h3 text-center p-3">Pedidos Pendientes</h1>
            @if ($pedidosPendientes->isEmpty())
            <p class="text-center text-muted">No hay pedidos pendientes.</p>
            @else
            <div class="row">
                @foreach ($pedidosPendientes as $pedido)
                <div class="col-md-6" style="margin-bottom:10px;">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-header">
                            Pedido #{{ $pedido->id }} - Total: ${{ $pedido->precio_pedido }} <br>
                            <strong>Realizado por:</strong> {{ $pedido->comprador->name }}
                        </div>
                        <div class="card-body flex-grow-1">
                            <h5>Productos:</h5>
                            <ul>
                                @foreach ($pedido->items as $item)
                                <li>{{ $item->producto->nombre_producto }} - ${{ $item->precio }} x {{ $item->cantidad }}</li>
                                @endforeach
                                <li>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer mt-auto">
                            <div class="row">
                                <div class="col-6 d-flex justify-content-center">
                                    <form action="{{ route('pedidos.aceptar', $pedido->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary" style="font-size:14px; background-color: #007bff;">Aceptar pedido</button>
                                    </form>
                                </div>
                                <div class="col-6 d-flex justify-content-center">
                                    <form action="{{ route('pedidos.eliminar', $pedido->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" style="font-size:14px; background-color: #dc3545;">No aceptar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>



        <div class="container">
            <h1 class="h3 text-center p-3">Pedidos en proceso</h1>
            @if ($pedidosEnProceso->isEmpty())
            <p class="text-center text-muted">No hay pedidos en proceso.</p>
            @else
            <div class="row">
                @foreach ($pedidosEnProceso as $pedido)
                <div class="col-md-6" style="margin-bottom:10px;">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-header">
                            Pedido #{{ $pedido->id }} - Total: ${{ $pedido->precio_pedido }} <br>
                            <strong>Realizado por:</strong> {{ $pedido->comprador->name }}
                        </div>
                        <div class="card-body flex-grow-1">
                            <h5>Productos:</h5>
                            <ul>
                                @foreach ($pedido->items as $item)
                                <li>{{ $item->producto->nombre_producto }} - ${{ $item->precio }} x {{ $item->cantidad }}</li>
                                @endforeach
                                <li>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer mt-auto">
                            @if ($pedido->pedidoAceptado && $pedido->pedidoAceptado->conversacion)
                            <div class="row">
                                <div class="col-md-1"></div>
                                <div class="col-md-4 d-flex justify-content-center align-items-stretch">
                                    <a href="{{ route('chat.show', $pedido->pedidoAceptado->conversacion->id) }}" class="btn btn-primary btn-custom" style="font-size:14px;">Enviar mensaje</a>
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-4 ">
                                    <form action="{{ route('pedidos.actualizarStatus', $pedido->id) }}" method="POST" class="">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-custom" style="background-color: #dc3545; font-size:14px;">Terminar pedido</button>
                                    </form>
                                </div>
                                <div class="col-md-1"></div>

                            </div>




                            @else
                            <span class="text-muted">No hay conversación disponible</span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        <div class="container">
            <h1 class="h3 text-center p-3">Pedidos completados</h1>
            @if ($pedidosCompletados->isEmpty())
            <p class="text-center text-muted">No hay pedidos completados.</p>
            @else
            <div class="row">
                @foreach ($pedidosCompletados as $pedido)
                <div class="col-md-6" style="margin-bottom:10px;">
                    <div class="card h-100 d-flex flex-column">
                        <div class="card-header">
                            Pedido #{{ $pedido->id }} - Total: ${{ $pedido->precio_pedido }} <br>
                            <strong>Realizado por:</strong> {{ $pedido->comprador->name }}
                        </div>
                        <div class="card-body flex-grow-1">
                            <h5>Productos:</h5>
                            <ul>
                                @foreach ($pedido->items as $item)
                                <li>{{ $item->producto->nombre_producto }} - ${{ $item->precio }} x {{ $item->cantidad }}</li>
                                @endforeach
                                <li>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y H:i') }}</li>
                            </ul>
                        </div>
                        <div class="card-footer mt-auto">
                            <span class="text-muted">Pedido completado</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>




    </div>
</body>


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
</script>
<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

<script>
    $(document).on('click', '.btn-no-aceptar', function(e) {
        e.preventDefault(); // Previene el comportamiento por defecto

        var form = $(this).closest('form'); // Encuentra el formulario asociado
        var actionUrl = form.attr('action'); // Obtiene la URL de acción

        Swal.fire({
            title: '¿Estás seguro?',
            text: "Si rechazas el pedido, se eliminará. ¡No podrás deshacer esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, envía la solicitud al backend
                $.ajax({
                    url: actionUrl,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        Swal.fire(
                            'Eliminado',
                            response.message,
                            'success'
                        );

                        // Opcionalmente, recargar la página o eliminar el elemento del DOM
                        form.closest('.card').remove();
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo eliminar el pedido.', 'error');
                    }
                });
            }
        });
    });
</script>

<style>
    .btn-custom {
        font-size: 14px;
        width: 100%;
        /* Asegura que los botones ocupen todo el ancho del contenedor */
        display: flex !important;
        justify-content: center;
        align-items: center;
        height: 80%;
        /* Hace que el botón ocupe toda la altura del contenedor */
    }

    .form-custom {
        width: 80%;
        display: flex !important;
        justify-content: center;
        align-items: center;
        height: 90%;
    }
</style>