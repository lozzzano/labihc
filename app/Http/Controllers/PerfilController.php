<?php

namespace App\Http\Controllers;
use App\Models\Producto;
use App\Models\User;


use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function perfil (){
        $productos = Producto::all();
        return view('perfil-usuario', compact('productos'));
    }
}
