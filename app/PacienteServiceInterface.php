<?php

namespace App;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;

interface PacienteServiceInterface
{
    public function get(int $id): PacienteDTO;
    public function create(CreatePacienteDTO $dto): PacienteDTO;
}
