<?php

namespace App\DTOs\Especialidades;

use App\Traits\FromModel;

class EspecialidadeDTO
{
  use FromModel;

  public string $nome;

  public function __construct(array $data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }
}
