<?php

namespace App\DTOs\Pacientes;

use App\Traits\FromModel;

class PacienteDTO
{
  use FromModel;

  public int $id;
  public string $nome;
  public string $data_nascimento;
  public string $cpf;
  public string $rg;
  public string $sexo;
  public ?string $telefone_fixo = null;
  public string $celular;
  public string $email;
  public ?string $convenio = null;
  public ?string $numero_carteirinha = null;
  public ?string $observacoes = null;
  public string $status;

  public array $enderecos = [];

  public function __construct(array $data)
  {
    $this->id = $data['id'];
    $this->nome = $data['nome'];
    $this->data_nascimento = $data['data_nascimento'];
    $this->cpf = $data['cpf'];
    $this->rg = $data['rg'];
    $this->sexo = $data['sexo'];
    $this->telefone_fixo = $data['telefone_fixo'] ?? null;
    $this->celular = $data['celular'];
    $this->email = $data['email'];
    $this->convenio = $data['convenio'] ?? null;
    $this->numero_carteirinha = $data['numero_carteirinha'] ?? null;
    $this->observacoes = $data['observacoes'] ?? null;
    $this->status = $data['status'];

    if (isset($data['enderecos'])) {
      foreach ($data['enderecos'] as $endereco) {
        $this->enderecos[] = new EnderecoDTO($endereco);
      }
    }
  }
}
