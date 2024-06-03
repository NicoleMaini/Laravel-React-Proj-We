<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generazione di un numero casuale per l'immagine
        // $randomNumber = $this->faker->numberBetween(1, 500);
        $randomNumber = fake()->numberBetween(1, 500);
        // URL dell'immagine con numero casuale
        $imageUrl = 'https://source.unsplash.com/random/500x500?sig=' . $randomNumber;

        return [
            'image' => $imageUrl,
            'name' => fake()->sentence(3),
            'description' => fake()->paragraph(),
        ];
    }
}
