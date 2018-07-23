<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class EmailConfirmationMailer extends Mailable
{
    use Queueable, SerializesModels;

    public $token;

    /**
     * @param string    $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Please confirm your email address')->markdown('emails.confirmation');
    }
}
