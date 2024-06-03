<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $course_ids = Course::all()->pluck('id')->all();
        // significa che all'array preso precedentemente aggiungiamo un nuovo valore
        $course_id = fake()->randomElement($course_ids);
        $course_ids[] = null;

        $randomNumber = fake()->numberBetween(1, 500);
        $profileImageUrl = 'https://source.unsplash.com/random/500x500?sig=' . $randomNumber;

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => (static::$password ??= Hash::make('password')),
            'remember_token' => Str::random(10),
            'profile_image' => $profileImageUrl,
            'role' => $course_id ? 'customer' : 'admin',
            'genre' => fake()->randomElement(['famale', 'male']),
            'telephone' => fake()->phoneNumber(),
            'course' => $course_id,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(
            fn(array $attributes) => [
                'email_verified_at' => null,
            ],
        );
    }
}
