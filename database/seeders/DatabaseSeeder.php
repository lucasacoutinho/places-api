<?php

namespace Database\Seeders;

use App\Models\Place;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Place::factory(10)->create();
    }
}
