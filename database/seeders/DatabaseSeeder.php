<?php

namespace Database\Seeders;

use App\Models\Ecole;
use App\Models\Matiere;
use App\Models\Personne;
use App\Models\Poste;
use Illuminate\Database\Seeder;

/**
 * Seeder principal de l'application.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Exécute le peuplement initial des données applicatives.
     */
    public function run(): void
    {
        $this->call(CcsSeeder::class);

        Ecole::factory(40)->create();
        Poste::factory(80)->create();

        Matiere::factory()
            ->count(16)
            ->sequence(
                ['nom' => 'Mathématiques'],
                ['nom' => 'Français'],
                ['nom' => 'Anglais'],
                ['nom' => 'Sciences et technologie'],
                ['nom' => 'Histoire et éducation à la citoyenneté'],
                ['nom' => 'Géographie'],
                ['nom' => 'Éthique et culture religieuse'],
                ['nom' => 'Éducation physique et à la santé'],
                ['nom' => 'Arts plastiques'],
                ['nom' => 'Musique'],
                ['nom' => 'Danse'],
                ['nom' => 'Art dramatique'],
                ['nom' => 'Chimie'],
                ['nom' => 'Physique'],
                ['nom' => 'Biologie'],
                ['nom' => 'Informatique'],
            )
            ->create();

        Personne::factory(30)->create();
    }
}
