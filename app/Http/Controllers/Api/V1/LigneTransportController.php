<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LigneTransportIndexRequest;
use App\Http\Resources\ArretResource;
use App\Http\Resources\LigneTransportResource;
use App\Models\LigneTransport;

class LigneTransportController extends Controller
{
    /**
     * Liste les lignes de transport.
     */
    public function index(LigneTransportIndexRequest $request)
    {
        $requete = LigneTransport::query()->with(['operateur', 'origineCommune', 'destinationCommune']);

        if ($slugOperateur = $request->validated('operateur')) {
            $requete->whereHas('operateur', fn ($q) => $q->where('slug', $slugOperateur));
        }

        $parPage = $request->validated('per_page', 15);

        return LigneTransportResource::collection($requete->orderBy('numero')->paginate($parPage)->withQueryString());
    }

    public function show(LigneTransport $ligneTransport)
    {
        return new LigneTransportResource(
            $ligneTransport->load(['operateur', 'origineCommune', 'destinationCommune'])
        );
    }

    /**
     * Arrêts d'une ligne, dans l'ordre de passage.
     */
    public function arrets(LigneTransport $ligneTransport)
    {
        return ArretResource::collection($ligneTransport->arrets()->with('commune')->get());
    }
}
