<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GroupeOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $groupe;
    public $otpCode;

    public function __construct(User $groupe, string $otpCode)
    {
        $this->groupe = $groupe;
        $this->otpCode = $otpCode;
    }

    public function envelope(): Envelope
    {
        $caserneName = $this->groupe->caserneParent?->name ?? 'ONPC';

        return new Envelope(
            subject: "Activation de votre compte Groupe ({$caserneName})",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.groupe_otp',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
