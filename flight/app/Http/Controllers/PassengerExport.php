<?php

namespace App\Http\Controllers;
use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerExport extends Controller
{
     public function export()
{
    $passengers = Passenger::all();

    $filename = "passengers_export_" . date('Y-m-d_H-i-s') . ".csv";

    $headers = [
        "Content-Type" => "text/csv",
        "Content-Disposition" => "attachment; filename=\"$filename\"",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    ];

    $columns = ['ID', 'First Name', 'Last Name', 'Email', 'Date of Birth', 'Passport Expiry Date'];

    $callback = function() use ($passengers, $columns) {
        $file = fopen('php://output', 'w');
        fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); 
        fputcsv($file, $columns);

        foreach ($passengers as $p) {
            fputcsv($file, [
                $p->id,
                $p->first_name,
                $p->last_name,
                $p->email,
                $p->dob,
                $p->passport_expiry_date
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}
