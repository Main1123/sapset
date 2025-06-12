<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\imagenesController;
use App\Http\Controllers\serviciosController;

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

// Ruta protegida que requiere autenticación
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ruta pública para las imágenes
Route::apiResource('/imagenes', imagenesController::class);
Route::get('/imagenes', [imagenesController::class, 'index']);
Route::get('/imagenes/{id}', [imagenesController::class, 'show']);
Route::post('/imagenes', [imagenesController::class, 'store']);
Route::put('/imagenes/{id}', [imagenesController::class, 'update']);
Route::delete('/imagenes/{id}', [imagenesController::class, 'destroy']);

Route::apiResource('/servicios', serviciosController::class);
Route::get('/servicios', [serviciosController::class, 'index']);
Route::get('/servicios/{id}', [serviciosController::class, 'show']);
Route::post('/servicios', [serviciosController::class, 'store']);
Route::put('/servicios/{id}', [serviciosController::class, 'update']);
Route::delete('/servicios/{id}', [serviciosController::class, 'destroy']);


