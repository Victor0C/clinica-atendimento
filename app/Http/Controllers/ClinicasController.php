<?php

namespace App\Http\Controllers;

use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Enums\Pacientes\GetAllEnum;
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

    return Inertia::render('Clinicas/Clinicas')->with(['page' => $pageData]);
  }
}
