<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use App\Mail\FlightReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendFlightReminderEmails extends Command
{
    protected $signature = 'email:flight-reminder';
    protected $description = 'Send reminder emails to passengers with flights scheduled exactly 25 hours from now';

    public function handle()
    {
        
       $targetTimeStart = Carbon::now()->startOfHour();
$targetTimeEnd = Carbon::now()->endOfHour();

        $this->info("Checking flights between $targetTimeStart and $targetTimeEnd");

        $flights = Flight::with('passengers')
            ->whereBetween('departure_time', [$targetTimeStart, $targetTimeEnd])
            ->get();

        if ($flights->isEmpty()) {
            $this->info('No flights found in this time window.');
            return;
        }

        foreach ($flights as $flight) {
            foreach ($flight->passengers as $passenger) {
                Mail::to($passenger->email)->send(new FlightReminderMail($passenger, $flight));
                $this->info("Reminder sent to {$passenger->email} for flight {$flight->number}");
            }
        }

        $this->info('All reminder emails sent!');
    }
}
