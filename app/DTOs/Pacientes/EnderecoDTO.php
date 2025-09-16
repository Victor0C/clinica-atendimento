<?php

namespace App\DTOs\Pacientes;

use App\Traits\ToArrayTrait;

class EnderecoDTO
{
  use ToArrayTrait;

  public int $id;
  public string $logradouro;
  public ?string $numero = null;
  public ?string $complemento = null;
  public string $bairro;
  public string $cidade;
  public string $estado;
  public string $cep;

  public function __construct(array $data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        $this->$key = $value;
      }
    }
  }
}
