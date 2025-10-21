<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEspecialidadeRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'noeme' => 'required|string|max:255',
        ];
    }
}
