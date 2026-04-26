<?php

namespace Database\Factories;

use App\Models\Cc;
use App\Models\Ecole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory pour générer des écoles.
 *
 * @extends Factory<Ecole>
 */
class EcoleFactory extends Factory
{
    /**
     * Définit les valeurs par défaut du modèle Ecole.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $prefixes = ['École primaire', 'École secondaire', 'École polyvalente', 'École internationale'];
        $noms = [
            'des Érables', 'du Soleil', 'de la Montagne', 'des Patriotes', 'du Lac',
            'des Pins', 'de la Rivière', 'Saint-Jean', 'Saint-Paul', 'Sainte-Marie',
            'des Berges', 'de la Plaine', 'du Ruisseau', 'des Cèdres', 'du Boisé',
        ];

        return [
            'nom' => $this->faker->randomElement($prefixes) . ' ' . $this->faker->randomElement($noms),
            'css_id' => Cc::inRandomOrder()->first()->id,
        ];
    }
}
