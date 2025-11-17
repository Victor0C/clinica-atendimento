<?php

namespace App\Interfaces\Procedimentos;

use App\Models\Procedimento;

interface ProcedimentosServiceInterface
{
  public function get(int $id): Procedimento;
  public function getAllNotInClinica(int $clinica_id);
  public function getAll(?string $search = null);
  public function create(array $data): Procedimento;
  public function update(int $id, array $data): Procedimento;
  public function delete(int $id): void;
}
