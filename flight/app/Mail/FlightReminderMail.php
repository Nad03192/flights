<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use App\Models\Flight;
use App\Models\Passenger;

class FlightReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $flight;
    public $passenger;

    public function __construct(Flight $flight, Passenger $passenger)
    {
        $this->flight = $flight;
        $this->passenger = $passenger;
    }

    public function build()
    {
        return $this->subject('Reminder: Your flight is in 24 hours')
            ->view('emails.flight_reminder');
    }
}
