<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Controller
{
    /**
     * Applique un tri `?sort=champ,-autre_champ` à la requête, en ne
     * retenant que les colonnes explicitement autorisées par la ressource
     * (évite d'exposer un tri sur une colonne arbitraire de la table).
     */
    protected function appliquerTri(Builder $requete, Request $request, array $colonnesAutorisees, string $triParDefaut): Builder
    {
        $champs = array_filter(explode(',', (string) $request->query('sort', $triParDefaut)));

        foreach ($champs as $champ) {
            $direction = str_starts_with($champ, '-') ? 'desc' : 'asc';
            $colonne = ltrim($champ, '-');

            if (in_array($colonne, $colonnesAutorisees, true)) {
                $requete->orderBy($colonne, $direction);
            }
        }

        return $requete;
    }
}
