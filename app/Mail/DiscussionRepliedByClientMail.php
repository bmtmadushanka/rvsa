<?php

namespace App\Mail;

use App\Facades\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DiscussionRepliedByClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(Company::get('code') . ' | ' . $this->message->ticket->sender->client->raw_company_name . ' replied to a discussion')->markdown('emails.discussion_replied_by_client');
    }
}
