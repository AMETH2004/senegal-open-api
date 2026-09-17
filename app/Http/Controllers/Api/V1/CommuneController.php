<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\CommuneIndexRequest;
use App\Http\Resources\ArretResource;
use App\Http\Resources\CommuneResource;
use App\Models\Commune;

class CommuneController extends Controller
{
    private const TRI_AUTORISE = ['nom', 'population'];

    /**
     * Liste les communes (chefs-lieux de département + communes
     * d'arrondissement de Dakar).
     */
    public function index(CommuneIndexRequest $request)
    {
        $requete = Commune::query()->with('departement.region');

        if ($codeDepartement = $request->validated('departement')) {
            $requete->whereHas('departement', fn ($q) => $q->where('code', $codeDepartement));
        }

        if ($codeRegion = $request->validated('region')) {
            $requete->whereHas('departement.region', fn ($q) => $q->where('code', $codeRegion));
        }

        if ($type = $request->validated('type')) {
            $requete->where('type', $type);
        }

        if ($nom = $request->validated('nom')) {
            $requete->where('nom', 'like', "%{$nom}%");
        }

        $this->appliquerTri($requete, $request, self::TRI_AUTORISE, 'nom');

        $parPage = $request->validated('per_page', 15);

        return CommuneResource::collection($requete->paginate($parPage)->withQueryString());
    }

    public function show(Commune $commune)
    {
        return new CommuneResource($commune->load('departement.region'));
    }

    /**
     * Arrêts de transport situés dans une commune (lien démographie ↔ transport).
     */
    public function arrets(Commune $commune)
    {
        return ArretResource::collection($commune->arrets()->orderBy('nom')->get());
    }
}
