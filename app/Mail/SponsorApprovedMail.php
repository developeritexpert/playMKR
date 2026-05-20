<?php

namespace App\Mail;

use App\Models\SponserApplications;
use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsorApplication;
    public $password;

    public function __construct(SponserApplications $sponsorApplication, $password)
    {
        $this->sponsorApplication = $sponsorApplication;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Sponsor Request Approved')
            ->view('emails.sponsor-approved')
            ->with([
                'sponsor' => $this->sponsorApplication,
                'password' => $this->password
            ]);
    }
}
