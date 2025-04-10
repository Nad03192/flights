<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;
use App\Models\Passenger;

class FlightPassengerSeeder extends Seeder
{
    public function run(): void
    {
        $flights = Flight::all();
        $passengers = Passenger::all();

        foreach ($flights as $flight) {
            // Attach 3 to 7 random passengers to each flight
            $flight->passengers()->attach(
                $passengers->random(rand(3, 7))->pluck('id')->toArray()
            );
        }
    }
}
