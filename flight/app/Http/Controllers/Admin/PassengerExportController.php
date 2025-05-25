<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PassengersExport;

class PassengerExportController extends Controller
{
    public function export()
    {
        try {
            return Excel::download(new PassengersExport, 'passengers.xlsx');
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 500);
        }
    }
}
