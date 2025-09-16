<?php

namespace App\Interfaces\Clinicas;

use App\Models\Clinicas;

interface EditClinicaServiceInterface
{
  public function fire(int $id, array $data): Clinicas;
}
