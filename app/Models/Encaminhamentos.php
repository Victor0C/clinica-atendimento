<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encaminhamentos extends Model
{
    use HasFactory;

    protected $table = 'encaminhamentos';

    protected $fillable = [
        'clinica_id_destino',
        'paciente_id',
        'procedimento_id',
    ];


    public function clinicaDestino()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id_destino');
    }


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class, 'procedimento_id');
    }
}
