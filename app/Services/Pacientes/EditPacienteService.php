<?php

namespace App\Services\Pacientes;

use App\DTOs\Pacientes\PacienteDTO;
use App\Exceptions\Pacientes\CpfPacienteAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Exceptions\Pacientes\NotFoundPacienteException;
use App\Exceptions\Pacientes\RgAlreadyExistsException;
use App\Helpers\VerifyPacienteUniquesHelper;
use App\Helpers\VerifyUniquesHelper;
use App\Interfaces\Paciente\EditPacienteServiceInterface;
use App\Interfaces\Paciente\PacienteServiceInterface;
use App\Models\Paciente;

class EditPacienteService implements EditPacienteServiceInterface
{
  public function __construct(private PacienteServiceInterface $_PACIENTE_SERVICE) {}


  public function fire(int $id, array $data): Paciente
  {
    $paciente = Paciente::with('enderecos')->find($id);

    if (!$paciente) {
      throw new NotFoundPacienteException();
    }

    VerifyUniquesHelper::verifyUniquesForEdit(
      Paciente::class,
      $id,
      $data,
      ['cpf', 'rg', 'email'],
      [
        'cpf' => CpfPacienteAlreadyUsedException::class,
        'rg' => RgAlreadyExistsException::class,
        'email' => EmailAlreadyExistsException::class
      ]
    );

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

    return $paciente;
  }
}
