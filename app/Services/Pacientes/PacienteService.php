<?php

namespace App\Services\Pacientes;

use App\CreatePacienteServiceInterface;
use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\GetPacienteServiceInterface;
use App\PacienteServiceInterface;

class PacienteService implements PacienteServiceInterface
{
  public function create(CreatePacienteDTO $dto): PacienteDTO
  {
    $service = app()->make(CreatePacienteServiceInterface::class);

    return $service->fire($dto);
  }

  public function get(int $id): PacienteDTO
  {
    $service = app()->make(GetPacienteServiceInterface::class);

    return $service->fire($id);
  }
}
