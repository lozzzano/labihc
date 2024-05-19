@extends('layouts.app')

@section('content')
<h1>{{ $producto->nombre_producto }}</h1>
<p>{{ $producto->descripcion_producto }}</p>
<p>Precio: ${{ $producto->precio_producto }}</p>
<p>Stock: {{ $producto->stock_producto }}</p>
<p>Categoría: {{ $producto->categoria->nombre_categoria }}</p>
@if($producto->imagen_producto)
    <img src="{{ asset('storage/'.$producto->imagen_producto) }}" alt="Imagen del producto">
@endif

<a href="{{ route('productos.edit', $producto->id) }}">Editar</a>

<form action="{{ route('productos.destroy', $producto->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
</form>
@endsection