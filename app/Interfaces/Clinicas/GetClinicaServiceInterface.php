<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;

interface GetClinicaServiceInterface
{
  public function fire(int $id): ClinicaDTO;
}
