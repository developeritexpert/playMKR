<?php

namespace App\Mail;

use App\Models\Sponsor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SponsorApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // app/Mail/SponsorApprovedMail.php

    public $sponsor;
    public $password;

    public function __construct($sponsor, $password)
    {
        $this->sponsor = $sponsor;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your PlayMKR Sponsor Account Credentials')
            ->view('emails.sponsor-approved')
            ->with([
                'sponsor' => $this->sponsor,
                'password' => $this->password
            ]);
    }
}
