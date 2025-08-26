<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class RequestHelper
{
  public static function onError(\Throwable $e)
  {
    $code = $e->getCode();
    $message = $e->getMessage();

    if ($code >= 400 && $code < 500) {
      return response()->json(['message' => $message], $code);
    }

    Log::error($e);

    return response()->json(['message' => 'Internal error'], 500);
  }
}
