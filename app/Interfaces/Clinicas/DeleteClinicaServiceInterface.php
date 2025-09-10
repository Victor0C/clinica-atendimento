<?php

namespace App\Interfaces\Clinicas;

interface DeleteClinicaServiceInterface
{
  public function fire(int $id): void;
}
