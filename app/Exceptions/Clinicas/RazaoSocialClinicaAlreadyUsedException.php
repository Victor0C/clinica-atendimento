<?php

namespace App\Exceptions\Clinicas;

use Exception;

class RazaoSocialClinicaAlreadyUsedException extends Exception
{
  protected $message = 'Razão social já cadastrada em outra clinica';
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
