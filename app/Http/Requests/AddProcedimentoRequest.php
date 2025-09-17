<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddProcedimentoRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'preco' => ['nullable', 'integer']
        ];
    }
}
