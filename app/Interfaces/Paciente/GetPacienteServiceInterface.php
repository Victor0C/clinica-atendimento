<?php

namespace App\Interfaces\Paciente;

use App\Models\Paciente;

interface GetPacienteServiceInterface
{
    public function fire(int $id): Paciente;
}
