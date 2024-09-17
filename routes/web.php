<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InnovationController;
use App\Http\Controllers\CreationController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


// Define la ruta resource para InnovationController
Route::resource('innovations', InnovationController::class);

// Define la ruta resource para InnovationController
Route::resource('creations', CreationController::class);
