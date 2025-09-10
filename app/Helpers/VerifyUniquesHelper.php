<?php

namespace App\Helpers;

class VerifyUniquesHelper
{
  public static function verifyUniquesForCreate(
    string $modelClass,
    array $data,
    array $uniqueFields,
    array $exceptions
  ) {
    $campos = self::extractFields($data, $uniqueFields);
    if (empty($campos)) return;

    $query = self::buildQuery($modelClass, $campos);

    $existingRecords = $query->get(array_keys($campos));

    self::throwIfExists($existingRecords, $campos, $exceptions);
  }

  public static function verifyUniquesForEdit(
    string $modelClass,
    int $id,
    array $data,
    array $uniqueFields,
    array $exceptions
  ) {
    $campos = self::extractFields($data, $uniqueFields);
    if (empty($campos)) return;

    $query = self::buildQuery($modelClass, $campos)
      ->where('id', '<>', $id);

    $existingRecords = $query->get(array_keys($campos));

    self::throwIfExists($existingRecords, $campos, $exceptions);
  }

  private static function buildQuery(string $modelClass, array $campos)
  {
    $query = $modelClass::query();

    $first = true;
    $query->where(function ($q) use ($campos, &$first) {
      foreach ($campos as $key => $value) {
        if ($first) {
          $q->where($key, $value);
          $first = false;
        } else {
          $q->orWhere($key, $value);
        }
      }
    })
    ->withTrashed();

    return $query;
  }

  private static function extractFields(array $data, array $uniqueFields): array
  {
    return array_filter(
      array_intersect_key($data, array_flip($uniqueFields)),
      fn($value) => !is_null($value)
    );
  }

  private static function throwIfExists($existingRecords, array $campos, array $exceptions)
  {
    foreach ($existingRecords as $record) {
      foreach ($campos as $key => $value) {
        if ($record->{$key} === $value && isset($exceptions[$key])) {
          throw new $exceptions[$key]();
        }
      }
    }
  }
}
