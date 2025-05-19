<?php

namespace App\Exports;

use App\Models\Flight;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FlightsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Flight::with('passengers')->get()->map(function ($flight) {
            return [
                'number' => $flight->number,
                'departure_city' => $flight->departure_city,
                'arrival_city' => $flight->arrival_city,
                'departure_time' => $flight->departure_time,
                'arrival_time' => $flight->arrival_time,
                'available_seats' => $flight->available_seats,
                'passengers_count' => $flight->passengers->count(),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Flight Number',
            'Departure City',
            'Arrival City',
            'Departure Time',
            'Arrival Time',
            'Available Seats',
            'Passengers Count',
        ];
    }
}
