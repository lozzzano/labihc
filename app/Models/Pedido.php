<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PedidoCarrito;
use App\Models\Producto;
use App\Models\PedidoAceptado;




class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedido';  // Especificar el nombre de la tabla si no sigue las convenciones

    protected $fillable = [
        'id_usuario', 'status_pedido', 'precio_pedido', 'metodo_pago'
    ];

    public function items()
    {
        return $this->hasMany(PedidoCarrito::class, 'id_pedido');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }


    public function productosCarrito()
    {
        return $this->hasMany(PedidoCarrito::class, 'id_pedido');
    }

    // Relación a través de pedido_carrito para obtener directamente los productos
    public function productos()
    {
        return $this->hasManyThrough(
            Producto::class,
            PedidoCarrito::class,
            'id_pedido',
            'id',
            'id',
            'id_producto'
        );
    }

    public function pedidoAceptado()
    {
        return $this->hasOne(PedidoAceptado::class, 'id_pedido');
    }
}
