<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CcsSeeder extends Seeder
{
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

        DB::table('ccs')->insert($centres);
    }
}
