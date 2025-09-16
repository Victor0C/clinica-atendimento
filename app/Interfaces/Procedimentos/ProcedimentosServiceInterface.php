<?php

namespace App\Interfaces\Procedimentos;

use App\Models\Procedimento;

interface ProcedimentosServiceInterface
{
  public function get(int $id): Procedimento;
}
