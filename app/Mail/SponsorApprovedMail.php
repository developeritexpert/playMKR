<?php

namespace App\Mail;

use App\Models\SponserApplications;
use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SponsorApprovedMail extends Mailable implements ShouldQueue
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
        Log::info('Sending Sponsor Approved Email', [
            'email' => $this->sponsorApplication->email
        ]);

        return $this->subject('Sponsor Request Approved')
            ->view('emails.sponsor-approved')
            ->with([
                'sponsor' => $this->sponsorApplication,
                'password' => $this->password
            ]);
    }
}
