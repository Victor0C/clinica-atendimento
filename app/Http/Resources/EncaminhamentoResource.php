<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EncaminhamentoResource extends JsonResource
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

            'clinica' => $this->whenLoaded('clinicaDestino', function () {
                return [
                    'id' => $this->clinicaDestino->id,
                    'nome' => $this->clinicaDestino->nome_fantasia,
                ];
            }),

            'procedimento' => $this->whenLoaded('procedimento', function () {
                return [
                    'id' => $this->procedimento->id,
                    'nome' => $this->procedimento->nome,
                ];
            }),

            'data_encaminhamento' => $this->created_at,
        ];
    }
}
