<?php

namespace Database\Seeders;

use App\Models\Arret;
use App\Models\Commune;
use App\Models\LigneTransport;
use App\Models\OperateurTransport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Réseau de transport urbain de Dakar : données D'EXEMPLE librement
 * inspirées de la géographie réelle des quartiers desservis par Dakar Dem
 * Dikk et les minibus AFTU ("Tata"), à but de démonstration — ce n'est ni
 * un flux GTFS officiel, ni un horaire réel.
 */
class TransportSeeder extends Seeder
{
    public function run(): void
    {
        $ddd = OperateurTransport::create([
            'nom' => 'Dakar Dem Dikk',
            'slug' => 'dakar-dem-dikk',
            'type' => 'bus_public',
            'description' => 'Société nationale de transport public par bus, dessert Dakar et sa banlieue.',
        ]);

        $aftu = OperateurTransport::create([
            'nom' => 'AFTU',
            'slug' => 'aftu',
            'type' => 'minibus',
            'description' => "Alliance Francophone des Transporteurs Urbains, regroupe les minibus « Tata » et cars rapides privés.",
        ]);

        $arrets = $this->creerArrets();
        $communeParNom = fn (string $nom) => Commune::where('nom', $nom)->firstOrFail();

        $lignes = [
            [
                'operateur' => $ddd,
                'numero' => '7',
                'nom' => 'Médina ↔ Ouakam',
                'origine' => 'Médina',
                'destination' => 'Ouakam',
                'arrets' => ['Petersen', 'Front de Terre', 'Liberté 6', 'Ouakam Cimetière'],
            ],
            [
                'operateur' => $ddd,
                'numero' => '9',
                'nom' => 'Plateau ↔ Parcelles Assainies',
                'origine' => 'Dakar',
                'destination' => 'Parcelles Assainies',
                'arrets' => ['Sandaga', 'Colobane', 'Grand Yoff Marché', 'Parcelles Assainies Unité 15'],
            ],
            [
                'operateur' => $ddd,
                'numero' => '12',
                'nom' => 'Grand Yoff ↔ Ngor',
                'origine' => 'Grand Yoff',
                'destination' => 'Ngor',
                'arrets' => ['Grand Yoff Marché', "Patte d'Oie Aéroport", 'Yoff Arafat', 'Ngor Village'],
            ],
            [
                'operateur' => $aftu,
                'numero' => 'TATA-15',
                'nom' => 'Pikine ↔ Plateau',
                'origine' => 'Pikine',
                'destination' => 'Dakar',
                'arrets' => ['Pikine Centre', 'Liberté 6', 'Colobane', 'Sandaga'],
            ],
            [
                'operateur' => $aftu,
                'numero' => 'TATA-22',
                'nom' => 'Guédiawaye ↔ Médina',
                'origine' => 'Guédiawaye',
                'destination' => 'Médina',
                'arrets' => ['Guédiawaye Sahm', 'Front de Terre', 'Tilène'],
            ],
            [
                'operateur' => $ddd,
                'numero' => '30',
                'nom' => 'Rufisque ↔ Plateau',
                'origine' => 'Rufisque',
                'destination' => 'Dakar',
                'arrets' => ['Rufisque Gare', "Patte d'Oie Aéroport", 'Colobane', 'Sandaga'],
            ],
        ];

        foreach ($lignes as $donneesLigne) {
            $ligne = LigneTransport::create([
                'operateur_id' => $donneesLigne['operateur']->id,
                'numero' => $donneesLigne['numero'],
                'nom' => $donneesLigne['nom'],
                'origine_commune_id' => $communeParNom($donneesLigne['origine'])->id,
                'destination_commune_id' => $communeParNom($donneesLigne['destination'])->id,
            ]);

            foreach (array_values($donneesLigne['arrets']) as $ordre => $nomArret) {
                $ligne->arrets()->attach($arrets[$nomArret]->id, ['ordre' => $ordre + 1]);
            }
        }
    }

    /**
     * @return array<string, Arret>
     */
    private function creerArrets(): array
    {
        $definitions = [
            'Petersen' => ['Médina', 14.6800, -17.4470],
            'Tilène' => ['Médina', 14.6810, -17.4510],
            'Sandaga' => ['Dakar', 14.6735, -17.4370],
            'Colobane' => ['Dakar', 14.6870, -17.4450],
            'Liberté 6' => ['Grand Dakar', 14.7089, -17.4525],
            'Front de Terre' => ['Grand Dakar', 14.7050, -17.4470],
            'Grand Yoff Marché' => ['Grand Yoff', 14.7306, -17.4489],
            "Patte d'Oie Aéroport" => ["Patte d'Oie", 14.7314, -17.4536],
            'Ouakam Cimetière' => ['Ouakam', 14.7167, -17.4886],
            'Ngor Village' => ['Ngor', 14.7447, -17.5136],
            'Yoff Arafat' => ['Yoff', 14.7500, -17.4667],
            'Parcelles Assainies Unité 15' => ['Parcelles Assainies', 14.7597, -17.4364],
            'Pikine Centre' => ['Pikine', 14.7549, -17.3900],
            'Guédiawaye Sahm' => ['Guédiawaye', 14.7692, -17.4036],
            'Rufisque Gare' => ['Rufisque', 14.7167, -17.2667],
        ];

        $arrets = [];

        foreach ($definitions as $nom => [$commune, $latitude, $longitude]) {
            $arrets[$nom] = Arret::create([
                'commune_id' => Commune::where('nom', $commune)->first()?->id,
                'nom' => $nom,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);
        }

        return $arrets;
    }
}
