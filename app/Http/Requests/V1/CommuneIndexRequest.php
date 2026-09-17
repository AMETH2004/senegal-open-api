<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommuneIndexRequest extends FormRequest
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
            /** Code département pour ne lister que ses communes. */
            'departement' => ['nullable', 'string'],

            /** Code région pour ne lister que ses communes. */
            'region' => ['nullable', 'string', 'size:2'],

            /** Type de commune. */
            'type' => ['nullable', Rule::in(['commune', 'commune_arrondissement', 'ville'])],

            /** Filtre par nom (recherche partielle, insensible à la casse). */
            'nom' => ['nullable', 'string', 'max:255'],

            /** Tri : nom, population. Préfixe `-` pour un tri décroissant. Défaut : nom. */
            'sort' => ['nullable', 'string'],

            /** Nombre de résultats par page (1 à 100). Défaut : 15. */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
