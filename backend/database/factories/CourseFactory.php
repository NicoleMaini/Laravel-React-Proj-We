<?php

namespace Database\Factories;

use App\Models\Slot;
use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $activity_ids = Activity::all()->pluck('id')->all();
        $slot_ids = Slot::all()->pluck('id')->all();

        $locationaRandName = fake()->randomDigit();
        $locationRand = 'Aula ' . $locationaRandName;

        return [
            'location' => $locationRand,
            'year' => fake()->year(),
            'activity_id' => fake()->randomElement($activity_ids),
            'slot_id' => fake()->randomElement($slot_ids),
        ];
    }
}
