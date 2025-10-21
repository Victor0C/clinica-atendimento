<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEspecialidadeRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'nome' => 'sometimes|string|max:255',
        ];
    }
}
