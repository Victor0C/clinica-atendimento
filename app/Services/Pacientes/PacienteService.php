<?php

namespace App\Services\Pacientes;

use App\CreatePacienteServiceInterface;
use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\PacienteServiceInterface;

class PacienteService implements PacienteServiceInterface
{
  public function create(CreatePacienteDTO $dto): PacienteDTO
  {
    $service = app()->make(CreatePacienteServiceInterface::class);

    return $service->fire($dto);
  }
}
