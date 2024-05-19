<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Mensaje;



class Conversacion extends Model
{
    use HasFactory;

    protected $table = 'conversacion';

    protected $fillable = [
        'id_comprador',
        'id_vendedor',
        'id_pedido_aceptado',
        'status_conversacion'
    ];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'id_conversacion');
    }

    public function comprador()
    {
        return $this->belongsTo(User::class, 'id_comprador');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_vendedor');
    }
    public function pedidoAceptado()
    {
        return $this->belongsTo(PedidoAceptado::class, 'id_pedido_aceptado');
    }
}
