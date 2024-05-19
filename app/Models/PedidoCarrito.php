<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Producto;
use App\Models\Pedido;



class PedidoCarrito extends Model
{
    use HasFactory;

    protected $table = 'pedido_carrito';  // Especificar el nombre de la tabla

    protected $fillable = [
        'id_pedido', 'id_producto', 'cantidad'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
