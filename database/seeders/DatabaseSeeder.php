<?php

namespace Database\Seeders;

use App\Models\Ecole;
use App\Models\Matiere;
use App\Models\Personne;
use App\Models\Poste;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CcsSeeder::class);
        Ecole::factory(40)->create();
        Poste::factory(80)->create();

        $matieres = [
            'Mathématiques', 'Français', 'Anglais', 'Sciences et technologie',
            'Histoire et éducation à la citoyenneté', 'Géographie', 'Éthique et culture religieuse',
            'Éducation physique et à la santé', 'Arts plastiques', 'Musique',
            'Danse', 'Art dramatique', 'Chimie', 'Physique', 'Biologie', 'Informatique',
        ];

        foreach ($matieres as $nom) {
            Matiere::create(['nom' => $nom]);
        }

        for ($i = 0; $i < 30; $i++) {
            Personne::create([
                'nom'   => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
            ]);
        }
    }
}
