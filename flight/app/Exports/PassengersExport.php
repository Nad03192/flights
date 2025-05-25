<?php

namespace App\Exports;

use App\Models\Passenger;
use Maatwebsite\Excel\Concerns\FromArray;

class PassengersExport implements FromArray
{
    public function array(): array
    {
        $passengers = Passenger::all();

        $data = [
            ['First Name', 'Last Name', 'Email', 'Image URL'],
        ];

        foreach ($passengers as $passenger) {
            $data[] = [
                $passenger->first_name ?? '',
                $passenger->last_name ?? '',
                $passenger->email ?? '',
                $passenger->image_url ?? '',
            ];
        }

        return $data;
    }
}
