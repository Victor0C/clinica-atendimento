<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    public function enderecos(): BelongsToMany
    {
        return $this->belongsToMany(Endereco::class, 'endereco_paciente', 'paciente_id', 'endereco_id')->withTimestamps();
    }
}
