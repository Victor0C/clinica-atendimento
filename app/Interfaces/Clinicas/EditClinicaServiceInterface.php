<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;

interface EditClinicaServiceInterface
{
  public function fire(int $id, array $data): ClinicaDTO;
}
