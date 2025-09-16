<?php

namespace App\Traits;

use ReflectionClass;

trait FromModel
{
  public static function fromModel(object $model): static
  {
    $data = $model->toArray();
    return new static($data);
  }
}
