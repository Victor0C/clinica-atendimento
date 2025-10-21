<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Collection;

interface PacienteServiceInterface
{
    public function get(int $id): Paciente;
    public function getAll(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): Collection;
    public function create(CreatePacienteDTO $dto): Paciente;
    public function edit(int $id, array $data): Paciente;
    public function delete(int $id): void;
}
