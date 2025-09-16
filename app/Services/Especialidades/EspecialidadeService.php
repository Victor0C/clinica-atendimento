<?php

namespace App\Services\Especialidades;

use App\Interfaces\Especialidades\EspecialidadeServiceInterface;
use App\DTOs\Especialidades\EspecialidadeDTO;
use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Exceptions\Especialidades\NotFoundEspecialidadeException;
use App\Models\Especialidades;

class EspecialidadeService implements EspecialidadeServiceInterface
{
  public function get($id): Especialidades
  {
    $especialidade = Especialidades::find($id);

    if (!$especialidade) {
      throw new NotFoundEspecialidadeException();
    }

    return $especialidade;
  }

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllEspecialidadesDTO $searchDTO = null): array
  {
    $query = Especialidades::forPage($page, $perPage);

    if ($searchDTO) {

      if ($searchDTO->nome) {
        $query->where('nome', 'like', "%{$searchDTO->nome}%");
      }
    }

    return $query->get();
  }
}
