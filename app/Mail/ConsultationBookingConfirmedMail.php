<?php

namespace App\Mail;

use App\Models\ConsultationBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConsultationBookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ConsultationBooking $booking)
    {
    }

    public function build()
    {
        return $this->subject('Your Consultation is Confirmed')
            ->view('emails.consultation-booking-client');
    }
}