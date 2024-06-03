<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $randomNumber = fake()->numberBetween(1, 500);
        // URL dell'immagine con numero casuale
        $profileImageUrl = 'https://source.unsplash.com/random/500x500?sig=' . $randomNumber;

        User::factory()->create([
            'name' => 'Ciuchino',
            'email' => 'ciuchino@example.com',
            'profile_image' => $profileImageUrl,
            'role' => 'customer',
            'genre' => 'male',
            'telephone' => fake()->phoneNumber(),
            'course' => null,
        ]);
        User::factory()->create([
            'name' => 'Shrek',
            'email' => 'shrek@example.com',
            'profile_image' => null,
            'role' => 'admin',
            'genre' => 'famale',
            'telephone' => fake()->phoneNumber(),
            'course' => null,
        ]);

        User::factory(15)->create();

        // per popolare la tabella ponte:

        // metodo 1)

        $users = User::all()->all(); //selezioniamo gli user e li inseriamo in un array
        $course_ids = Course::all()->pluck('id')->all(); // siccome il metodo pluck ritorna una collezione, col metodo all viene trasformata in array normale

        foreach ($users as $user) {
            if ($user->role === 'customer') {
                if ($user->course) {
                    $user->courses()->attach(fake()->randomElement($course_ids), ['status' => 'true']);
                } else {
                    $user->courses()->attach(null, ['status' => 'false']);
                }
            }
        }
    }
}
