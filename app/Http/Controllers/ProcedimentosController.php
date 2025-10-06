<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
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
}
