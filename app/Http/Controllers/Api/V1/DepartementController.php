<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\DepartementIndexRequest;
use App\Http\Requests\V1\PaginationRequest;
use App\Http\Resources\CommuneResource;
use App\Http\Resources\DepartementResource;
use App\Models\Departement;

class DepartementController extends Controller
{
    private const TRI_AUTORISE = ['nom', 'population'];

    /**
     * Liste les 46 départements du Sénégal.
     */
    public function index(DepartementIndexRequest $request)
    {
        $requete = Departement::query()->with('region')->withCount('communes');

        if ($codeRegion = $request->validated('region')) {
            $requete->whereHas('region', fn ($q) => $q->where('code', $codeRegion));
        }

        if ($nom = $request->validated('nom')) {
            $requete->where('nom', 'like', "%{$nom}%");
        }

        $this->appliquerTri($requete, $request, self::TRI_AUTORISE, 'nom');

        $parPage = $request->validated('per_page', 15);

        return DepartementResource::collection($requete->paginate($parPage)->withQueryString());
    }

    public function show(Departement $departement)
    {
        return new DepartementResource($departement->load('region')->loadCount('communes'));
    }

    /**
     * Communes d'un département.
     */
    public function communes(Departement $departement, PaginationRequest $request)
    {
        $communes = $departement->communes()
            ->orderBy('nom')
            ->paginate($request->validated('per_page', 15))
            ->withQueryString();

        return CommuneResource::collection($communes);
    }
}
