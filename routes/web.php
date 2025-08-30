<?php

use App\Http\Controllers\PacientesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth'])->group(function () {
    Route::prefix('pacientes')->group(
        function () {
            Route::get('/', [PacientesController::class, 'getViewPacientes']);
            Route::post('/', [PacientesController::class, 'createPacientes']);
            Route::get('/novo', [PacientesController::class, 'getViewCreatePacientes']);
            Route::get('/detalhes/{id}', [PacientesController::class, 'getViewDetalhesPacientes']);
        }
    );
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
