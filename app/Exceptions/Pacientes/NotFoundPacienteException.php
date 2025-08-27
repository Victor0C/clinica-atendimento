<?php

namespace App\Exceptions\Pacientes;

use Exception;

class NotFoundPacienteException extends Exception
{
  protected $message = 'Paciente não encontrado.';
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
