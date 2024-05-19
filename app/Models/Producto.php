<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\User;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos'; // Opcional si sigue las convenciones de Laravel

    protected $fillable = [
        'nombre_producto', 
        'descripcion_producto', 
        'imagen_producto', 
        'precio_producto', 
        'stock_producto', 
        'status_producto',
        'categoria_producto', 
        'id_usuario',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_producto');
    }

    public function user()
    {
        // Asume que un producto pertenece a un usuario.
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function getEstadoTextoAttribute()
    {
        return $this->estado == 1 ? 'No Activo' : 'Activo';
    }

    public function pedidosCarrito() {
        return $this->hasMany(PedidoCarrito::class, 'id_producto');
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}