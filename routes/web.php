<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InnovationController;
use App\Http\Controllers\CreationController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\RuletaController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Agrupar las rutas que requieren autenticación
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Define las rutas resources para InnovationController, CreationController y VideoController
    Route::resource('innovations', InnovationController::class);
    Route::resource('creations', CreationController::class);
    Route::resource('videos', VideoController::class);
});


Route::get('/ruleta',  [RuletaController::class, 'index'])->name('ruleta');
