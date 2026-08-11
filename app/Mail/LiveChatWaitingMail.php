<?php

namespace App\Mail;

use App\Models\ChatSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LiveChatWaitingMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ChatSession $session)
    {
    }

    public function build()
    {
        return $this->subject('A visitor is waiting in live chat — ' . ($this->session->name ?: 'Anonymous'))
            ->view('emails.live-chat-waiting');
    }
}