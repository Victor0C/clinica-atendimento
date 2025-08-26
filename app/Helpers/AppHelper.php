<?php

namespace App\Helpers;

use Illuminate\Contracts\Container\Container;

class AppHelper
{
  public static function bindMultiple(Container $app, array $bindings): void
  {
    foreach ($bindings as $interface => $implementation) {
      $app->bind($interface, $implementation);
    }
  }
}
