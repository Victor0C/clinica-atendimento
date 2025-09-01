<?php

namespace App\DTOs\Pacientes;

class SearchGetAllPacientesDTO
{
  public function __construct(public ?string $cpf, public ?string $name, public ?string $email) {}
}
