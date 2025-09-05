<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPacienteRequest extends FormRequest
{
  public function rules(): array
  {
    return [
      'nome' => 'sometimes|string|max:255',
      'data_nascimento' => 'sometimes|date',
      'cpf' => 'sometimes|string|size:14',
      'rg' => 'sometimes|string|max:20',
      'sexo' => 'sometimes|in:M,F,O',
      'telefone_fixo' => 'sometimes|nullable|string|max:15',
      'celular' => 'sometimes|string|max:15',
      'email' => 'sometimes|email|max:255',
      'convenio' => 'sometimes|nullable|string|max:50',
      'numero_carteirinha' => 'sometimes|nullable|string|max:30',
      'observacoes' => 'sometimes|nullable|string',
      'status' => 'sometimes|in:ativo,inativo',

      'enderecos' => 'sometimes|array',

      'enderecos.*.id' => 'required_with:enderecos|integer',
      'enderecos.*.logradouro' => 'sometimes|string|max:255',
      'enderecos.*.numero' => 'sometimes|nullable|string|max:10',
      'enderecos.*.complemento' => 'sometimes|nullable|string|max:255',
      'enderecos.*.bairro' => 'sometimes|string|max:255',
      'enderecos.*.cidade' => 'sometimes|string|max:255',
      'enderecos.*.estado' => 'sometimes|string|size:2',
      'enderecos.*.cep' => 'sometimes|string|size:9',
    ];
  }
}
