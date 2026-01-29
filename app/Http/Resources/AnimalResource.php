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
            'identificador' => $request->id_animal,
            'nombre' => $request->nombre,
            'tipo' => $request->tipo,
            'peso' => $request->peso,
            'enfermedad' => $request->enfermedad,
            'comentarios' => $request->comentarios,
            'identificador_owner' => $request->owner_id
        ];
    }
}
