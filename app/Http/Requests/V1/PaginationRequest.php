<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Pagination simple, réutilisée par les routes imbriquées (ex:
 * /regions/{code}/departements) qui n'exposent pas d'autre filtre.
 */
class PaginationRequest extends FormRequest
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
            /** Nombre de résultats par page (1 à 100). Défaut : 15. */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
