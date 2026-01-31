<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identificador' => $this->id_animal,
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'peso' => $this->peso,
            'enfermedad' => $this->enfermedad,
            'comentarios' => $this->comentarios,
            'identificador_owner' => $this->owner_id
        ];
    }
}
