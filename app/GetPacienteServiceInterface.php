<?php

namespace App;

use App\DTOs\Pacientes\PacienteDTO;

interface GetPacienteServiceInterface
{
    public function fire(int $id): PacienteDTO;
}
