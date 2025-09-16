<?php

namespace App\Interfaces\Clinicas;


use App\DTOs\Clinicas\CreateClinicaDTO;
use App\Models\Clinicas;

interface CreateClinicaServiceInterface
{
  public function fire(CreateClinicaDTO $dto): Clinicas;
}
