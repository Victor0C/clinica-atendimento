<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Interfaces\Paciente\DeletePacienteServiceInterface;
use App\Interfaces\Paciente\EditPacienteServiceInterface;
use App\Interfaces\Paciente\GetAllPacienteServiceInterface;
use App\Interfaces\Paciente\GetPacienteServiceInterface;
use App\Interfaces\Paciente\PacienteServiceInterface;
use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\Models\Encaminhamentos;
use App\Models\Paciente;
use App\Models\ProcedimentoClinica;
use Illuminate\Database\Eloquent\Collection;

class PacienteService implements PacienteServiceInterface
{
  public function create(CreatePacienteDTO $dto): Paciente
  {
    $service = app()->make(CreatePacienteServiceInterface::class);

    return $service->fire($dto);
  }

  public function get(int $id): Paciente
  {
    $service = app()->make(GetPacienteServiceInterface::class);

    return $service->fire($id);
  }

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): Collection
  {
    $service = app()->make(GetAllPacienteServiceInterface::class);
    return $service->fire($page, $perPage, $searchDTO);
  }

  public function delete(int $id): void
  {
    $service = app()->make(DeletePacienteServiceInterface::class);
    $service->fire($id);
  }

  public function edit(int $id, array $data): Paciente
  {
    $service = app()->make(EditPacienteServiceInterface::class);
    return $service->fire($id, $data);
  }

  public function encaminhar(int $paciente_id, int $clinica_id, int $procedimento_id): void
  {
    $this->get($paciente_id);

    $clinicaService = app()->make(ClinicasServiceInterface::class);
    $clinicaService->get($clinica_id);

    $procedimentoService = app()->make(ProcedimentosServiceInterface::class);
    $procedimentoService->get($procedimento_id);

    Encaminhamentos::create([
      'clinica_id_destino' => $clinica_id,
      'paciente_id' => $paciente_id,
      'procedimento_id' => $procedimento_id,
    ]);
  }
}
