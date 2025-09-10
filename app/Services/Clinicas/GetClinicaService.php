<?php

namespace App\Services\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;
use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Interfaces\Clinicas\GetClinicaServiceInterface;
use App\Models\Clinicas;

class GetClinicaService implements GetClinicaServiceInterface
{


  public function fire(int $id): ClinicaDTO
  {

    $clinica = Clinicas::with(['enderecos'])->find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    return new ClinicaDTO($clinica->toArray());
  }
}
