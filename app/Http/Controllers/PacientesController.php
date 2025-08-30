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
        return Inertia::render('Pacientes/Pacientes');
    }
    public function getViewCreatePacientes()
    {
        return Inertia::render('Pacientes/CriarEditarPaciente');
    }

    public function getViewDetalhesPacientes($id, PacienteServiceInterface $pacienteService)
    {
        try {
            return Inertia::render('Pacientes/DetalhesPaciente/DetalhesPaciente')->with(['paciente' => $pacienteService->get($id)]);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function createPacientes(CreatePacienteRequest $request, PacienteServiceInterface $pacienteService)
    {
        try {
            return response()->json($pacienteService->create(new CreatePacienteDTO($request->validated())), 201);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function deletarPaciente($id, PacienteServiceInterface $pacienteService)
    {
        try {
            $pacienteService->delete($id);
            return response()->noContent();
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }
}
