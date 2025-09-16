<?php

namespace App\Interfaces\Clinicas;

use App\Models\Clinicas;

interface GetClinicaServiceInterface
{
  public function fire(int $id): Clinicas;
}
