<?php

namespace Database\Seeders;

use App\Models\CleApi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RegionSeeder::class,
            TransportSeeder::class,
        ]);

        // Clé API de démonstration, prête à l'emploi (voir le README) — en
        // plus de l'auto-inscription via POST /api/v1/cles-api.
        CleApi::create([
            'email' => 'demo@senegal-open-api.test',
            'nom_application' => 'Clé de démonstration',
            'cle_hash' => hash('sha256', 'sen_demo_cle_publique_de_demonstration'),
            'suffixe' => 'ration',
        ]);
    }
}
