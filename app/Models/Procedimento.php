<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Procedimento extends Model
{
    protected $table = 'procedimentos';

    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'especialidade_id', 'id');
    }
}
