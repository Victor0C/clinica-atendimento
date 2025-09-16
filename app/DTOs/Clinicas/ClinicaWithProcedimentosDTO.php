<?php

namespace App\DTOs\Clinicas;

use App\DTOs\Procedimentos\ProcedimentoDTO;
use App\Models\Procedimentos;
use App\Traits\FromModel;

class ClinicaWithProcedimentosDTO extends ClinicaDTO
{
  use FromModel;

  public array $procedimentos = [];

  public function __construct(array $data)
  {
    parent::__construct($data);

    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        if ($key == 'procedimentos') {
          foreach ($data['procedimentos'] as $procedimento) {
            $this->procedimentos[] = new ProcedimentoDTO($procedimento);
          }
        } else {
          $this->$key = $value;
        }
      }
    }
  }
}
