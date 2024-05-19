<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias'; // Opcional si sigue las convenciones de Laravel

    // Si tienes campos que quieres asignar masivamente, puedes definirlos aquí
    protected $fillable = [
        'nombre_categoria',
        // otros campos que quieras asignar masivamente
    ];

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_producto');
    }
}
