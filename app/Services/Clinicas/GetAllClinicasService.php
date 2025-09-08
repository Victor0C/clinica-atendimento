<?php

namespace App\Services\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;

use App\Models\Clinicas;

class GetAllClinicasService implements GetAllClinicasServiceInterface
{


  public function fire(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): array
  {
    $query = Clinicas::with(['enderecos'])
      ->forPage($page, $perPage);

    if ($searchDTO) {
      if ($searchDTO->cnpj) {
        $query->where('cnpj', 'like', "%{$searchDTO->cnpj}%");
      }

      if ($searchDTO->nomeFantasia) {
        $query->where('nome_fantasia', 'like', "%{$searchDTO->nomeFantasia}%");
      }

      if ($searchDTO->razaoSocial) {
        $query->where('razao_social', 'like', "%{$searchDTO->razaoSocial}%");
      }
    }

    return $query->get()->map(function ($paciente) {
      return new ClinicaDTO($paciente->toArray());
    })->toArray();
  }
}
