<?php

namespace Database\Factories;

use App\Models\Candidature;
use App\Models\Personne;
use App\Models\Poste;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour générer des personnes.
 *
 * @extends Factory<Personne>
 */
class PersonneFactory extends Factory
{
    /**
     * Définit les valeurs par défaut du modèle Personne.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }

    /**
     * Configure des traitements après la création d'une personne.
     *
     * @return static
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Personne $personne) {
            if (fake()->boolean()) {
                Candidature::create([
                    'personne_id' => $personne->id,
                    'poste_id' => Poste::inRandomOrder()->value('id'),
                    'statut' => fake()->randomElement([
                        'en_attente',
                        'accepte',
                        'refuse',
                    ]),
                ]);
            }
        });
    }
}
