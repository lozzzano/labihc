<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conversacion;
use App\Models\User;


class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensaje';
    protected $fillable = ['id_usuario', 'id_conversacion', 'mensaje'];


    public function conversation()
    {
        return $this->belongsTo(Conversacion::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
