<?php

namespace App\Imports;

use App\Models\Passenger;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PassengersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
     
        $passenger = Passenger::where('email', $row['email'])->first();

        if ($passenger) {
          
            $passenger->update([
                'first_name' => $row['first_name'] ?? $passenger->first_name,
                'last_name' => $row['last_name'] ?? $passenger->last_name,
                'dob' => $row['dob'] ?? $passenger->dob,
                'passport_expiry_date' => $row['passport_expiry_date'] ?? $passenger->passport_expiry_date,
                'image' => $row['image'] ?? $passenger->image,
                'thumbnail' => $row['thumbnail'] ?? $passenger->thumbnail,
            ]);
        } else {
        
            return new Passenger([
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'dob' => $row['dob'],
                'passport_expiry_date' => $row['passport_expiry_date'],
                'image' => $row['image'] ?? null,
                'thumbnail' => $row['thumbnail'] ?? null,
                'password' => bcrypt('defaultpassword'), 
            ]);
        }
    }
}

