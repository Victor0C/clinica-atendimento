<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Clinicas\SearchGetAllClinicasDTO;

interface ClinicasServiceInterface
{
  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): array;
  public function get(int $id): ClinicaDTO;
  public function create(CreateClinicaDTO $dto): ClinicaDTO;
  public function edit(int $id, array $data): ClinicaDTO;
  public function delete(int $id): void;
}
