<?php

use App\Http\Controllers\ClinicasController;
use App\Http\Controllers\PacientesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/pacientes');
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
            Route::get('/editar/{id}', [PacientesController::class, 'getViewEditarPaciente']);
            Route::put('/editar/{id}', [PacientesController::class, 'editPaciente']);
            Route::get('/detalhes/{id}', [PacientesController::class, 'getViewDetalhesPacientes']);
            Route::delete('delete/{id}', [PacientesController::class, 'deletarPaciente']);
        }
    );

    Route::prefix('clinicas')->group(function () {
        Route::get('/', [ClinicasController::class, 'getViewClinicas']);
    });
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
