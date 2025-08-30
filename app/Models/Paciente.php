<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paciente extends Model
{
    use SoftDeletes;

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

    public function enderecos(): HasMany
    {
        return $this->hasMany(Endereco::class, 'paciente_id', 'id');
    }
}
