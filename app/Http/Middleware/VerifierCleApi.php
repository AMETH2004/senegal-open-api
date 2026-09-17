<?php

namespace App\Http\Middleware;

use App\Models\CleApi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authentification par clé API (en-tête X-API-Key), sans session ni
 * cookie : toute requête sur les ressources de données doit présenter une
 * clé obtenue via POST /api/v1/cles-api. La clé attachée à la requête
 * (`$request->attributes->get('cle_api')`) sert ensuite de clé de
 * limitation de débit (voir AppServiceProvider, rate limiter "cle-api").
 */
class VerifierCleApi
{
    public function handle(Request $request, Closure $next): Response
    {
        $cle = $request->header('X-API-Key');

        if (! $cle) {
            abort(401, "Clé API manquante. Envoyez-la dans l'en-tête X-API-Key (créez-en une via POST /api/v1/cles-api).");
        }

        $enregistrement = CleApi::trouverParCle($cle);

        if (! $enregistrement || ! $enregistrement->actif) {
            abort(401, 'Clé API invalide ou désactivée.');
        }

        $enregistrement->increment('nombre_requetes');
        $enregistrement->update(['dernier_acces_at' => now()]);

        $request->attributes->set('cle_api', $enregistrement);

        return $next($request);
    }
}
