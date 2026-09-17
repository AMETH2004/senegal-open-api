<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            /** Filtre par nom de région (recherche partielle, insensible à la casse). */
            'nom' => ['nullable', 'string', 'max:255'],

            /** Ne garde que les régions dont la population est au moins égale à cette valeur. */
            'population_min' => ['nullable', 'integer', 'min:0'],

            /** Tri : nom, population, superficie_km2. Préfixe `-` pour un tri décroissant. Défaut : nom. */
            'sort' => ['nullable', 'string'],

            /** Nombre de résultats par page (1 à 100). Défaut : 15. */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
