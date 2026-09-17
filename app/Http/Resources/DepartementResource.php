<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartementResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'nom' => $this->nom,
            'chef_lieu' => $this->chef_lieu,
            'population' => $this->population,
            'region' => new RegionResource($this->whenLoaded('region')),
            'nombre_communes' => $this->whenCounted('communes'),
        ];
    }
}
