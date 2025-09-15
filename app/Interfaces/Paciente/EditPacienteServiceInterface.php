<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\PacienteDTO;

interface EditPacienteServiceInterface
{
    public function fire(int $id, array $data): PacienteDTO;
}
