<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LigneTransportResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'numero' => $this->numero,
            'nom' => $this->nom,
            'operateur' => new OperateurTransportResource($this->whenLoaded('operateur')),
            'origine' => new CommuneResource($this->whenLoaded('origineCommune')),
            'destination' => new CommuneResource($this->whenLoaded('destinationCommune')),
            'arrets' => ArretResource::collection($this->whenLoaded('arrets')),
        ];
    }
}
