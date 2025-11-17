<?php

use App\Http\Controllers\ClinicasController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ProcedimentosController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/pacientes');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::prefix('pacientes')->group(
        function () {
            Route::get('/', [PacientesController::class, 'getViewPacientes'])->name('pacientes');
            Route::post('/', [PacientesController::class, 'createPacientes']);
            Route::get('/novo', [PacientesController::class, 'getViewCreatePacientes']);
            Route::get('/editar/{id}', [PacientesController::class, 'getViewEditarPaciente']);
            Route::put('/editar/{id}', [PacientesController::class, 'editPaciente']);
            Route::get('/detalhes/{id}', [PacientesController::class, 'getViewDetalhesPacientes']);
            Route::delete('delete/{id}', [PacientesController::class, 'deletarPaciente']);
            Route::get('{id}/encaminhar', [PacientesController::class, 'encaminharPacienteView']);  
            Route::post('{id}/encaminhar', [PacientesController::class, 'encaminharPaciente']);
            Route::get('/encaminhamentos/{encaminhamento_id}/pdf', [PacientesController::class, 'encaminhamentosPdf']);
            Route::delete('/encaminhamentos/{encaminhamento_id}', [PacientesController::class, 'cancelarEncaminhamento']);
        }
    );

    Route::prefix('clinicas')->group(function () {
        Route::get('/', [ClinicasController::class, 'getViewClinicas']);
        Route::post('/', [ClinicasController::class, 'createClinicas']);
        Route::post('{clinica_id}/procedimentos/{procedimento_id}', [ClinicasController::class, 'addProcedimentos']);
        Route::delete('{clinica_id}/procedimentos/{procedimento_id}', [ClinicasController::class, 'removeProcedimentos']);
        Route::get('{clinica_id}/procedimentos', [ProcedimentosController::class, 'getAllNotInClinica']);
        Route::get('/novo', [ClinicasController::class, 'getViewCreateClinica']);
        Route::get('/editar/{id}', [ClinicasController::class, 'getViewEditarClinica']);
        Route::put('/editar/{id}', [ClinicasController::class, 'editClinica']);
        Route::get('/detalhes/{id}', [ClinicasController::class, 'getViewDetalhesClinicas']);
        Route::delete('delete/{id}', [ClinicasController::class, 'deletarClinica']);
    });

    Route::resource('procedimentos', ProcedimentosController::class);
    Route::resource('especialidades', EspecialidadeController::class);
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
