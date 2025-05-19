<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Passenger;
use App\Models\Flight;

class FlightReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $passenger;
    public $flight;

    public function __construct(Passenger $passenger, Flight $flight)
    {
        $this->passenger = $passenger;
        $this->flight = $flight;
    }

    public function build()
    {
        return $this->subject('Upcoming Flight Reminder')
                    ->view('emails.flight_reminder');
    }
}
