@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

@section('content')

<body>

    <div class="container mt-5">
        <h1 class="text-center h2">Mis Productos</h1>
        <a href="{{ route('productos.create') }}" class="btn btn-outline-dark">
            <div class="row">
                <div class="col-md-12"><i class="bi bi-bag-plus"> Crear Producto</i></div>
            </div>
        </a>
        <div class="row" style="padding-top:20px;">
            @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card h-100" style="padding:8px;">
                    <div class="card-img-top">
                        <img src="{{ asset('storage/' . $producto->imagen_producto) }}" alt="{{ $producto->nombre_producto }}" class="card-img-top" style="height: 100%;">
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $producto->nombre_producto }}</h5>
                        <p class="card-text" style="flex-grow: 1; min-height: 50px;">{{ $producto->descripcion_producto }}</p>


                        <div class="row text-center">

                            <div class="col-md-3"><small class="text-muted">${{ $producto->precio_producto }}</small></div>
                            <div class="col-md-4"> <small class="text-muted">Stock: {{ $producto->stock_producto }}</small></div>
                            <div class="col-md-5"><small class="text-muted">Status: {{ $producto->estado_texto }}</small></div>





                        </div>
                        <div class="row" style="padding-top:5px;">
                            <div class="col-md-6"><a href="{{ route('productos.edit', ['producto' => $producto->id]) }}" class="btn btn-primary" style="display:flow; font-size:14px;"><i class="bi bi-pencil">Editar</i></a></div>
                            <div class="col-md-6">
                                <form id="delete-form" action="{{ route('productos.destroy', $producto->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="#" class="btn btn-danger" onclick="confirmDelete()" style="display:flow; font-size:14px;"><i class="bi bi-trash">Eliminar</i></a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            @empty
            <p>No tienes productos subidos aún.</p>
            @endforelse
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
<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" rel="stylesheet">

<script>
    function confirmDelete() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form').submit();
            }
        })
    }
</script>

</script>

<style>
    .card-img-top {
        width: 100%;
    height: 200px; /* Altura fija, pero la imagen no se recortará */
    object-fit: contain;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        /* Organiza el contenido de la tarjeta verticalmente */
    }

    .card-text {
        flex-grow: 1;
        /* Permite que la descripción ocupe todo el espacio disponible */
        min-height: 50px;
        /* Altura mínima para la descripción */
    }
</style>