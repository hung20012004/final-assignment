<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pass;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$pass)
    {
        $this->user = $user;
        $this->pass = $pass;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Verify Your Email Address')
                    ->view('emails.user-verification')
                    ->with([
                        'user' => $this->user,
                        'pass' => $this->pass,
                    ]);
    }
}
