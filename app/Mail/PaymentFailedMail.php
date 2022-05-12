<?php

namespace App\Mail;

use App\Facades\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $reason;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $reason)
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Company::get('code') . ' | Payment Failed!')->markdown('emails.payment_failed');
    }
}
