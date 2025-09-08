<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\SearchGetAllClinicasDTO;

interface ClinicasServiceInterface
{
  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): array;
}
