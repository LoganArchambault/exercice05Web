<?php

namespace Database\Factories;

use App\Models\Ecole;
use Illuminate\Database\Eloquent\Factories\Factory;

class PosteFactory extends Factory
{
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
            'ecole_id'    => Ecole::inRandomOrder()->first()->id,
            'nom'         => $this->faker->randomElement($titres),
            'description' => $this->faker->paragraph(3),
            'charge'      => $this->faker->randomFloat(2, 20, 100),
        ];
    }
}
