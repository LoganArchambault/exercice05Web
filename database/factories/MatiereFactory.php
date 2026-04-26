<?php

namespace Database\Factories;

use App\Models\Matiere;
use App\Models\Poste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour générer des matières.
 *
 * @extends Factory<Matiere>
 */
class MatiereFactory extends Factory
{
    /**
     * Définit les valeurs par défaut du modèle Matiere.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->word(),
        ];
    }

    /**
     * Configure des traitements après la création d'une matière.
     *
     * @return static
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Matiere $matiere) {
            $matiere->postes()->attach(
                Poste::inRandomOrder()
                    ->take(rand(1, 5))
                    ->pluck('id')
            );
        });
    }
}
