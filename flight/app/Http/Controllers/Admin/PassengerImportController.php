<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\PassengersImport;
use Maatwebsite\Excel\Facades\Excel;

class PassengerImportController extends Controller
{
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,csv',
    ]);

    Excel::import(new PassengersImport, $request->file('file'));

    return response()->json([
        'success' => true,
        'message' => 'Passenger data imported successfully.',
    ]);
}
}
