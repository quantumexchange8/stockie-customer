<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $verificationCode;
    public $email;

    /**
     * Create a new message instance.
     *
     * @param string $verificationCode
     */
    public function __construct($verificationCode, $email)
    {
        $this->verificationCode = $verificationCode;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verification_code')
                    ->with([
                        'verificationCode' => $this->verificationCode,
                        'email' => $this->email,
                    ]);
    }
}
