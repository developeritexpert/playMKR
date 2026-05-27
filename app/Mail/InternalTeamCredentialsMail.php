<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class InternalTeamCredentialsMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        Log::info('Sending Internal Team Credentials Mail', [
            'user' => $this->user
        ]);

        return $this->subject('Internal Team Login Credentials')
            ->view('emails.internal-team-credentials');
    }
}
