<?php

namespace App\Services\Pacientes;

use App\Exceptions\Pacientes\NotFoundPacienteException;
use App\Interfaces\Paciente\DeletePacienteServiceInterface;
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
