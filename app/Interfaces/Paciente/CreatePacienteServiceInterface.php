<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;

interface CreatePacienteServiceInterface
{
    public function fire(CreatePacienteDTO $dto): PacienteDTO;
}
