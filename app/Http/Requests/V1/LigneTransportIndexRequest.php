<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class LigneTransportIndexRequest extends FormRequest
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
            /** Slug de l'opérateur pour ne lister que ses lignes (ex: dakar-dem-dikk, aftu). */
            'operateur' => ['nullable', 'string'],

            /** Nombre de résultats par page (1 à 100). Défaut : 15. */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
