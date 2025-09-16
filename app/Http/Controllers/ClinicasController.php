<?php

namespace App\Http\Controllers;

use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Enums\Pacientes\GetAllEnum;
use App\Helpers\RequestHelper;
use App\Http\Requests\CreateClinicaRequest;
use App\Http\Requests\EditClinicaRequest;
use App\Http\Resources\ClinicaResource;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClinicasController extends Controller
{
  public function getViewClinicas(Request $request, ClinicasServiceInterface $clinicaService)
  {
    $page = $request->input('page', GetAllEnum::PAGE->value);
    $perPage = $request->input('perPage', GetAllEnum::PER_PAGE->value);
    $searchDTO = new SearchGetAllClinicasDTO(
      cnpj: $request->input('cnpj'),
      razaoSocial: $request->input('razaoSocial'),
      nomeFantasia: $request->input('nomeFantasia')
    );

    $pageData = $clinicaService->getAll($page, $perPage, $searchDTO);

    if ($request->wantsJson()) {
      return response()->json(ClinicaResource::collection($pageData));
    }

    return Inertia::render('Clinicas/Clinicas')->with(['page' => ClinicaResource::collection($pageData)]);
  }

  public function getViewCreateClinica()
  {
    return Inertia::render('Clinicas/CriarEditarClinica');
  }

  public function getViewEditarClinica($id, ClinicasServiceInterface $service)
  {
    try {
      return Inertia::render('Clinicas/CriarEditarClinica')->with(['clinica' => new ClinicaResource($service->get($id))]);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function editClinica(EditClinicaRequest $request, $id, ClinicasServiceInterface $service)
  {
    try {
      return response()->json(new ClinicaResource($service->edit($id, $request->validated())), 200);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function getViewDetalhesClinicas($id, ClinicasServiceInterface $service)
  {
    try {
      return Inertia::render('Clinicas/DetalhesClinica/DetalhesClinica')->with(['clinica' => new ClinicaResource($service->get($id))]);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function createClinicas(CreateClinicaRequest $request, ClinicasServiceInterface $service)
  {
    try {
      return response()->json(new ClinicaResource($service->create(new CreateClinicaDTO($request->validated()))), 201);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function deletarClinica($id, ClinicasServiceInterface $service)
  {
    try {
      $service->delete($id);
      return response()->noContent();
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }


}
