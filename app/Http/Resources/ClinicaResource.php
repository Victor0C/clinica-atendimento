<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClinicaResource extends JsonResource
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
            'nome_fantasia' => $this->nome_fantasia,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'telefone_fixo' => $this->telefone_fixo,
            'celular'  => $this->celular,
            'email' => $this->email,

            'enderecos' => EnderecoResource::collection($this->whenLoaded('enderecos')),
            'procedimentos' => ProcedimentoResource::collection($this->whenLoaded('procedimentos')),
        ];
    }
}
