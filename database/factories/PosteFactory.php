<?php

namespace Database\Factories;

use App\Models\Ecole;
use App\Models\Poste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour générer des postes.
 *
 * @extends Factory<Poste>
 */
class PosteFactory extends Factory
{
    /**
     * Définit les valeurs par défaut du modèle Poste.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titres = [
            'Enseignant(e) en mathématiques',
            'Enseignant(e) en français',
            'Enseignant(e) en sciences',
            'Enseignant(e) en histoire',
            'Enseignant(e) en éducation physique',
            'Enseignant(e) en arts plastiques',
            'Enseignant(e) en musique',
            'Enseignant(e) en géographie',
            'Enseignant(e) en anglais langue seconde',
            'Enseignant(e) en informatique',
            'Enseignant(e) en chimie',
            'Enseignant(e) en biologie',
            'Enseignant(e) en philosophie',
            'Enseignant(e) en éthique et culture religieuse',
        ];

        return [
            'ecole_id' => Ecole::inRandomOrder()->first()->id,
            'nom' => $this->faker->randomElement($titres),
            'description' => $this->faker->paragraph(),
            'charge' => $this->faker->randomFloat(0, 0, 100),
        ];
    }
}
