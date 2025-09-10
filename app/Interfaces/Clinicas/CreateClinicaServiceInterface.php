<?php

namespace App\Interfaces\Clinicas;

use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\CreateClinicaDTO;

interface CreateClinicaServiceInterface
{
  public function fire(CreateClinicaDTO $dto): ClinicaDTO;
}
