<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CleApiStoreRequest extends FormRequest
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
            /** Adresse e-mail associée à la clé (utile pour vous recontacter en cas d'abus). */
            'email' => ['required', 'email', 'max:255'],

            /** Nom de l'application cliente, à titre indicatif. */
            'nom_application' => ['nullable', 'string', 'max:255'],
        ];
    }
}
