<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Http\Requests\CreateProcedimentoRequest;
use App\Http\Requests\UpdateProcedimentoRequest;
use App\Http\Resources\ProcedimentoResource;
use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentosController extends Controller
{
    public function getAllNotInClinica($clinica_id)
    {
        try {
            $service = app()->make(ProcedimentosServiceInterface::class);
            return response()->json(ProcedimentoResource::collection($service->getAllNotInClinica($clinica_id)), 200);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function index(Request $request)
    {
        try {
            $service = app()->make(ProcedimentosServiceInterface::class);
            $procedimentos = $service->getAll($request->query('search'));
            if ($request->acceptsJson()) {
                return response()->json(ProcedimentoResource::collection($procedimentos), 200);
            }

            return view('procedimentos.index', [
                'procedimentos' => ProcedimentoResource::collection($procedimentos)
            ]);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function store(CreateProcedimentoRequest $request)
    {
        try {
            $service = app()->make(ProcedimentosServiceInterface::class);
            return response()->json(new ProcedimentoResource($service->create($request->validated())), 201);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function update(UpdateProcedimentoRequest $request, $id)
    {
        try {
            $service = app()->make(ProcedimentosServiceInterface::class);
            return response()->json(new ProcedimentoResource($service->update($id, $request->all())), 200);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function destroy($id)
    {
        try {
            $service = app()->make(ProcedimentosServiceInterface::class);
            $service->delete($id);
            return response()->json(null, 204);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }
}
