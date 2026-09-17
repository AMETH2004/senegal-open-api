<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RegionIndexRequest;
use App\Http\Requests\V1\PaginationRequest;
use App\Http\Resources\DepartementResource;
use App\Http\Resources\RegionResource;
use App\Models\Region;

class RegionController extends Controller
{
    private const TRI_AUTORISE = ['nom', 'population', 'superficie_km2'];

    /**
     * Liste les 14 régions du Sénégal.
     */
    public function index(RegionIndexRequest $request)
    {
        $requete = Region::query()->withCount('departements');

        if ($nom = $request->validated('nom')) {
            $requete->where('nom', 'like', "%{$nom}%");
        }

        if ($populationMin = $request->validated('population_min')) {
            $requete->where('population', '>=', (int) $populationMin);
        }

        $this->appliquerTri($requete, $request, self::TRI_AUTORISE, 'nom');

        $parPage = $request->validated('per_page', 15);

        return RegionResource::collection($requete->paginate($parPage)->withQueryString());
    }

    /**
     * Détail d'une région, identifiée par son code (ex: DK, TH).
     */
    public function show(Region $region)
    {
        return new RegionResource($region->loadCount('departements'));
    }

    /**
     * Départements d'une région.
     */
    public function departements(Region $region, PaginationRequest $request)
    {
        $departements = $region->departements()
            ->withCount('communes')
            ->orderBy('nom')
            ->paginate($request->validated('per_page', 15))
            ->withQueryString();

        return DepartementResource::collection($departements);
    }
}
