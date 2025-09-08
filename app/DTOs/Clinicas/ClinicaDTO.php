<?php

namespace App\DTOs\Clinicas;

use App\DTOs\Pacientes\EnderecoDTO;
use App\Traits\FromModel;

class ClinicaDTO
{
  use FromModel;

  public int $id;
  public string $nomeFantasia;
  public string $razaoSocial;
  public string $cnpj;
  public string $rg;
  public string $telefoneFixo;
  public string $celular;
  public string $email;

  public array $enderecos = [];

  public function __construct(array $data)
  {
    $this->id = $data['id'];
    $this->nomeFantasia = $data['nome_fantasia'];
    $this->razaoSocial = $data['razao_social'];
    $this->cnpj = $data['cnpj'];
    $this->rg = $data['telefone_fixo'];
    $this->telefoneFixo = $data['telefone_fixo'] ?? null;
    $this->celular = $data['celular'];
    $this->email = $data['email'];

    if (isset($data['enderecos'])) {
      foreach ($data['enderecos'] as $endereco) {
        $this->enderecos[] = new EnderecoDTO($endereco);
      }
    }
  }
}
