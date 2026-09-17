<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArretResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'ordre' => $this->whenPivotLoaded('ligne_arret', fn () => $this->pivot->ordre),
            'commune' => new CommuneResource($this->whenLoaded('commune')),
        ];
    }
}
