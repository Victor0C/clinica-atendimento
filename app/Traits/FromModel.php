<?php

namespace App\Traits;

use ReflectionClass;

trait FromModel
{
  public static function fromModel(object $model): static
  {
    $reflection = new ReflectionClass(static::class);
    $constructor = $reflection->getConstructor();

    $args = [];

    if ($constructor) {
      foreach ($constructor->getParameters() as $param) {
        $name = $param->getName();

        $args[] = $model->{$name} ?? null;
      }
    }

    return new static($model->toArray());
  }
}
