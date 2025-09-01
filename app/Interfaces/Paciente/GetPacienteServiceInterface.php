<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\PacienteDTO;

interface GetPacienteServiceInterface
{
    public function fire(int $id): PacienteDTO;
}
