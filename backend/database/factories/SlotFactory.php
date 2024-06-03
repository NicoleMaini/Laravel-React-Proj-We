<?php

namespace Database\Factories;

use App\Models\Slot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slot>
 */
class SlotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'day' => fake()->dayOfWeek(),
            'start_hour' => fake()->time('H:i'),
            'end_hour' => fake()->time('H:i'),
        ];
    }
}
