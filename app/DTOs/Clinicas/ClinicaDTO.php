<?php

namespace App\DTOs\Clinicas;

use App\DTOs\Pacientes\EnderecoDTO;
use App\Traits\FromModel;

class ClinicaDTO
{
  use FromModel;

  public int $id;
  public string $nome_fantasia;
  public string $razao_social;
  public string $cnpj;
  public ?string $telefone_fixo;
  public string $celular;
  public string $email;

  public array $enderecos = [];

  public function __construct(array $data)
  {
    foreach ($data as $key => $value) {
      if (property_exists($this, $key)) {
        if ($key == 'enderecos') {
          foreach ($data['enderecos'] as $endereco) {
            $this->enderecos[] = new EnderecoDTO($endereco);
          }
        } else {
          $this->$key = $value;
        }
      }
    }
  }
}
