<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OperateurTransportResource;
use App\Models\OperateurTransport;

class OperateurTransportController extends Controller
{
    /**
     * Liste les opérateurs de transport (ex: Dakar Dem Dikk, AFTU).
     */
    public function index()
    {
        return OperateurTransportResource::collection(
            OperateurTransport::withCount('lignes')->orderBy('nom')->get()
        );
    }

    public function show(OperateurTransport $operateurTransport)
    {
        return new OperateurTransportResource($operateurTransport->loadCount('lignes'));
    }
}
