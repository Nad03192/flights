<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Create 'admin' role if it doesn't exist
        $role = Role::firstOrCreate(['name' => 'admin']);
        
        // Find the user with ID 1
        $user = User::find(3);

        // Check if the user exists
        if ($user) {
            // Assign the 'admin' role to the user with ID 1
            $user->assignRole($role);
        }
    }
}
