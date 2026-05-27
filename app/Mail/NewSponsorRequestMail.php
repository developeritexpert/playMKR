<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class NewSponsorRequestMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sponsorData;

    public function __construct($sponsorData)
    {
        $this->sponsorData = $sponsorData;
    }

    public function build()
    {
        Log::info('Sending New Sponsor Request Mail', [
            'email' => $this->sponsorData->email
        ]);

        return $this->subject('New Sponsor Request Received')
                    ->view('emails.new_sponsor_request');
    }
}