<?php

namespace App\Mail;

use App\Facades\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProfileChangesRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $approval;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approval)
    {
        $this->approval = $approval;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Company::get('code') . ' | ' . $this->approval->creator->client->raw_company_name . ' request a profile change')->markdown('emails.profile_change_requested');
    }
}
