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
        Route::get('profile', [App\Http\Controllers\usersController::class, 'profile'])->name('profile');
        Route::view('servicios', 'admin.servicios.index')->name('servicios.index');
        Route::view('imagenes', 'admin.imagenes.index')->name('imagenes.index');
        Route::view('pedidos', 'admin.pedidos.index')->name('pedidos.index');
   
    });
});
