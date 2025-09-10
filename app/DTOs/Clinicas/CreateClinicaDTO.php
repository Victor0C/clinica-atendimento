<?php

namespace App\DTOs\Clinicas;

use App\DTOs\Pacientes\CreateEnderecoDTO;
use App\Traits\ToArrayTrait;

class CreateClinicaDTO
{
  use ToArrayTrait;

  public string $nome_fantasia;
  public string $razao_social;
  public string $cnpj;
  public ?string $telefone_fixo;
  public string $celular;
  public string $email;

  public array $enderecos = [];

  public function __construct(array $data)
  {
    $this->nome_fantasia = $data['nome_fantasia'];
    $this->razao_social = $data['razao_social'];
    $this->cnpj = $data['cnpj'];
    $this->telefone_fixo = $data['telefone_fixo'] ?? null;
    $this->celular = $data['celular'];
    $this->email = $data['email'];


    if (isset($data['enderecos'])) {
      foreach ($data['enderecos'] as $endereco) {
        $this->enderecos[] = new CreateEnderecoDTO($endereco);
      }
    }
  }
}
