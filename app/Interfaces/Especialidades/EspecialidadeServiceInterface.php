<?php

namespace App\Interfaces\Especialidades;

use App\DTOs\Especialidades\EspecialidadeDTO;
use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Models\Especialidade;

interface EspecialidadeServiceInterface
{
    public function get($id): Especialidade;
    public function getAll(?SearchGetAllEspecialidadesDTO $searchDTO = null);
    public function create(array $data): Especialidade;
    public function update(int $id, array $data): Especialidade;
    public function delete(int $id): void;
}
