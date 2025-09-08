<?php

namespace App\DTOs\Clinicas;

class SearchGetAllClinicasDTO
{
  public function __construct(public ?string $cnpj, public ?string $nomeFantasia, public ?string $razaoSocial) {}
}
