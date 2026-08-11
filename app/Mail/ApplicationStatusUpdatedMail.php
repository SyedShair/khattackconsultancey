<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application)
    {
    }

    public function build()
    {
        $vacancyTitle = $this->application->vacancy->title ?? 'your application';

        $subjects = [
            'reviewed'    => "Update on your application for {$vacancyTitle}",
            'shortlisted' => "You've been shortlisted for {$vacancyTitle}!",
            'rejected'    => "Update on your application for {$vacancyTitle}",
            'hired'       => "Congratulations — Job Offer for {$vacancyTitle}",
            'pending'     => "Update on your application for {$vacancyTitle}",
        ];

        return $this->subject($subjects[$this->application->status] ?? "Update on your application")
            ->view('emails.application-status-updated');
    }
}