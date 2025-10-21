<?php

namespace App\Interfaces\Clinicas;


use App\DTOs\Clinicas\CreateClinicaDTO;
use App\Models\Clinica;

interface CreateClinicaServiceInterface
{
  public function fire(CreateClinicaDTO $dto): Clinica;
}
