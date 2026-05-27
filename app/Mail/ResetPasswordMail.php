<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $token;
    public string $email;

    /**
     * Create a new message instance.
     */
    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        Log::info('Sending Reset Password Mail', [
            'email' => $this->email
        ]);

        return $this->subject('Reset Your Password')
            ->view('emails.reset-password')
            ->with([
                'token' => $this->token,
                'email' => $this->email,
                'url' => config('app.frontend_url') . "/reset-password?token={$this->token}&email={$this->email}"
            ]);
    }
}
