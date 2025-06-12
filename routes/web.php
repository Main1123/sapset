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

Route::get('/', function () {
    return view('landing.landing');
});

Auth::routes();

Route::view('/landing', 'landing.landing')->name('landing');

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Rutas de administración
    Route::prefix('admin')->name('admin.')->group(function () {
        // Route::get('/', [App\Http\Controllers\usersController::class, 'dashboard'])->name('home');
        Route::resource('imagenes', App\Http\Controllers\imagenesController::class);
        Route::resource('servicios', App\Http\Controllers\serviciosController::class);
        Route::resource('pedidos', App\Http\Controllers\pedidosController::class);
        Route::get('profile', [App\Http\Controllers\usersController::class, 'profile'])->name('profile');
        Route::post('profile', [App\Http\Controllers\usersController::class, 'updateProfile'])->name('profile.update');
    });
});
