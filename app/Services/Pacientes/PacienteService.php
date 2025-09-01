<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Interfaces\Paciente\DeletePacienteServiceInterface;
use App\Interfaces\Paciente\GetAllPacienteServiceInterface;
use App\Interfaces\Paciente\GetPacienteServiceInterface;
use App\Interfaces\Paciente\PacienteServiceInterface;

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

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): array
  {
    $service = app()->make(GetAllPacienteServiceInterface::class);
    return $service->fire($page, $perPage, $searchDTO);
  }

  public function delete(int $id): void
  {
    $service = app()->make(DeletePacienteServiceInterface::class);
    $service->fire($id);
  }
}
