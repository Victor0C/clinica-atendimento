<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Models\Clinicas;
use Illuminate\Database\Eloquent\Collection;

interface ClinicasServiceInterface
{
  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): Collection;
  public function get(int $id): Clinicas;
  public function create(CreateClinicaDTO $dto): Clinicas;
  public function edit(int $id, array $data): Clinicas;
  public function delete(int $id): void;
  public function addProcedimentos(int $id, int $procedimentoId, int $preco): Clinicas;
  public function removeProcedimentos(int $id, int $procedimentoId): Clinicas;
}
