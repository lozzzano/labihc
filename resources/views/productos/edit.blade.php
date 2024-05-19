@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Editar Producto</div>
                <div class="card-body">
                    <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <!-- Nombre del producto -->
                        <div class="form-group">
                            <label for="nombre_producto">Nombre del producto:</label>
                            <input type="text" class="form-control" name="nombre_producto" id="nombre_producto" value="{{ $producto->nombre_producto }}" required>
                        </div>
                        <!-- Descripción del producto -->
                        <div class="form-group">
                            <label for="descripcion_producto">Descripción del producto:</label>
                            <textarea class="form-control" name="descripcion_producto" id="descripcion_producto" required>{{ $producto->descripcion_producto }}</textarea>
                        </div>
                        <!-- Precio del producto -->
                        <div class="form-group">
                            <label for="precio_producto">Precio del producto:</label>
                            <input type="number" class="form-control" name="precio_producto" id="precio_producto" value="{{ $producto->precio_producto }}" required>
                        </div>
                        <!-- Stock del producto -->
                        <div class="form-group">
                            <label for="stock_producto">Stock del producto:</label>
                            <input type="number" class="form-control" name="stock_producto" id="stock_producto" value="{{ $producto->stock_producto }}" required>
                        </div>
                        <!-- Categoría del producto -->
                        <div class="form-group">
                            <label for="categoria_producto">Categoría del producto:</label>
                            <select class="form-control" name="categoria_producto" id="categoria_producto" required>
                                @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ $producto->categoria_producto == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre_categoria }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Imagen del producto -->
                        <div class="form-group">
                            <label for="imagen_producto">Imagen del producto:</label>
                            @if($producto->imagen_producto)
                            <img src="{{ asset('storage/'.$producto->imagen_producto) }}" alt="Imagen actual" id="vistaPrevia" class="img-thumbnail mb-2" style="max-width:350px;">
                            @endif
                            <input type="file" class="form-control-file" name="imagen_producto" id="imagen_producto" onchange="mostrarVistaPrevia(event)">
                        </div>
                        <!-- Habilitar producto -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="status_producto" id="status_producto" value="1" {{ old('status_producto', $producto->status_producto ?? 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_producto">
                                Habilitar producto
                            </label>
                        </div>
                        <!-- Botón de actualizar -->
                        <button type="submit" class="btn btn-primary btn-act">Actualizar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>

/* Agrega estos estilos dentro de la sección @push('styles') en tu layout Blade si estás usando stack, o directamente en la sección de estilos si no. */

/* Estilos adicionales si es necesario */
.img-thumbnail {
    width: 100%;
    max-width: 300px; /* Ajusta la imagen */
    height: auto;
    border-radius: 0.25rem;
}

.btn-act {
    background-color: #007bff !important;
}

.card-header {
    font-size: 1.25rem;
}

main{
    padding-bottom: 20px;
}

/* Bootstrap ya tiene estilos para form-group, form-control, form-check, etc. */


</style>

<script>
function mostrarVistaPrevia(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('vistaPrevia');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>