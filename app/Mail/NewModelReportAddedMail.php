<?php

namespace App\Mail;

use App\Facades\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewModelReportAddedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $report)
    {
        $this->user = $user;
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Company::get('code') . ' | New model report of '. $this->report->make . ' ' . $this->report->model . ' ' . $this->report->model_code .' has been released')->markdown('emails.new_model_report_added');
    }
}
