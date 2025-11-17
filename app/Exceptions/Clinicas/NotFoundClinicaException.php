<?php

namespace App\Exceptions\Clinicas;

use Exception;

class NotFoundClinicaException extends Exception
{
  protected $message = 'Clinica não encontrada.';
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
