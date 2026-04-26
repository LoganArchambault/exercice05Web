<?php

namespace Database\Seeders;

use App\Models\Cc;
use Illuminate\Database\Seeder;

/**
 * Seeder des centres de services scolaires.
 */
class CcsSeeder extends Seeder
{
    /**
     * Exécute l'insertion des centres de services scolaires de référence.
     */
    public function run(): void
    {
        $centres = [
            ['nom' => 'Centre de services scolaire des Grandes-Seigneuries'],
            ['nom' => 'Centre de services scolaire de Saint-Hyacinthe'],
            ['nom' => 'Centre de services scolaire de Sorel-Tracy'],
            ['nom' => 'Centre de services scolaire de la Vallée-des-Tisserands'],
            ['nom' => 'Centre de services scolaire des Hautes-Rivières'],
            ['nom' => 'Centre de services scolaire de la Rivière-du-Nord'],
            ['nom' => 'Centre de services scolaire des Patriotes'],
            ['nom' => 'Centre de services scolaire du Val-des-Cerfs'],
        ];

        foreach ($centres as $centre) {
            Cc::create($centre);
        }
    }
}
