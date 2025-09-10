<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\EnderecoDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\Exceptions\Pacientes\CpfPacienteAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Exceptions\Pacientes\RgAlreadyExistsException;
use App\Helpers\VerifyPacienteUniquesHelper;
use App\Helpers\VerifyUniquesHelper;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Models\Endereco;
use App\Models\Paciente;


class CreatePacienteService implements CreatePacienteServiceInterface
{

  public function fire(CreatePacienteDTO $dto): PacienteDTO
  {
    $arrayDTO = $dto->toArray();
    
    VerifyUniquesHelper::verifyUniquesForCreate(
      Paciente::class,
      $arrayDTO,
      ['cpf', 'rg', 'email'],
      [
        'cpf' => CpfPacienteAlreadyUsedException::class,
        'rg' => RgAlreadyExistsException::class,
        'email' => EmailAlreadyExistsException::class
      ]
    );

    $paciente = Paciente::create($arrayDTO);

    $pacienteDto = new PacienteDTO($paciente->toArray());

    foreach ($dto->enderecos as $enderecoDTO) {
      $endereco = Endereco::create($enderecoDTO->toArray());
      $paciente->enderecos()->attach($endereco->id);
      $pacienteDto->enderecos[] = new EnderecoDTO($endereco->toArray());
    }


    return $pacienteDto;
  }
}
