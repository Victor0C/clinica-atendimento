<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
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
            $especialidades = $service->getAll();

            if ($request->wantsJson()) {
                return response()->json(EspecialidadeResource::collection($especialidades), 200);
            }

            return abort(404);
        } catch (\Throwable $e) {
            return RequestHelper::onError($e);
        }
    }

    public function create()
    {
        return abort(404);
    }

    public function store(Request $request)
    {
        return abort(404);
    }

    public function show($id)
    {
        return abort(404);
    }

    public function edit($id)
    {
        return abort(404);
    }

    public function update(Request $request, $id)
    {
        return abort(404);
    }

    public function destroy($id)
    {
        return abort(404);
    }
}
