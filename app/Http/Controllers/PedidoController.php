<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Producto;
use App\Models\Conversacion;
use App\Models\Mensaje;
use App\Models\PedidoCarrito;
use App\Models\PedidoAceptado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function crearPedido(Request $request)
    {
        DB::beginTransaction();
        try {
            $pedido = new Pedido();
            $pedido->id_usuario = Auth::id(); // Asume autenticación
            $pedido->precio_pedido = $request->precioTotal; // Total del pedido
            $pedido->status_pedido = 0; // Suponemos que true significa 'activo'
            $pedido->metodo_pago = $request->metodoPago;
            $pedido->save();

            foreach ($request->items as $item) {
                // Verifica que cada item tenga todos los datos necesarios
                if (!isset($item['id'], $item['cantidad'], $item['precio'])) {
                    throw new \Exception("Datos incompletos en el item.");
                }
                $pedidoCarrito = new PedidoCarrito();
                $pedidoCarrito->id_pedido = $pedido->id;
                $pedidoCarrito->id_producto = $item['id'];
                $pedidoCarrito->cantidad = $item['cantidad'];
                $pedidoCarrito->precio = $item['precio'];
                $pedidoCarrito->save();
            }

            DB::commit();
            $request->session()->forget('cart');

            $newCartCount = 0;

            return response()->json(['status' => 'success', 'message' => 'Pedido creado exitosamente', 'newCartCount' => $newCartCount]);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al crear el pedido: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al crear el pedido']);
        }
    }

    public function verPedidos()
    {
        $userId = auth()->id(); // ID del usuario actual

        // Obtén los pedidos pendientes (status 0)
        $pedidosPendientes = Pedido::whereHas('items.producto', function ($query) use ($userId) {
            $query->where('id_usuario', $userId); // Filtra los productos que el usuario ha subido
        })
            ->where('status_pedido', 0) // Filtra los pedidos con status 0 (pendientes)
            ->with('items.producto', 'comprador') // Obtén también los detalles de los productos en los pedidos
            ->get();

        // Obtén los pedidos en proceso (status 1) donde el status_pedido de pedido_aceptado es 0
        $pedidosEnProceso = Pedido::whereHas('items.producto', function ($query) use ($userId) {
            $query->where('id_usuario', $userId); // Filtra los productos que el usuario ha subido
        })
            ->whereHas('pedidoAceptado', function ($query) {
                $query->where('status_pedido', 0); // Filtra los pedidos aceptados con status_pedido 0
            })
            ->with('items.producto', 'comprador', 'pedidoAceptado.conversacion') // Obtén también los detalles de los productos en los pedidos
            ->get();

        // Obtén los pedidos completados donde status_pedido de PedidoAceptado es 1
        $pedidosCompletados = Pedido::whereHas('items.producto', function ($query) use ($userId) {
            $query->where('id_usuario', $userId); // Filtra los productos que el usuario ha subido
        })
            ->whereHas('pedidoAceptado', function ($query) {
                $query->where('status_pedido', 1); // Filtra los pedidos aceptados con status_pedido 1
            })
            ->with('items.producto', 'comprador', 'pedidoAceptado.conversacion') // Obtén también los detalles de los productos en los pedidos
            ->get();

        // Devuelve ambos conjuntos de datos a la vista
        return view('ver-pedidos', compact('pedidosPendientes', 'pedidosEnProceso', 'pedidosCompletados'));
    }





    // PedidoController.php
    // PedidoController.php
    public function aceptar(Pedido $pedido)
    {
        // Cargar los productos asociados al pedido
        $productos = $pedido->productos;

        // Verificar si hay productos asociados
        if ($productos->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontraron productos asociados al pedido.'
            ], 404);
        }

        // Asumimos que todos los productos tienen el mismo vendedor.
        $vendedor = $productos->first()->vendedor;

        // Verificar si el vendedor existe
        if (is_null($vendedor)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No se encontró un vendedor asociado a los productos.'
            ], 404);
        }

        // Crear el registro en pedido_aceptado
        $pedidoAceptado = PedidoAceptado::create([
            'id_pedido' => $pedido->id,
            'id_vendedor' => $vendedor->id,
            'id_comprador' => $pedido->id_usuario,
            'status_pedido' => 0
        ]);

        // Actualizar el status_pedido en la tabla pedido
        $pedido->update(['status_pedido' => 1]);

        // Crear la conversación asociada
        $conversacion = Conversacion::create([
            'id_comprador' => $pedidoAceptado->id_comprador,
            'id_vendedor' => $pedidoAceptado->id_vendedor,
            'id_pedido_aceptado' => $pedidoAceptado->id,
            'status_conversacion' => 0
        ]);

        // Redirigir a la vista de la conversación
        return redirect()->route('chat.show', $conversacion->id);
    }

    public function eliminarPedido(Request $request, $id)
    {
        // Busca y elimina el pedido
        $pedido = Pedido::findOrFail($id);
        $pedido->delete();

        return response()->json([
            'message' => 'El pedido ha sido eliminado correctamente.',
        ]);
    }

    public function actualizarStatus(Request $request, Pedido $pedido)
    {
        DB::beginTransaction();
        try {
            // Actualizar status_pedido de PedidoAceptado
            $pedidoAceptado = PedidoAceptado::where('id_pedido', $pedido->id)->first();
            if ($pedidoAceptado) {
                $pedidoAceptado->status_pedido = 1;
                $pedidoAceptado->save();
            }

            // Actualizar status_conversacion de Conversacion
            $conversacion = Conversacion::where('id_pedido_aceptado', $pedidoAceptado->id)->first();
            if ($conversacion) {
                $conversacion->status_conversacion = 1;
                $conversacion->save();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Status actualizado correctamente']);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al actualizar el status: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error al actualizar el status']);
        }
    }

    public function verHistorialCompras()
    {
        $userId = Auth::id(); // Obtener el ID del usuario autenticado

        // Obtener los pedidos aceptados del usuario autenticado con status_pedido 1
        $pedidos = PedidoAceptado::where('id_comprador', $userId)
            ->where('status_pedido', 1)
            ->with(['pedido.items.producto']) // Incluir las relaciones necesarias
            ->get();

        $pedidosEnProceso = PedidoAceptado::where('id_comprador', $userId)
            ->where('status_pedido', 0)
            ->with(['pedido.items.producto']) // Incluir las relaciones necesarias
            ->get();

        // Pasar los pedidos a la vista
        return view('perfil-usuario', compact('pedidos', 'pedidosEnProceso'));
    }
}
