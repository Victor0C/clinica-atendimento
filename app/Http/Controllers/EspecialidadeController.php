<?php

namespace App\Http\Controllers;

use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Helpers\RequestHelper;
use App\Http\Requests\CreateEspecialidadeRequest;
use App\Http\Requests\UpdateEspecialidadeRequest;
use App\Http\Resources\EspecialidadeResource;
use App\Interfaces\Especialidades\EspecialidadeServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EspecialidadeController extends Controller
{
    public function index(Request $request)
    {
        try {
            $service = app()->make(EspecialidadeServiceInterface::class);
            $especialidades = $service->getAll(new SearchGetAllEspecialidadesDTO(
                nome: $request->query('search')
            ));

            if ($request->wantsJson()) {
                return response()->json(EspecialidadeResource::collection($especialidades), 200);
            }

            return Inertia::render('Especialidades/Especialidades', [
                'page' => EspecialidadeResource::collection($especialidades)
            ]);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function store(CreateEspecialidadeRequest $request, EspecialidadeServiceInterface $service)
    {
        try {
            $especialidade = $service->create($request->validated());
            return response()->json(new EspecialidadeResource($especialidade), 201);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function update(UpdateEspecialidadeRequest $request, $id, EspecialidadeServiceInterface $service)
    {
        try {
            $especialidade = $service->update($id, $request->validated());
            return response()->json(new EspecialidadeResource($especialidade), 200);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function destroy($id, EspecialidadeServiceInterface $service)
    {
        try {
            $service->delete($id);
            return response()->noContent();
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }
}
