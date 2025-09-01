<?php

namespace App\Interfaces\Paciente;

interface DeletePacienteServiceInterface
{
    public function fire($id): void;
}
