<?php

namespace App\Interfaces\Procedimentos;

use App\DTOs\Procedimentos\ProcedimentoDTO;

interface ProcedimentosServiceInterface
{
  public function get(int $id): ProcedimentoDTO;
}
