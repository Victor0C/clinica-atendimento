<?php

namespace App\Services\Pacientes;

use App\CreatePacienteServiceInterface;
use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\EnderecoDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\Models\Endereco;
use App\Models\Paciente;


class CreatePacienteService implements CreatePacienteServiceInterface
{

  public function fire(CreatePacienteDTO $dto): PacienteDTO
  {
    $paciente = Paciente::create($dto->toArray());

    $pacienteDto = new PacienteDTO($paciente->toArray());

    foreach ($dto->enderecos as $enderecoDTO) {

      $pacienteDto->enderecos[] = new EnderecoDTO(Endereco::create(array_merge(['paciente_id' => $pacienteDto->id], $enderecoDTO->toArray()))->toArray());
    }

    return $pacienteDto;
  }
}
