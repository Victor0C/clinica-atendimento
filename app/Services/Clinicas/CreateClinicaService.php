<?php

namespace App\Services\Clinicas;

use App\Interfaces\Clinicas\CreateClinicaServiceInterface;
use App\DTOs\Clinicas\ClinicaDTO;
use App\DTOs\Clinicas\CreateClinicaDTO;
use App\DTOs\Pacientes\EnderecoDTO;
use App\Exceptions\Clinicas\CNPJClinicaAlreadyUsedException;
use App\Exceptions\Clinicas\RazaoSocialClinicaAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Helpers\VerifyUniquesHelper;
use App\Models\Clinicas;
use App\Models\Endereco;

class CreateClinicaService implements CreateClinicaServiceInterface
{

  public function fire(CreateClinicaDTO $dto): Clinicas
  {
    $arrayDTO = $dto->toArray();

    VerifyUniquesHelper::verifyUniquesForCreate(
      Clinicas::class,
      $arrayDTO,
      ['cnpj', 'razao_social', 'email'],
      [
        'cnpj' => CNPJClinicaAlreadyUsedException::class,
        'razao_social' => RazaoSocialClinicaAlreadyUsedException::class,
        'email' => EmailAlreadyExistsException::class
      ]
    );

    $clinica = Clinicas::create($arrayDTO);

    foreach ($dto->enderecos as $enderecoDTO) {
      $endereco = Endereco::create($enderecoDTO->toArray());
      $clinica->enderecos()->attach($endereco->id);
    }

    return $clinica;
  }
}
