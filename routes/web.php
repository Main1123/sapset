<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\LandingController::class, 'index'])->name('landing');

Auth::routes(['register' => false]);

// Ruta pública para landing
Route::view('/landing', 'landing.landing')->name('landing');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    // Rutas de administración
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::view('/', 'admin.home')->name('home');
        Route::resource('imagenes', App\Http\Controllers\ImagenesController::class);

        Route::resource('servicios', App\Http\Controllers\serviciosController::class);
        Route::resource('pedidos', App\Http\Controllers\pedidosController::class);
        Route::get('profile', [App\Http\Controllers\usersController::class, 'profile'])->name('profile');
        Route::post('profile', [App\Http\Controllers\usersController::class, 'updateProfile'])->name('profile.update');
        Route::view('servicios', 'admin.servicios.index')->name('servicios.index');
        Route::post('servicios', [App\Http\Controllers\serviciosController::class, 'store'])->name('servicios.store');
        Route::view('imagenes', 'admin.imagenes.index')->name('imagenes.index');
        Route::post('imagenes', [App\Http\Controllers\imagenesController::class, 'store'])->name('imagenes.store');
        Route::view('pedidos', 'admin.pedidos.index')->name('pedidos.index');
        Route::post('pedidos', [App\Http\Controllers\pedidosController::class, 'store'])->name('pedidos.store');
   
    });
});
