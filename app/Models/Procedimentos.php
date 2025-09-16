<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Procedimentos extends Model
{
    protected $table = 'procedimentos';

    public function especialidade()
    {
        return $this->belongsTo(Especialidades::class, 'especialidade_id', 'id');
    }
}
