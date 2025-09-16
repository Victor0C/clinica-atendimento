<?php

namespace App\Exceptions\Procedimentos;

use Exception;

class NotFoundProcedimentoException extends Exception
{
  protected $message = 'Procedimento não encontrada.';
  protected $code = 404;

  public function __construct($message = null, $code = null)
  {
    if ($message) {
      $this->message = $message;
    }

    if ($code) {
      $this->code = $code;
    }

    parent::__construct($this->message, $this->code);
  }
}
