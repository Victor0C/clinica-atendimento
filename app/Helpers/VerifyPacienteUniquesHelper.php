<?php

namespace App\Helpers;

use App\DTOs\Pacientes\CreatePacienteDTO;
use App\Exceptions\Pacientes\CpfPacienteAlreadyUsedException;
use App\Exceptions\Pacientes\EmailAlreadyExistsException;
use App\Exceptions\Pacientes\RgAlreadyExistsException;
use App\Models\Paciente;

class VerifyPacienteUniquesHelper
{

  private static array $uniqueFields = ['cpf', 'rg', 'email'];

  public static function verifyUniquesForCreate(CreatePacienteDTO $dto)
  {
    $campos = self::extractFieldsFromDto($dto);

    if (empty($campos)) {
      return;
    }

    $existingPacientes = Paciente::where(function ($query) use ($campos) {
      $first = true;
      foreach ($campos as $key => $value) {
        if ($first) {
          $query->where($key, $value);
          $first = false;
        } else {
          $query->orWhere($key, $value);
        }
      }
    })
      ->withTrashed()
      ->get(self::$uniqueFields);

    self::throwIfExists($existingPacientes, $campos);
  }

  public static function verifyUniquesForEdit(int $id, array $data)
  {
    $campos = array_intersect_key($data, array_flip(self::$uniqueFields));
    $campos = array_filter($campos, fn($value) => !is_null($value));

    if (empty($campos)) {
      return;
    }

    $existingPacientes = Paciente::where(function ($query) use ($campos) {
      $first = true;
      foreach ($campos as $key => $value) {
        if ($first) {
          $query->where($key, $value);
          $first = false;
        } else {
          $query->orWhere($key, $value);
        }
      }
    })
      ->withTrashed()
      ->where('id', '<>', $id)
      ->get(self::$uniqueFields);

    self::throwIfExists($existingPacientes, $campos);
  }

  private static function throwIfExists($existingPacientes, array $campos)
  {
    foreach ($existingPacientes as $paciente) {
      foreach ($campos as $key => $value) {
        if ($paciente->{$key} === $value) {
          self::throwExceptionForField($key);
        }
      }
    }
  }

  private static function throwExceptionForField(string $field)
  {
    match ($field) {
      'cpf' => throw new CpfPacienteAlreadyUsedException(),
      'rg' => throw new RgAlreadyExistsException(),
      'email' => throw new EmailAlreadyExistsException(),
      default => null,
    };
  }

  private static function extractFieldsFromDto(CreatePacienteDTO $dto): array
  {
    $campos = [];
    foreach (self::$uniqueFields as $field) {
      if (isset($dto->{$field}) && !is_null($dto->{$field})) {
        $campos[$field] = $dto->{$field};
      }
    }
    return $campos;
  }
}
