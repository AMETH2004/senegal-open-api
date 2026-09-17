<?php

namespace Database\Seeders;

use App\Models\Commune;
use App\Models\Departement;
use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Découpage administratif réel du Sénégal (14 régions, 46 départements).
 * Les superficies régionales sont des valeurs de référence usuelles ; les
 * populations (région/département/commune) sont des ESTIMATIONS
 * indicatives à but de démonstration, pas des chiffres officiels ANSD au
 * dernier recensement — voir le README.
 */
class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            ['code' => 'DK', 'nom' => 'Dakar', 'superficie_km2' => 547, 'population' => 4029700, 'departements' => [
                ['nom' => 'Dakar', 'population' => 1200000],
                ['nom' => 'Guédiawaye', 'population' => 400000],
                ['nom' => 'Pikine', 'population' => 1300000],
                ['nom' => 'Rufisque', 'population' => 550000],
                ['nom' => 'Keur Massar', 'population' => 579700],
            ]],
            ['code' => 'TH', 'nom' => 'Thiès', 'superficie_km2' => 6601, 'population' => 2158000, 'departements' => [
                ['nom' => 'Thiès', 'population' => 900000],
                ['nom' => 'Mbour', 'population' => 850000],
                ['nom' => 'Tivaouane', 'population' => 408000],
            ]],
            ['code' => 'DB', 'nom' => 'Diourbel', 'superficie_km2' => 4769, 'population' => 1968000, 'departements' => [
                ['nom' => 'Diourbel', 'population' => 450000],
                ['nom' => 'Bambey', 'population' => 400000],
                ['nom' => 'Mbacké', 'population' => 1118000],
            ]],
            ['code' => 'FK', 'nom' => 'Fatick', 'superficie_km2' => 7935, 'population' => 875000, 'departements' => [
                ['nom' => 'Fatick', 'population' => 350000],
                ['nom' => 'Foundiougne', 'population' => 300000],
                ['nom' => 'Gossas', 'population' => 225000],
            ]],
            ['code' => 'KL', 'nom' => 'Kaolack', 'superficie_km2' => 5357, 'population' => 1148000, 'departements' => [
                ['nom' => 'Kaolack', 'population' => 650000],
                ['nom' => 'Guinguinéo', 'population' => 200000],
                ['nom' => 'Nioro du Rip', 'population' => 298000],
            ]],
            ['code' => 'KA', 'nom' => 'Kaffrine', 'superficie_km2' => 11262, 'population' => 720000, 'departements' => [
                ['nom' => 'Kaffrine', 'population' => 250000],
                ['nom' => 'Birkelane', 'population' => 150000],
                ['nom' => 'Koungheul', 'population' => 180000],
                ['nom' => 'Malem Hodar', 'population' => 140000],
            ]],
            ['code' => 'KD', 'nom' => 'Kolda', 'superficie_km2' => 13721, 'population' => 860000, 'departements' => [
                ['nom' => 'Kolda', 'population' => 400000],
                ['nom' => 'Vélingara', 'population' => 320000],
                ['nom' => 'Médina Yoro Foulah', 'population' => 140000],
            ]],
            ['code' => 'KE', 'nom' => 'Kédougou', 'superficie_km2' => 16896, 'population' => 185000, 'departements' => [
                ['nom' => 'Kédougou', 'population' => 90000],
                ['nom' => 'Salémata', 'population' => 45000],
                ['nom' => 'Saraya', 'population' => 50000],
            ]],
            ['code' => 'LG', 'nom' => 'Louga', 'superficie_km2' => 24847, 'population' => 1060000, 'departements' => [
                ['nom' => 'Louga', 'population' => 450000],
                ['nom' => 'Kébémer', 'population' => 350000],
                ['nom' => 'Linguère', 'population' => 260000],
            ]],
            ['code' => 'MT', 'nom' => 'Matam', 'superficie_km2' => 29445, 'population' => 715000, 'departements' => [
                ['nom' => 'Matam', 'population' => 320000],
                ['nom' => 'Kanel', 'population' => 250000],
                ['nom' => 'Ranérou Ferlo', 'population' => 145000],
            ]],
            ['code' => 'SL', 'nom' => 'Saint-Louis', 'superficie_km2' => 19241, 'population' => 1120000, 'departements' => [
                ['nom' => 'Saint-Louis', 'population' => 450000],
                ['nom' => 'Dagana', 'population' => 400000],
                ['nom' => 'Podor', 'population' => 270000],
            ]],
            ['code' => 'SE', 'nom' => 'Sédhiou', 'superficie_km2' => 7341, 'population' => 565000, 'departements' => [
                ['nom' => 'Sédhiou', 'population' => 230000],
                ['nom' => 'Bounkiling', 'population' => 180000],
                ['nom' => 'Goudomp', 'population' => 155000],
            ]],
            ['code' => 'TC', 'nom' => 'Tambacounda', 'superficie_km2' => 42364, 'population' => 915000, 'departements' => [
                ['nom' => 'Tambacounda', 'population' => 400000],
                ['nom' => 'Bakel', 'population' => 220000],
                ['nom' => 'Goudiry', 'population' => 150000],
                ['nom' => 'Koumpentoum', 'population' => 145000],
            ]],
            ['code' => 'ZG', 'nom' => 'Ziguinchor', 'superficie_km2' => 7339, 'population' => 630000, 'departements' => [
                ['nom' => 'Ziguinchor', 'population' => 320000],
                ['nom' => 'Bignona', 'population' => 250000],
                ['nom' => 'Oussouye', 'population' => 60000],
            ]],
        ];

        foreach ($regions as $donneesRegion) {
            $region = Region::create([
                'code' => $donneesRegion['code'],
                'nom' => $donneesRegion['nom'],
                'chef_lieu' => $donneesRegion['nom'],
                'superficie_km2' => $donneesRegion['superficie_km2'],
                'population' => $donneesRegion['population'],
            ]);

            foreach ($donneesRegion['departements'] as $donneesDepartement) {
                $departement = Departement::create([
                    'region_id' => $region->id,
                    'code' => Str::slug($donneesDepartement['nom']),
                    'nom' => $donneesDepartement['nom'],
                    'chef_lieu' => $donneesDepartement['nom'],
                    'population' => $donneesDepartement['population'],
                ]);

                // Commune chef-lieu, présente pour chaque département.
                // Coordonnées ajoutées ensuite pour les chefs-lieux de Dakar
                // (voir seedCommunesDakar) qui servent d'ancrage au réseau
                // de transport ; laissées nulles ailleurs pour ce seed.
                Commune::create([
                    'departement_id' => $departement->id,
                    'code' => Str::slug($departement->nom).'-centre',
                    'nom' => $departement->nom,
                    'type' => 'commune',
                    'population' => $donneesDepartement['population'],
                ]);
            }
        }

        $this->seedCommunesDakar();
    }

    /**
     * Positionne les chefs-lieux de la région de Dakar (utilisés comme
     * points d'ancrage par TransportSeeder) puis ajoute quelques communes
     * d'arrondissement du département de Dakar, avec coordonnées, pour
     * donner une vraie densité géographique aux lignes de transport.
     */
    private function seedCommunesDakar(): void
    {
        $coordonneesChefLieux = [
            'Dakar' => [14.6708, -17.4313],
            'Guédiawaye' => [14.7692, -17.4036],
            'Pikine' => [14.7549, -17.3900],
            'Rufisque' => [14.7167, -17.2667],
            'Keur Massar' => [14.7833, -17.3833],
        ];

        foreach ($coordonneesChefLieux as $nom => [$latitude, $longitude]) {
            Commune::where('nom', $nom)->update(['latitude' => $latitude, 'longitude' => $longitude]);
        }

        $departementDakar = Departement::where('nom', 'Dakar')->firstOrFail();

        $communesArrondissement = [
            ['nom' => 'Médina', 'latitude' => 14.6789, 'longitude' => -17.4499, 'population' => 130000],
            ['nom' => 'Fann-Point E-Amitié', 'latitude' => 14.6928, 'longitude' => -17.4645, 'population' => 95000],
            ['nom' => 'Grand Dakar', 'latitude' => 14.7089, 'longitude' => -17.4525, 'population' => 110000],
            ['nom' => 'Grand Yoff', 'latitude' => 14.7306, 'longitude' => -17.4489, 'population' => 180000],
            ['nom' => 'Ouakam', 'latitude' => 14.7167, 'longitude' => -17.4886, 'population' => 60000],
            ['nom' => 'Ngor', 'latitude' => 14.7447, 'longitude' => -17.5136, 'population' => 25000],
            ['nom' => 'Yoff', 'latitude' => 14.7500, 'longitude' => -17.4667, 'population' => 140000],
            ['nom' => 'Parcelles Assainies', 'latitude' => 14.7597, 'longitude' => -17.4364, 'population' => 350000],
            ['nom' => "Patte d'Oie", 'latitude' => 14.7314, 'longitude' => -17.4536, 'population' => 45000],
        ];

        foreach ($communesArrondissement as $commune) {
            Commune::create([
                'departement_id' => $departementDakar->id,
                'code' => Str::slug($commune['nom']),
                'nom' => $commune['nom'],
                'type' => 'commune_arrondissement',
                'population' => $commune['population'],
                'latitude' => $commune['latitude'],
                'longitude' => $commune['longitude'],
            ]);
        }
    }
}
