<?php

namespace App\Interfaces\Clinicas;

use App\Models\Clinica;

interface GetClinicaServiceInterface
{
  public function fire(int $id): Clinica;
}
