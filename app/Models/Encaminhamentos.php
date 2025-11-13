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

    /**
     * Relação com a clínica de origem.
     */
    public function clinicaOrigem()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id_origem');
    }

    /**
     * Relação com a clínica de destino.
     */
    public function clinicaDestino()
    {
        return $this->belongsTo(Clinica::class, 'clinica_id_destino');
    }

    /**
     * Relação com o paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }

    /**
     * Relação com o procedimento da clínica.
     */
    public function procedimentoClinica()
    {
        return $this->belongsTo(ProcedimentoClinica::class, 'procedimento_clinica_id');
    }
}
