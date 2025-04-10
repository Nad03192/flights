<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use Faker\Factory as Faker;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $i) {
            $departureTime = $faker->dateTimeBetween('+1 days', '+1 month');
            $arrivalTime = (clone $departureTime)->modify('+' . rand(1, 10) . ' hours');

            Flight::create([
                'number' => 'FL' . $faker->unique()->numberBetween(1000, 9999),
                'departure_city' => $faker->city,
                'arrival_city' => $faker->city,
                'departure_time' => $departureTime,
                'arrival_time' => $arrivalTime,
            ]);
        }
    }
}
