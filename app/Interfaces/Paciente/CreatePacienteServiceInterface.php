<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\Models\Paciente;

interface CreatePacienteServiceInterface
{
    public function fire(CreatePacienteDTO $dto): Paciente;
}
