<?php

namespace App\Listeners;

use App\Events\DiscussionStartedEvent;
use App\Facades\Company;
use App\Facades\SMS;
use App\Mail\DiscussionStartedByAdminMail;
use App\Mail\DiscussionStartedByClientMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DiscussionStartedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DiscussionStartedEvent  $event
     * @return void
     */
    public function handle(DiscussionStartedEvent $event)
    {
        if ($event->message->user->is_admin) {
            // discussion started by admin
            // log event
            $event->message->ticket->sender->activities()->create(['activity_id' => 15, 'reference' => $event->message->ticket->id]);

            // send email to client
            Mail::to($event->message->ticket->sender->email)->send(new DiscussionStartedByAdminMail($event->message));
            SMS::send((Company::get('code') . " team has started a new Discussion. Please follow the link to view the full message.\n\n" . config('app.url') . '/di/' . $event->message->token), $event->message->ticket->sender->mobile_no);
        } else {

            // discussion started by client
            // log event
            $event->message->ticket->sender->activities()->create(['activity_id' => 13, 'reference' => $event->message->ticket->id]);

            // send email, sms to each admin
            foreach (User::admin()->active()->get() AS $admin) {
                Mail::to($admin->email)->send(new DiscussionStartedByClientMail($event->message));
                SMS::send(($event->message->ticket->sender->client->raw_company_name . " started a new DI. Please follow the link to view the full message.\n\n" . config('app.url') . '/di/' . $event->message->token), $admin->mobile_no);
            }
        }

    }
}
