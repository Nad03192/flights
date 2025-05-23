<?php
namespace App\Exports;

use App\Models\Passenger;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PassengersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Passenger::select(
            'id', 'first_name', 'last_name', 'email', 'dob', 'passport_expiry_date', 'image', 'created_at'
        )->get();
    }

    public function headings(): array
    {
        return ['ID', 'First Name', 'Last Name', 'Email', 'Date of Birth', 'Passport Expiry Date', 'Image', 'Created At'];
    }
}
