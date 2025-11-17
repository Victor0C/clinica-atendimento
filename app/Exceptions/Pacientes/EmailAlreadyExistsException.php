<?php

namespace App\Exceptions\Pacientes;

use Exception;

class EmailAlreadyExistsException extends Exception
{
  protected $message = 'E-mail já em uso';
  protected $code = 422;

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