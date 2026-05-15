<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSponsorRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsorData;

    public function __construct($sponsorData)
    {
        $this->sponsorData = $sponsorData;
    }

    public function build()
    {
        return $this->subject('New Sponsor Request Received')
                    ->view('emails.new_sponsor_request');
    }
}