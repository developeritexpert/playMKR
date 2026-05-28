<?php

namespace App\Mail;

use App\Models\SponsorApplications;
use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SponsorRejectedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sponsorApplication;

    public function __construct(SponsorApplications $sponsorApplication)
    {
        $this->sponsorApplication = $sponsorApplication;
    }

    public function build()
    {
        Log::info('Sending Sponsor Rejected Mail', [
            'email' => $this->sponsorApplication->email
        ]);

        return $this->subject('Sponsor Request Rejected')
            ->view('emails.sponsor-rejected')
            ->with([
                'sponsor' => $this->sponsorApplication
            ]);
    }
}
