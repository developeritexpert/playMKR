<?php

namespace App\Mail;

use App\Models\SponserApplications;
use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsorApplication;

    public function __construct(SponserApplications $sponsorApplication)
    {
        $this->sponsorApplication = $sponsorApplication;
    }

    public function build()
    {
        return $this->subject('Sponsor Request Rejected')
            ->view('emails.sponsor-rejected')
            ->with([
                'sponsor' => $this->sponsorApplication
            ]);
    }
}