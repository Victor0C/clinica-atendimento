<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Clinicas extends Model
{
    protected $table = 'clinicas';

    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'telefone_fixo',
        'celular',
        'email',
    ];

    public function enderecos(): BelongsToMany
    {
        return $this->belongsToMany(Endereco::class, 'endereco_clinica', 'clinica_id', 'endereco_id')->withTimestamps();
    }

    public function procedimentos(): BelongsToMany
    {
        return $this->belongsToMany(Procedimentos::class, 'procedimento_clinica', 'clinica_id', 'procedimento_id')
            ->withPivot('preco')
            ->withTimestamps();
    }
}
