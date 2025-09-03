<?php

namespace App\Services\Pacientes;

use App\Interfaces\EditPacienteServiceInterface;
use App\DTOs\Pacientes\PacienteDTO;
use App\Exceptions\Pacientes\NotFoundPacienteException;
use App\Interfaces\Paciente\PacienteServiceInterface;
use App\Models\Paciente;

class EditPacienteService implements EditPacienteServiceInterface
{
  public function __construct(private PacienteServiceInterface $_PACIENTE_SERVICE) {}


  public function fire(int $id, array $data): PacienteDTO
  {
    $paciente = Paciente::with('enderecos')->find($id);

    if (!$paciente) {
      throw new NotFoundPacienteException();
    }

    $paciente->fill($data);
    $paciente->save();

    if (!empty($data['enderecos'])) {
      foreach ($data['enderecos'] as $enderecoData) {
        $endereco = $paciente->enderecos->firstWhere('id', $enderecoData['id']);
        if ($endereco) {
          $endereco->fill($enderecoData);
          $endereco->save();
        }
      }
    }

    return PacienteDTO::fromModel($paciente);
  }
}
