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

class ClinicasService implements ClinicasServiceInterface
{

  public function getAll(int $page, int $perPage = 20, ?SearchGetAllClinicasDTO $searchDTO = null): array
  {
    $service = app()->make(GetAllClinicasServiceInterface::class);
    return $service->fire($page, $perPage, $searchDTO);
  }

  public function get(int $id): ClinicaDTO
  {
    $service = app()->make(GetClinicaServiceInterface::class);
    return $service->fire($id);
  }

  public function create(CreateClinicaDTO $dto): ClinicaDTO
  {
    $service = app()->make(CreateClinicaServiceInterface::class);
    return $service->fire($dto);
  }

  public function edit(int $id, array $data): ClinicaDTO
  {
    $service = app()->make(EditClinicaServiceInterface::class);
    return $service->fire($id, $data);
  }

  public function delete(int $id): void
  {
    $service = app()->make(DeleteClinicaServiceInterface::class);
    $service->fire($id);
  }
}
