<?php

namespace App\Listeners;

use App\Events\ProfileChangeRequestedEvent;
use App\Facades\SMS;
use App\Mail\ProfileChangesRequestedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ProfileChangeRequestedListener implements ShouldQueue
{
    public $approval;

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
     * @param  \App\Events\ProfileChangeRequestedEvent  $event
     * @return void
     */
    public function handle(ProfileChangeRequestedEvent $event)
    {
        $event->approval->creator->activities()->create(['activity_id' => 7, 'reference' => $event->approval->id]);

        foreach (User::admin()->active()->get() as $admin) {
            Mail::to($admin->email)->send(new ProfileChangesRequestedMail($event->approval));
            SMS::send(($event->approval->creator->client->raw_company_name . " requests a profile change. Please follow the link to review it.\n\n" . config('app.url') . '/admin/approval/' . $event->approval->id), $admin->mobile_no);
        }
    }
}
