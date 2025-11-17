<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClinicaRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nome_fantasia' => 'sometimes|string',
            'razao_social' => 'sometimes|string',
            'cnpj' => 'sometimes|string|size:14',
            'telefone_fixo' => 'sometimes|nullable|string|max:10',
            'celular' => 'sometimes|string|max:11',
            'email' => 'sometimes|email|max:255',

            'enderecos' => 'sometimes|array',

            'enderecos.*.id' => 'required_with:enderecos|integer',
            'enderecos.*.logradouro' => 'sometimes|string|max:255',
            'enderecos.*.numero' => 'sometimes|nullable|string|max:10',
            'enderecos.*.complemento' => 'sometimes|nullable|string|max:255',
            'enderecos.*.bairro' => 'sometimes|string|max:255',
            'enderecos.*.cidade' => 'sometimes|string|max:255',
            'enderecos.*.estado' => 'sometimes|string|size:2',
            'enderecos.*.cep' => 'sometimes|string|size:8'
        ];
    }
}
