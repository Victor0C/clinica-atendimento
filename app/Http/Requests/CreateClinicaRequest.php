<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateClinicaRequest extends FormRequest
{
 
    public function rules(): array
    {
        return [
            'nome_fantasia' => 'required|string',
            'razao_social' => 'required|string',
            'cnpj' => 'required|string|size:14',
            'telefone_fixo' => 'sometimes|nullable|string|max:10',
            'celular' => 'sometimes|string|max:11',
            'email' => 'required|email|max:255',

            'enderecos' => 'required|array',

            'enderecos.*.logradouro' => 'required|string|max:255',
            'enderecos.*.numero' => 'nullable|string|max:10',
            'enderecos.*.complemento' => 'nullable|string|max:255',
            'enderecos.*.bairro' => 'required|string|max:255',
            'enderecos.*.cidade' => 'required|string|max:255',
            'enderecos.*.estado' => 'required|string|size:2',
            'enderecos.*.cep' => 'sometimes|string|size:8'
        ];
    }
}
