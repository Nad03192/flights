<?php

namespace App\Http\Controllers;
use App\Models\Flight;

use Illuminate\Http\Request;

class FilghtExport extends Controller
{
    public function export()
{
    $flights = Flight::all();

    $filename = "flights_export_" . date('Y-m-d_H-i-s') . ".csv";

    $headers = [
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$filename",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['Number', 'Departure City', 'Arrival City', 'Departure Time', 'Arrival Time', 'Available Seats'];

    $callback = function() use ($flights, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($flights as $flight) {
            fputcsv($file, [
                $flight->number,
                $flight->departure_city,
                $flight->arrival_city,
                $flight->departure_time,
                $flight->arrival_time,
                $flight->available_seats
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
