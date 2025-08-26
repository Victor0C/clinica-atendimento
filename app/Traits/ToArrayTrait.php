<?php

namespace App\Traits;

trait ToArrayTrait
{

  public function toArray(): array
  {
    $result = [];

    foreach (get_object_vars($this) as $key => $value) {
      if (is_object($value)) {
        $result[$key] = method_exists($value, 'toArray') ? $value->toArray() : (array)$value;
      } elseif (is_array($value)) {
        $result[$key] = array_map(function ($item) {
          if (is_object($item)) {
            return method_exists($item, 'toArray') ? $item->toArray() : (array)$item;
          }
          return $item;
        }, $value);
      } else {
        $result[$key] = $value;
      }
    }

    return $result;
  }
}
