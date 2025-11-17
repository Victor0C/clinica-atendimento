<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\PacienteDTO;
use App\Exceptions\Pacientes\NotFoundPacienteException;
use App\Interfaces\Paciente\GetPacienteServiceInterface;
use App\Models\Paciente;

class GetPacienteService implements GetPacienteServiceInterface
{

  public function fire(int $id): Paciente
  {
    $paciente = Paciente::with(['enderecos', 'encaminhamentos.clinicaDestino', 'encaminhamentos.procedimento'])->find($id);

    if (!$paciente) {
      throw new NotFoundPacienteException();
    }

    return $paciente;
  }
}
