<?php

namespace App\Interfaces\Especialidades;

use App\DTOs\Especialidades\EspecialidadeDTO;
use App\DTOs\Especialidades\SearchGetAllEspecialidadesDTO;
use App\Models\Especialidade;

interface EspecialidadeServiceInterface
{
    public function get($id): Especialidade;
    public function getAll(?SearchGetAllEspecialidadesDTO $searchDTO = null);
}
