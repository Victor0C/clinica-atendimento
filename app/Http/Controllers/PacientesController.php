<?php

namespace App\Http\Controllers;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use App\Enums\Pacientes\GetAllEnum;
use App\Helpers\RequestHelper;
use App\Http\Requests\CreatePacienteRequest;
use App\Http\Requests\EditPacienteRequest;
use App\Http\Resources\PacienteResource;
use App\Interfaces\Paciente\PacienteServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;;

class PacientesController extends Controller
{
    public function getViewPacientes(Request $request, PacienteServiceInterface $pacienteService)
    {
        $page = $request->input('page', GetAllEnum::PAGE->value);
        $perPage = $request->input('perPage', GetAllEnum::PER_PAGE->value);
        $searchDTO = new SearchGetAllPacientesDTO(
            cpf: $request->input('cpf'),
            name: $request->input('name'),
            email: $request->input('email')
        );

        $pageData = $pacienteService->getAll($page, $perPage, $searchDTO);

        if ($request->wantsJson()) {
            return response()->json(PacienteResource::collection($pageData));
        }

        return Inertia::render('Pacientes/Pacientes')->with(['page' => $pageData]);
    }

    public function getViewCreatePacientes()
    {
        return Inertia::render('Pacientes/CriarEditarPaciente');
    }

    public function getViewEditarPaciente($id, PacienteServiceInterface $pacienteService)
    {
        try {
            return Inertia::render('Pacientes/CriarEditarPaciente')->with(['paciente' => $pacienteService->get($id)]);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function editPaciente(EditPacienteRequest $request, $id, PacienteServiceInterface $pacienteService)
    {
        try {
            return response()->json(new PacienteResource($pacienteService->edit($id, $request->validated())), 200);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function getViewDetalhesPacientes($id, PacienteServiceInterface $pacienteService)
    {
        try {
            return Inertia::render('Pacientes/DetalhesPaciente/DetalhesPaciente')->with(['paciente' => new PacienteResource($pacienteService->get($id))]);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function createPacientes(CreatePacienteRequest $request, PacienteServiceInterface $pacienteService)
    {
        try {
            return response()->json(
                new PacienteResource($pacienteService->create(new CreatePacienteDTO($request->validated()))),
                201
            );
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
