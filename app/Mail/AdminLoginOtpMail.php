<?php

namespace App\Mail;

use App\Models\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminLoginOtpMail extends Mailable
{
    use Queueable;
    use SerializesModels;


    public function __construct(
        public Admin $admin,
        public string $code,
        public string $reference,
    ) {
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject:
                'Hotmobily — Verify Your Login (Ref: '
                . $this->reference
                . ')',
        );
    }


    public function content(): Content
    {
        return new Content(
            view:
                'admin.auth.emails.login-otp'
        );
    }
}