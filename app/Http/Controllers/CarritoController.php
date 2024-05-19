<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->producto_id;
        $quantityToAdd = $request->cantidad;
        $precio = $request->precio;
        $producto = Producto::find($productId);

        if (isset($cart[$productId])) {
            $cart[$productId]['cantidad'] += $quantityToAdd; // Incrementa por la cantidad enviada
        } else {
            $cart[$productId] = [
                'cantidad' => $quantityToAdd,
                'nombre' => $producto->nombre_producto, 
                'precio' => $producto->precio_producto,
                'id' => $producto->id,

            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'totalItems' => array_sum(array_column($cart, 'cantidad'))
        ]);
    }



    public function content(Request $request)
    {
        // Aquí recuperarías el contenido del carrito de la base de datos o de la sesión.
        $cart = session()->get('cart', []);
        return response()->json(['items' => $cart]);
    }

    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $totalItems = array_sum(array_column($cart, 'cantidad'));

        return response()->json([
            'count' => $totalItems
        ]);
    }
    
    public function removeItem(Request $request, $id) {
        // Aquí iría la lógica para eliminar un ítem del carrito
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        $totalItems = array_sum(array_column($cart, 'cantidad'));
    
        return response()->json([
            'message' => 'Item eliminado correctamente',
            'newCartCount' => $totalItems
        ]);
    }

    public function emptyCart(Request $request) {
        // Limpia el carrito completamente
        session()->forget('cart');
    
        return response()->json([
            'message' => 'Carrito vaciado correctamente',
            'newCartCount' => 0  // Añade esto para devolver el conteo actualizado del carrito
        ]);
    }
    
}
