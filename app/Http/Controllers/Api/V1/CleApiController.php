<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CleApiStoreRequest;
use App\Models\CleApi;

class CleApiController extends Controller
{
    /**
     * Émet une nouvelle clé API. La valeur en clair n'est retournée
     * qu'une seule fois, dans cette réponse : seul son empreinte SHA-256
     * est stockée côté serveur (comme un jeton Sanctum).
     */
    public function store(CleApiStoreRequest $request)
    {
        ['cle' => $cle, 'enregistrement' => $enregistrement] = CleApi::generer(
            $request->validated('email'),
            $request->validated('nom_application'),
        );

        return response()->json([
            'message' => 'Clé API créée. Conservez-la précieusement : elle ne sera plus jamais affichée.',
            'cle_api' => $cle,
            'en_tete_a_utiliser' => 'X-API-Key',
            'limite_de_debit' => '60 requêtes/minute',
            'cree_le' => $enregistrement->created_at->toIso8601String(),
        ], 201);
    }
}
