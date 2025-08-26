<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePacienteRequest extends FormRequest
{


    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|size:14',
            'rg' => 'required|string|max:20',
            'sexo' => 'required|in:M,F,O',
            'telefone_fixo' => 'nullable|string|max:15',
            'celular' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'convenio' => 'nullable|string|max:50',
            'numero_carteirinha' => 'nullable|string|max:30',
            'observacoes' => 'nullable|string',
            'status' => 'required|in:ativo,inativo',

            'enderecos' => 'required|array',

            'enderecos.*.logradouro' => 'required|string|max:255',
            'enderecos.*.numero' => 'nullable|string|max:10',
            'enderecos.*.complemento' => 'nullable|string|max:255',
            'enderecos.*.bairro' => 'required|string|max:255',
            'enderecos.*.cidade' => 'required|string|max:255',
            'enderecos.*.estado' => 'required|string|size:2',
            'enderecos.*.cep' => 'required|string|size:9',
        ];
    }
}
