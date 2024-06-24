<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ImportAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    private $email;
    private $password;
    private $subject;

    public function __construct($email, $password, $subject = 'Import Account Mail')
    {
        $this->email = $email;
        $this->password = $password;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subject
        );
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject($this->subject)
            ->markdown('emails.import-account', [
                'email' => $this->email,
                'password' => $this->password,
            ]);
    }
}
