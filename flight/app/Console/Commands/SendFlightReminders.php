<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flight;
use App\Mail\FlightReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendFlightReminders extends Command
{
    protected $signature = 'reminders:flights';
    protected $description = 'Send reminder emails to passengers 24 hours before their flight';

    public function handle()
    {
        $targetTime = Carbon::now()->addDay()->format('Y-m-d H:00:00');

        $flights = Flight::where('departure_time', $targetTime)->with('passengers')->get();

        foreach ($flights as $flight) {
            foreach ($flight->passengers as $passenger) {
                Mail::to($passenger->email)->send(new FlightReminderMail($flight, $passenger));
                $this->info("Email sent to: " . $passenger->email);
            }
        }

        return 0;
    }
}

