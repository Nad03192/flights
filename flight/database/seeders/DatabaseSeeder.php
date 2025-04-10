<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Passenger; // ✅ Add this line

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(FlightPassengerSeeder::class);
    }
}
