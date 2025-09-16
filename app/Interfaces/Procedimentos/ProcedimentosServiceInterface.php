<?php

namespace App\Interfaces\Procedimentos;

use App\Models\Procedimentos;

interface ProcedimentosServiceInterface
{
  public function get(int $id): Procedimentos;
}
