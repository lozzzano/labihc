<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Producto::where('status_producto', 1) 
                                ->with('user', 'categoria')
                                ->get();
        return view('dashboard', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all(); // Si necesitas categorías en tu formulario
        return view('productos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_producto' => 'required|max:255',
            'descripcion_producto' => 'required',
            'precio_producto' => 'required|numeric',
            'stock_producto' => 'required|integer',
            'status_producto' => 'boolean',
            'categoria_producto' => 'required|exists:categorias,id', // Asegura que la categoría exista
            'imagen_producto' => 'image|max:2048', // Ejemplo de validación de imagen
        ]);

        if ($request->hasFile('imagen_producto')) {
            $validatedData['imagen_producto'] = $request->file('imagen_producto')->store('imagenes_productos', 'public');
        }

        $validatedData['habilitado'] = $request->has('habilitado') ? 1 : 0;

        $validatedData['id_usuario'] = auth()->id();
        Producto::create($validatedData);

        return redirect()->route('mis-productos')->with('success', 'Producto creado con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $userId = auth()->id();

        // Recuperar los productos del usuario autenticado
        $productos = Producto::where('id_usuario', $userId)->get();
    
        // Pasar los productos a la vista
        return view('mis-productos', compact('productos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorias = Categoria::all();
        $producto = Producto::find($id);

        return view('productos.edit', compact('producto', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        $validatedData = $request->validate([
            'nombre_producto' => 'required|max:255',
            'descripcion_producto' => 'required',
            'precio_producto' => 'required|numeric',
            'stock_producto' => 'required|integer',
            'status_producto' => 'boolean',
            'categoria_producto' => 'required|exists:categorias,id', // Asegura que la categoría exista
            'imagen_producto' => 'image|max:2048', // Ejemplo de validación de imagen
        ]);

        // Si hay una imagen, la guardamos y obtenemos el nombre del archivo
        if ($request->hasFile('imagen_producto')) {
            $validatedData['imagen_producto'] = $request->file('imagen_producto')->store('imagenes_productos', 'public');
        }

        $validatedData['status_producto'] = $request->has('status_producto') ? 1 : 0;

        $producto->update($validatedData);

        return redirect()->route('mis-productos')->with('success', 'Producto actualizado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('dashboard')->with('success', 'Producto eliminado con éxito.');
    }
}
