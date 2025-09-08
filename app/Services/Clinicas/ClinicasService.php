<?php

namespace App\Services\Clinicas;

use App\DTOs\Clinicas\SearchGetAllClinicasDTO;
use App\Interfaces\Clinicas\ClinicasServiceInterface;
use App\Interfaces\Clinicas\GetAllClinicasServiceInterface;

class ClinicasService implements ClinicasServiceInterface
{

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): array
  {
    $service = app()->make(GetAllClinicasServiceInterface::class);
    return $service->fire($page, $perPage, $searchDTO);
  }
}
