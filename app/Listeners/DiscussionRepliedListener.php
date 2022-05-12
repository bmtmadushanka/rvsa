<?php

namespace App\Listeners;

use App\Events\DiscussionRepliedEvent;
use App\Facades\Company;
use App\Facades\SMS;
use App\Mail\DiscussionRepliedByAdminMail;
use App\Mail\DiscussionRepliedByClientMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DiscussionRepliedListener implements ShouldQueue
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
     * @param  \App\Events\DiscussionRepliedEvent  $event
     * @return void
     */
    public function handle(DiscussionRepliedEvent $event)
    {
        if ($event->message->user->is_admin) {

            // discussion replied by admin
            // log event
            $event->message->ticket->sender->activities()->create(['activity_id' => 16, 'reference' => $event->message->ticket->id]);

            // send email to client
            Mail::to($event->message->ticket->sender->email)->send(new DiscussionRepliedByAdminMail($event->message));
            SMS::send((Company::get('code') . " team has replied to the discussion. Please follow the link to view the full message.\n\n" . config('app.url') . '/di/' . $event->message->token), $event->message->ticket->sender->mobile_no);

        } else {

            // discussion replied by client
            $event->message->ticket->sender->activities()->create(['activity_id' => 14, 'reference' => $event->message->ticket->id]);
            $sms = $event->message->ticket->sender->client->raw_company_name . " replied to DI. Please follow the link to view the full message.\n\n" . config('app.url') . '/di/' . $event->message->token;

            if ($event->message->ticket->assignee) {
                $assignee = User::find($event->message->ticket->assignee);
                Mail::to($assignee->email)->send(new DiscussionRepliedByClientMail($event->message));
                SMS::send($sms, $assignee->mobile_no);
            } else {
                foreach (User::admin()->active()->get() as $admin) {
                    Mail::to($admin->email)->send(new DiscussionRepliedByClientMail($event->message));
                    SMS::send($sms, $admin->mobile_no);
                }
            }
        }
    }
}
