<?php

namespace App\Services\Clinicas;

use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;
use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\CreateClinicaDTO;
use App\Interfaces\Clinicas\CreateClinicaServiceInterface;
use App\Interfaces\Clinicas\DeleteClinicaServiceInterface;
use App\Interfaces\Clinicas\EditClinicaServiceInterface;
use App\Interfaces\Clinicas\GetClinicaServiceInterface;
use App\DTOs\Clinicas\ClinicaWithProcedimentosDTO;
use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Models\Clinicas;
use App\Services\Procedimentos\ProcedimentosService;
use Illuminate\Database\Eloquent\Collection;

class ClinicasService implements ClinicasServiceInterface
{

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): Collection 
  {
    $service = app()->make(GetAllClinicasServiceInterface::class);
    return $service->fire($page, $perPage, $searchDTO);
  }

  public function get(int $id): Clinicas
  {
    $service = app()->make(GetClinicaServiceInterface::class);
    return $service->fire($id);
  }

  public function create(CreateClinicaDTO $dto): Clinicas
  {
    $service = app()->make(CreateClinicaServiceInterface::class);
    return $service->fire($dto);
  }

  public function edit(int $id, array $data): Clinicas
  {
    $service = app()->make(EditClinicaServiceInterface::class);
    return $service->fire($id, $data);
  }

  public function delete(int $id): void
  {
    $service = app()->make(DeleteClinicaServiceInterface::class);
    $service->fire($id);
  }

  public function addProcedimentos(int $id, int $procedimentoId, int $preco): Clinicas
  {
    $clinica = Clinicas::with(['enderecos'])->find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    $procedimentoService = app()->make(ProcedimentosService::class);
    $procedimento = $procedimentoService->get($procedimentoId);

    $clinica->procedimentos()->attach([$procedimento->id => ['preco' => $preco]]);
    $clinica->load('procedimentos');

    return $clinica;
  }

  public function removeProcedimentos(int $id, int $procedimentoId): Clinicas
  {
    $clinica = Clinicas::with(['enderecos'])->find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    $procedimentoService = app()->make(ProcedimentosService::class);
    $procedimento = $procedimentoService->get($procedimentoId);

    $clinica->procedimentos()->detach([$procedimento->id]);
    $clinica->load('procedimentos.especialidade');

    return $clinica;
  }
}
