<?php

use App\Http\Controllers\Api\V1\ArretController;
use App\Http\Controllers\Api\V1\CleApiController;
use App\Http\Controllers\Api\V1\CommuneController;
use App\Http\Controllers\Api\V1\DepartementController;
use App\Http\Controllers\Api\V1\LigneTransportController;
use App\Http\Controllers\Api\V1\OperateurTransportController;
use App\Http\Controllers\Api\V1\RegionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API SenegalOpenAPI v1 — démographie & transport urbain (open data)
|--------------------------------------------------------------------------
| Toutes les routes de données exigent une clé API (en-tête X-API-Key,
| voir POST /v1/cles-api) et sont limitées à 60 req/min par clé.
*/

Route::prefix('v1')->group(function () {
    Route::get('/sante', fn () => response()->json(['statut' => 'ok', 'version' => 'v1']));
    Route::post('/cles-api', [CleApiController::class, 'store']);

    Route::middleware(['cle-api', 'throttle:cle-api'])->group(function () {
        Route::get('/regions', [RegionController::class, 'index']);
        Route::get('/regions/{region:code}', [RegionController::class, 'show']);
        Route::get('/regions/{region:code}/departements', [RegionController::class, 'departements']);

        Route::get('/departements', [DepartementController::class, 'index']);
        Route::get('/departements/{departement:code}', [DepartementController::class, 'show']);
        Route::get('/departements/{departement:code}/communes', [DepartementController::class, 'communes']);

        Route::get('/communes', [CommuneController::class, 'index']);
        Route::get('/communes/{commune:code}', [CommuneController::class, 'show']);
        Route::get('/communes/{commune:code}/arrets', [CommuneController::class, 'arrets']);

        Route::get('/operateurs-transport', [OperateurTransportController::class, 'index']);
        Route::get('/operateurs-transport/{operateurTransport:slug}', [OperateurTransportController::class, 'show']);

        Route::get('/lignes-transport', [LigneTransportController::class, 'index']);
        Route::get('/lignes-transport/{ligneTransport}', [LigneTransportController::class, 'show']);
        Route::get('/lignes-transport/{ligneTransport}/arrets', [LigneTransportController::class, 'arrets']);

        Route::get('/arrets', [ArretController::class, 'index']);
        Route::get('/arrets/{arret}', [ArretController::class, 'show']);
    });
});
