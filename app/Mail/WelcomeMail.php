<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
    ) {}

    /**
     * Build the message.
     */
    public function build(): self
    {
        return $this->subject('Dobrodošli na Mali oglasi')
            ->view('emails.welcome');
    }
}
