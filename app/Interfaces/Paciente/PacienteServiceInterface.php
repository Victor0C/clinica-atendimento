<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\DTOs\Pacientes\SearchGetAllPacientesDTO;

interface PacienteServiceInterface
{
    public function get(int $id): PacienteDTO;
    public function getAll(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): array;
    public function create(CreatePacienteDTO $dto): PacienteDTO;
    public function edit(int $id, array $data): PacienteDTO;
    public function delete(int $id): void;
}
