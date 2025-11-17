<?php

namespace App\Services\Clinicas;

use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Interfaces\Clinicas\GetClinicaServiceInterface;
use App\Models\Clinica;

class GetClinicaService implements GetClinicaServiceInterface
{


  public function fire(int $id): Clinica
  {

    $clinica = Clinica::with(['enderecos', 'procedimentos.especialidade'])->find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    return $clinica;
  }
}
