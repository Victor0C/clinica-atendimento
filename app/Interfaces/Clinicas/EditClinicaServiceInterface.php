<?php

namespace App\Interfaces\Clinicas;

use App\Models\Clinica;

interface EditClinicaServiceInterface
{
  public function fire(int $id, array $data): Clinica;
}
