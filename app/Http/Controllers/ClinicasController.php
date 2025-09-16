<?php

namespace App\Http\Controllers;

use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Enums\Pacientes\GetAllEnum;
use App\Helpers\RequestHelper;
use App\Http\Requests\CreateClinicaRequest;
use App\Http\Requests\EditClinicaRequest;
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
      return response()->json($pageData);
    }

    return Inertia::render('Clinica/Clinica')->with(['page' => $pageData]);
  }

  public function getViewCreateClinica()
  {
    return Inertia::render('Clinica/CriarEditarClinica');
  }

  public function getViewEditarClinica($id, ClinicasServiceInterface $service)
  {
    try {
      return Inertia::render('Clinica/CriarEditarClinica')->with(['clinica' => $service->get($id)]);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function editClinica(EditClinicaRequest $request, $id, ClinicasServiceInterface $service)
  {
    try {
      return response()->json($service->edit($id, $request->validated()), 200);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function getViewDetalhesClinicas($id, ClinicasServiceInterface $service)
  {
    try {
      return Inertia::render('Clinica/DetalhesClinica/DetalhesClinica')->with(['clinica' => $service->get($id)]);
    } catch (\Throwable $e) {
      return RequestHelper::onError($e);
    }
  }

  public function createClinicas(CreateClinicaRequest $request, ClinicasServiceInterface $service)
  {
    try {
      return response()->json($service->create(new CreateClinicaDTO($request->validated())), 201);
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
