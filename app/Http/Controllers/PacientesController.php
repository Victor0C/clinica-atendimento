<?php

namespace App\Http\Controllers;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\Helpers\RequestHelper;
use App\Http\Requests\CreatePacienteRequest;
use App\PacienteServiceInterface;;
use Inertia\Inertia;

class PacientesController extends Controller
{
    public function getViewPacientes(){
        return Inertia::render('Pacientes');
    }
    public function getViewCreatePacientes()
    {
        return Inertia::render('CriarEditarPaciente');
    }

    public function createPacientes(CreatePacienteRequest $request, PacienteServiceInterface $pacienteService)
    {
        try {
            return response()->json($pacienteService->create(new CreatePacienteDTO($request->validated())), 201);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }
}
