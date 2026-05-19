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

    public $sponsor;
    public $password;

    public function __construct(Sponsor $sponsor, $password)
    {
        $this->sponsor = $sponsor;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Sponsor Request Approved')
            ->view('emails.sponsor-approved')
            ->with([
                'sponsor' => $this->sponsor,
                'password' => $this->password
            ]);
    }
}
