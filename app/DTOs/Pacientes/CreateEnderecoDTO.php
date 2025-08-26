<?php

namespace App\DTOs\Pacientes;

use App\Traits\ToArrayTrait;

class CreateEnderecoDTO
{
  use ToArrayTrait;

  public string $logradouro;
  public ?string $numero = null;
  public ?string $complemento = null;
  public string $bairro;
  public string $cidade;
  public string $estado;
  public string $cep;

  public function __construct(array $data)
  {
    $this->logradouro = $data['logradouro'];
    $this->numero = $data['numero'] ?? null;
    $this->complemento = $data['complemento'] ?? null;
    $this->bairro = $data['bairro'];
    $this->cidade = $data['cidade'];
    $this->estado = $data['estado'];
    $this->cep = $data['cep'];
  }
}
