<?php

namespace App\DTOs\Procedimentos;

use App\Traits\FromModel;

class ProcedimentoDTO
{
  use FromModel;

  public int $id;
  public string $nome;
  public string $especialidade;
  public ?int $preco;

  public function __construct(array $data)
  {
    foreach ($data as $key => $value) {

      if (property_exists($this, $key)) {
        if ($key == 'especialidade' && isset($data[$key]['nome'])) {
          $this->especialidade = $value['nome'];
        } else {
          $this->$key = $value;
        }
      }
    }

    if (isset($data['pivot'])) {
      $this->preco = $data['pivot']['preco'] ?? null;
    }
  }
}
