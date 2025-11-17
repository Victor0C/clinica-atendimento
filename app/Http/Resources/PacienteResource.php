<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EnderecoResource;

class PacienteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'data_nascimento' => $this->data_nascimento,
            'cpf' => $this->cpf,
            'rg' => $this->rg,
            'sexo' => $this->sexo,
            'telefone_fixo' => $this->telefone_fixo,
            'celular' => $this->celular,
            'email' => $this->email,
            'convenio' => $this->convenio,
            'numero_carteirinha' => $this->numero_carteirinha,
            'observacoes' => $this->observacoes,
            'status' => $this->status,
            'enderecos' => EnderecoResource::collection($this->whenLoaded('enderecos')),
            'encaminhamentos' => EncaminhamentoResource::collection($this->whenLoaded('encaminhamentos')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
