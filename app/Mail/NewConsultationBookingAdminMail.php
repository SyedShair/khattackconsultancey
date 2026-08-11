<?php

namespace App\Mail;

use App\Models\ConsultationBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewConsultationBookingAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ConsultationBooking $booking)
    {
    }

    public function build()
    {
        return $this->subject('New Consultation Booking — ' . $this->booking->name)
            ->view('emails.consultation-booking-admin');
    }
}