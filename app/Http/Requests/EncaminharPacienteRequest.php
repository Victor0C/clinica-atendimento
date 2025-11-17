<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EncaminharPacienteRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'clinica_id' => 'required|integer',
            'procedimento_id' => 'required|integer',
        ];
    }
}
