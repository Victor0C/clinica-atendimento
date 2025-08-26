<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = "pacientes";

    protected $fillable = [
        'nome',
        'data_nascimento',
        'cpf',
        'rg',
        'sexo',
        'telefone_fixo',
        'celular',
        'email',
        'convenio',
        'numero_carteirinha',
        'observacoes',
        'status',
    ];
}
