<?php

namespace App\Services\Procedimentos;

use App\Interfaces\Procedimentos\ProcedimentosServiceInterface;
use App\DTOs\Procedimentos\ProcedimentoDTO;
use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Exceptions\Procedimentos\NotFoundProcedimentoException;
use App\Models\Clinica;
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

  public function getAllNotInClinica(int $clinica_id)
  {
    $clinica = Clinica::with(['procedimentos', ])->find($clinica_id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    return Procedimento::whereNotIn('id', $clinica->procedimentos->pluck('id'))->get();
  }
}
