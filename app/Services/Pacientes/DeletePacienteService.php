<?php

namespace App\Services\Pacientes;

use App\DeletePacienteServiceInterface;
use App\Exceptions\Pacientes\NotFoundPacienteException;
use App\Models\Paciente;

class DeletePacienteService implements DeletePacienteServiceInterface
{

  public function fire($id): void
  {
    $paciente = Paciente::find($id);

    if (!$paciente) {
      throw new NotFoundPacienteException();
    }

    $paciente->delete();
  }
}
