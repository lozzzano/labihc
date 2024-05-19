<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pedido;
use App\Models\Conversacion;



class PedidoAceptado extends Model
{
    use HasFactory;

    // Definimos la tabla
    protected $table = 'pedido_aceptado';

    protected $fillable = [
        'id_pedido',
        'id_vendedor',
        'id_comprador',
        'status_pedido'
    ];

    // Establecemos las relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'id_comprador');
    }

    public function conversacion()
    {
        return $this->hasOne(Conversacion::class, 'id_pedido_aceptado');
    }
}
