<?php

namespace App\Http\Controllers;

use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        
        $conversaciones = Conversacion::where(function($query) use ($user_id) {
                $query->where('id_comprador', $user_id)
                      ->orWhere('id_vendedor', $user_id);
            })
            ->where('status_conversacion', 0)
            ->with('mensajes')
            ->get();

        return view('chat.index', compact('conversaciones'));
    }

    // Muestra una conversación específica
    public function show($id)
    {
        $conversacion = Conversacion::where('id', $id)
            ->where(function ($query) use ($id) {
                $query->where('id_comprador', Auth::id())
                    ->orWhere('id_vendedor', Auth::id());
            })
            ->with('mensajes.user')
            ->firstOrFail();

        return view('chat.show', compact('conversacion'));
    }

    // Almacena un nuevo mensaje en una conversación
    public function store(Request $request, $id)
    {
        $request->validate([
            'mensaje' => 'required|string',
        ]);

        $mensaje = new Mensaje;
        $mensaje->id_conversacion = $id;
        $mensaje->id_usuario = Auth::id();
        $mensaje->mensaje = $request->mensaje;
        $mensaje->save();

        // Obtén la conversación actualizada después de agregar el mensaje
        $conversacion = Conversacion::with('mensajes.user')->findOrFail($id);

        // Devuelve la vista con la conversación actualizada
        return redirect()->route('chat.show', $conversacion->id);
    }
    
}
