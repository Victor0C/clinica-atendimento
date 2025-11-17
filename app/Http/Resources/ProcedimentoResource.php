<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcedimentoResource extends JsonResource
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
            'especialidade' => $this->whenLoaded('especialidade', function () {
                return $this->especialidade->nome;
            }),
            'preco' => $this->whenPivotLoaded('procedimento_clinica', function () {
                return $this->pivot->preco;
            }),
        ];
    }
}
