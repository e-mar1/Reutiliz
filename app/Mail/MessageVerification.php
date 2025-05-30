<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationUrl;
    public $messageDetails;

    public function __construct($verificationUrl, $messageDetails)
    {
        $this->verificationUrl = $verificationUrl;
        $this->messageDetails = $messageDetails;
    }

    public function build()
    {
        return $this->subject('Vérification de votre message')
                    ->view('emails.message-verification');
    }
} 