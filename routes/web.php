<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InnovationController;
use App\Http\Controllers\CreationController;
use App\Http\Controllers\VideoController;

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

// Define la ruta resource para CreationController
Route::resource('creations', CreationController::class);

// Define la ruta resource para VideoController
Route::resource('videos', VideoController::class);

