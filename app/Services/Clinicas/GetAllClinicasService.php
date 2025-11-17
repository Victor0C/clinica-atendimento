<?php

namespace App\Services\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;

use App\Models\Clinica;
use Illuminate\Database\Eloquent\Collection;

class GetAllClinicasService implements GetAllClinicasServiceInterface
{


  public function fire(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): Collection
  {
    $query = Clinica::with(['enderecos', 'procedimentos.especialidade'])
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

    return $query->get();
  }
}
