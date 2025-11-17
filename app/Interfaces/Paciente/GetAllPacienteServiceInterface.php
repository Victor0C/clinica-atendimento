<?php

namespace App\Interfaces\Paciente;

use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use Illuminate\Database\Eloquent\Collection;

interface GetAllPacienteServiceInterface
{
    public function fire(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): Collection;
}
