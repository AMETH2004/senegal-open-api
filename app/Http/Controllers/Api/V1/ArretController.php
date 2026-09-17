<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ArretIndexRequest;
use App\Http\Resources\ArretResource;
use App\Models\Arret;

class ArretController extends Controller
{
    /**
     * Liste les arrêts de transport.
     */
    public function index(ArretIndexRequest $request)
    {
        $requete = Arret::query()->with('commune');

        if ($codeCommune = $request->validated('commune')) {
            $requete->whereHas('commune', fn ($q) => $q->where('code', $codeCommune));
        }

        $parPage = $request->validated('per_page', 15);

        return ArretResource::collection($requete->orderBy('nom')->paginate($parPage)->withQueryString());
    }

    public function show(Arret $arret)
    {
        return new ArretResource($arret->load('commune'));
    }
}
