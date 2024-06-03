<?php

namespace Database\Seeders;

use App\Models\Slot;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Slot::factory(16)->create();
    }
}
