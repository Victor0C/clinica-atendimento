<?php

namespace App\Services\Clinicas;

use App\Interfaces\Clinicas\EditClinicaServiceInterface;
use App\DTOs\Clinicas\ClinicaDTO;
use App\Exceptions\Clinicas\CNPJClinicaAlreadyUsedException;
use App\Exceptions\Clinicas\NotFoundClinicaException;
use App\Exceptions\Clinicas\RazaoSocialClinicaAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Helpers\VerifyUniquesHelper;
use App\Models\Clinicas;

class EditClinicaService implements EditClinicaServiceInterface
{


  public function fire(int $id, array $data): Clinicas
  {
    $clinica = Clinicas::with('enderecos')->find($id);

    if (!$clinica) {
      throw new NotFoundClinicaException();
    }

    VerifyUniquesHelper::verifyUniquesForEdit(
      Clinicas::class,
      $id,
      $data,
      ['cnpj', 'razao_social', 'email'],
      [
        'cnpj' => CNPJClinicaAlreadyUsedException::class,
        'razao_social' => RazaoSocialClinicaAlreadyUsedException::class,
        'email' => EmailAlreadyExistsException::class
      ]
    );

    $clinica->fill($data);
    $clinica->save();

    if (!empty($data['enderecos'])) {
      foreach ($data['enderecos'] as $enderecoData) {
        $endereco = $clinica->enderecos->firstWhere('id', $enderecoData['id']);
        if ($endereco) {
          $endereco->fill($enderecoData);
          $endereco->save();
        }
      }
    }

    return $clinica;
  }
}
