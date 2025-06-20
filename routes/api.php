<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImagenesController; // Asegúrate de que el nombre del controlador use PascalCase
use App\Http\Controllers\ServiciosController; // Asegúrate de que el nombre del controlador use PascalCase
use App\Http\Controllers\PedidosController; // Si tienes un controlador de Pedidos en API, inclúyelo aquí también

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Ruta protegida que requiere autenticación (ejemplo con Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::apiResource('imagenes', ImagenesController::class); // Sin prefijo / porque apiResource ya lo asume
    // Route::apiResource('servicios', serviciosController::class);
   // Rutas personalizadas para servicios
Route::post('servicios', [ServiciosController::class, 'store']);
Route::get('servicios', [ServiciosController::class, 'index']);
Route::get('servicios/{id}', [ServiciosController::class, 'show']);
Route::put('servicios/{id}', [ServiciosController::class, 'update']);
Route::delete('servicios/{id}', [ServiciosController::class, 'destroy']);

    Route::apiResource('pedidos', PedidosController::class);
