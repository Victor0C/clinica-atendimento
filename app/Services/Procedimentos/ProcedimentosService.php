<?php

namespace App\Services\Procedimentos;

use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\DTOs\Procedimentos\ProcedimentoDTO;
use App\Exceptions\Procedimentos\NotFoundProcedimentoException;
use App\Models\Procedimento;

class ProcedimentosService implements ProcedimentosServiceInterface
{

  public function get(int $id): Procedimento
  {
    $procedimento = Procedimento::find($id);

    if (!$procedimento) {
      throw new NotFoundProcedimentoException();
    }

    return $procedimento;
  }
}
