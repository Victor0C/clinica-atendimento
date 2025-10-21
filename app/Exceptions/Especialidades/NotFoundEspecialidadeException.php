<?php

namespace App\Exceptions\Especialidades;

use Exception;

class NotFoundEspecialidadeException extends Exception
{
  protected $message = 'Especialidade não encontrada.';
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
