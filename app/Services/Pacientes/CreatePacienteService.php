<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\EnderecoDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\Helpers\VerifyPacienteUniquesHelper;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Models\Endereco;
use App\Models\Paciente;


class CreatePacienteService implements CreatePacienteServiceInterface
{

  public function fire(CreatePacienteDTO $dto): PacienteDTO
  {
    VerifyPacienteUniquesHelper::verifyUniquesForCreate($dto);
    $paciente = Paciente::create($dto->toArray());

    $pacienteDto = new PacienteDTO($paciente->toArray());

    foreach ($dto->enderecos as $enderecoDTO) {
      $endereco = Endereco::create($enderecoDTO->toArray());
      $paciente->enderecos()->attach($endereco->id);
      $pacienteDto->enderecos[] = new EnderecoDTO($endereco->toArray());
    }


    return $pacienteDto;
  }
}
