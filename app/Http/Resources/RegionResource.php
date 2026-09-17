<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegionResource extends JsonResource
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
            'superficie_km2' => $this->superficie_km2,
            'population' => $this->population,
            'densite_hab_km2' => $this->densite(),
            'nombre_departements' => $this->whenCounted('departements'),
        ];
    }
}
