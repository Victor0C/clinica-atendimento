<?php

namespace App\Services\Clinicas;

use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Interfaces\Clinicas\DeleteClinicaServiceInterface;
use App\Models\Clinicas;

class DeleteClinicaService implements DeleteClinicaServiceInterface
{

  public function fire(int $id): void
  {

    $clinica = Clinicas::find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    $clinica->delete();
  }
}
