<?php

namespace App\Interfaces\Especialidades;

use App\DTOs\Especialidades\EspecialidadeDTO;
use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Models\Especialidades;

interface EspecialidadeServiceInterface
{
    public function get($id): Especialidades;
    public function getAll(int $page, int $perPage = 20, ?SearchGetAllEspecialidadesDTO $searchDTO = null): array;
}
