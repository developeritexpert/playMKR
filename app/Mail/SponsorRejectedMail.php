<?php

namespace App\Mail;

use App\Models\SponserApplications;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SponsorRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sponsor;

    public function __construct(SponserApplications $sponsor)
    {
        $this->sponsor = $sponsor;
    }

    public function build()
    {
        return $this->subject('Sponsor Request Rejected')
            ->view('emails.sponsor-rejected')
            ->with([
                'sponsor' => $this->sponsor
            ]);
    }
}