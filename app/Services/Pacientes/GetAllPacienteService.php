<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\SearchGetAllPacientesDTO;
use App\Interfaces\Paciente\GetAllPacienteServiceInterface;
use App\Models\Paciente;
use Illuminate\Database\Eloquent\Collection;

class GetAllPacienteService implements GetAllPacienteServiceInterface
{

  public function fire(int $page, int $perPage = 20, ?SearchGetAllPacientesDTO $searchDTO = null): Collection
  {
    $query = Paciente::with(['enderecos'])
      ->forPage($page, $perPage);

    if ($searchDTO) {
      if ($searchDTO->cpf) {
        $query->where('cpf', 'like', "%{$searchDTO->cpf}%");
      }

      if ($searchDTO->name) {
        $query->where('nome', 'like', "%{$searchDTO->name}%");
      }

      if ($searchDTO->email) {
        $query->where('email', 'like', "%{$searchDTO->email}%");
      }
    }

    return $query->get();
  }
}
