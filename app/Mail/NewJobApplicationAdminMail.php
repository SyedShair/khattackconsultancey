<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobApplicationAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application)
    {
    }

    public function build()
    {
        $vacancyTitle = $this->application->vacancy->title ?? 'General Application';

        return $this->subject("New Job Application — {$vacancyTitle}")
            ->view('emails.job-application-admin');
    }
}