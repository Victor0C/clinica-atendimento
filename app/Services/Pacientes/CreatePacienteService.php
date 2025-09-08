<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\DTOs\Pacientes\EnderecoDTO;
use App\DTOs\Pacientes\PacienteDTO;
use App\Exceptions\Pacientes\CpfPacienteAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Exceptions\Pacientes\RgAlreadyExistsException;
use App\Interfaces\Paciente\CreatePacienteServiceInterface;
use App\Models\Endereco;
use App\Models\Paciente;


class CreatePacienteService implements CreatePacienteServiceInterface
{

  public function fire(CreatePacienteDTO $dto): PacienteDTO
  {
    $this->verifyUniques($dto);
    $paciente = Paciente::create($dto->toArray());

    $pacienteDto = new PacienteDTO($paciente->toArray());

    foreach ($dto->enderecos as $enderecoDTO) {
      $endereco = Endereco::create($enderecoDTO->toArray());
      $paciente->enderecos()->attach($endereco->id);
      $pacienteDto->enderecos[] = new EnderecoDTO($endereco->toArray());
    }


    return $pacienteDto;
  }

  private function verifyUniques(CreatePacienteDTO $dto)
  {
    $existingPacientes = Paciente::where('cpf', $dto->cpf)
      ->orWhere('rg', $dto->rg)
      ->orWhere('email', $dto->email)
      ->withTrashed()
      ->get(['cpf', 'rg', 'email']);

    foreach ($existingPacientes as $paciente) {
      if ($paciente->cpf === $dto->cpf) {
        throw new CpfPacienteAlreadyUsedException();
      }

      if ($paciente->rg === $dto->rg) {
        throw new RgAlreadyExistsException();
      }

      if ($paciente->email === $dto->email) {
        throw new EmailAlreadyExistsException();
      }
    }
  }
}
