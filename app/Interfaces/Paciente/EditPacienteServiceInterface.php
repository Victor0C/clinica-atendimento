<?php

namespace App\Interfaces\Paciente;

use App\Models\Paciente;

interface EditPacienteServiceInterface
{
    public function fire(int $id, array $data): Paciente;
}
