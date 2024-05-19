@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Crear Producto</div>
                <div class="card-body">
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <!-- Nombre del producto -->
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del producto:</label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" required>
                        </div>
                        <!-- Descripción del producto -->
                        <div class="form-group">
                            <label for="descripcion_producto">Descripción del producto:</label>
                            <textarea class="form-control" name="descripcion_producto" id="descripcion_producto" required></textarea>
                        </div>
                        <!-- Precio del producto -->
                        <div class="form-group">
                            <label for="precio_producto">Precio del producto:</label>
                            <input type="number" class="form-control" name="precio_producto" id="precio_producto" step="0.01" required>
                        </div>
                        <!-- Stock del producto -->
                        <div class="form-group">
                            <label for="stock_producto">Stock del producto:</label>
                            <input type="number" class="form-control" name="stock_producto" id="stock_producto" required>
                        </div>
                        <!-- Categoría del producto -->
                        <div class="form-group">
                            <label for="categoria_producto">Categoría del producto:</label>
                            <select class="form-control" name="categoria_producto" id="categoria_producto" required>
                                <option value="">Seleccione una categoría</option>
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Imagen del producto -->
                        <div class="form-group">
                            <label for="imagen_producto">Imagen del producto:</label>
                            <input type="file" class="form-control-file" name="imagen_producto" id="imagen_producto">
                            <img id="vistaPrevia" class="img-thumbnail mt-2" style="max-width:350px;">
                        </div>
                        <!-- Habilitar producto -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="status_producto" id="status_producto" value="1">
                            <label class="form-check-label" for="status_producto">
                                Habilitar producto
                            </label>
                        </div>
                        <!-- Botón para crear el producto -->
                        <button type="submit" class="btn btn-primary btn-crear">Crear Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .btn-crear {
    background-color: #007bff !important;
    }
    main{
        padding-bottom: 20px;
    }
</style>



<script>
document.addEventListener('DOMContentLoaded', function() {
    var inputImagen = document.getElementById('imagen_producto');
    if(inputImagen) {
        inputImagen.addEventListener('change', function(event) {
            mostrarVistaPrevia(event);
        });
    }
});

function mostrarVistaPrevia(event) {
    var reader = new FileReader();
    var vistaPrevia = document.getElementById('vistaPrevia');
    reader.onload = function(){
        vistaPrevia.src = reader.result;
        vistaPrevia.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

