<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PassengerSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PassengerSeeder::class, // Call the PassengerSeeder
        ]);
         $this->call(RoleSeeder::class);
    }
}
