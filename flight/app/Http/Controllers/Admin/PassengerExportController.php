<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PassengersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PassengerExportController extends Controller
{
    public function export()
    {
        return Excel::download(new PassengersExport, 'passengers.xlsx');
    }
}
