<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ChatController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ProductoController::class, 'index'])->name('dashboard');

    //CRUD routes
    Route::resource('productos', ProductoController::class);

    //Feed routes
    Route::get('/feed', [FeedController::class, 'index'])->name('feed');
    Route::post('/cart/add', [CarritoController::class, 'add'])->name('cart.add');
    Route::get('/cart/content', [CarritoController::class, 'content'])->name('cart.content');
    Route::get('/perfil-usuario', [PedidoController::class, 'verHistorialCompras'])->name('perfil-usuario');

    //Pedido routes
    Route::post('/crear-pedido', [PedidoController::class, 'crearPedido']);
    Route::post('/pedidos/{pedido}/aceptar', [PedidoController::class, 'aceptar'])->name('pedidos.aceptar');
    Route::post('/pedidos/eliminar/{id}', [PedidoController::class, 'eliminarPedido'])->name('pedidos.eliminar');
    Route::post('/pedidos/actualizar-status/{pedido}', [PedidoController::class, 'actualizarStatus'])->name('pedidos.actualizarStatus');


    //Carrito routes
    Route::get('/cart/count', [CarritoController::class, 'getCartCount']);
    Route::post('/cart/remove/{id}', [CarritoController::class, 'removeItem'])->name('cart.removeItem');
    Route::post('/cart/empty', [CarritoController::class, 'emptyCart'])->name('cart.empty');

    //Perfil usuario routes
    Route::get('/perfil-usuario/mis-productos', [ProductoController::class, 'show'])->name('mis-productos');
    Route::get('/perfil-usuario/ver-pedidos', [PedidoController::class, 'verPedidos'])->name('ver-pedidos');


    //Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}/mensajes', [ChatController::class, 'store'])->name('chat.store');



});


require __DIR__ . '/auth.php';
