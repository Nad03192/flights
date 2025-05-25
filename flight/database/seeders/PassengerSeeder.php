<?php
// database/seeders/PassengerSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger;
use Faker\Factory as Faker;

class PassengerSeeder extends Seeder
{ public function run()
    {
        // Generate 10 random passengers
        Passenger::factory()->count(500)->create();
    }
}


