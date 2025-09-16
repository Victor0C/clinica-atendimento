<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Models\Clinica;
use Illuminate\Database\Eloquent\Collection;

interface ClinicasServiceInterface
{
  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): Collection;
  public function get(int $id): Clinica;
  public function create(CreateClinicaDTO $dto): Clinica;
  public function edit(int $id, array $data): Clinica;
  public function delete(int $id): void;
  public function addProcedimentos(int $id, int $procedimentoId, int $preco): Clinica;
  public function removeProcedimentos(int $id, int $procedimentoId): Clinica;
}
