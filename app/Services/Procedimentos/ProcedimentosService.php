<?php

namespace App\Services\Procedimentos;

use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\DTOs\Procedimentos\ProcedimentoDTO;
use App\Exceptions\Procedimentos\NotFoundProcedimentoException;
use App\Models\Procedimentos;

class ProcedimentosService implements ProcedimentosServiceInterface
{

  public function get(int $id): Procedimentos
  {
    $procedimento = Procedimentos::find($id);

    if (!$procedimento) {
      throw new NotFoundProcedimentoException();
    }

    return $procedimento;
  }
}
