<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class ArretIndexRequest extends FormRequest
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
            /** Code commune pour ne lister que ses arrêts. */
            'commune' => ['nullable', 'string'],

            /** Nombre de résultats par page (1 à 100). Défaut : 15. */
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
