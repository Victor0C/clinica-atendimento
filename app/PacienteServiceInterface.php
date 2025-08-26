<?php

namespace App;

use App\DTOs\Pacientes\CreatePacienteDTO;

interface PacienteServiceInterface
{
    public function create(CreatePacienteDTO $dto);
}
