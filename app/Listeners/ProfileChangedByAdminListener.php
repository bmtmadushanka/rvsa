<?php

namespace App\Listeners;

use App\Events\ProfileChangedByAdminEvent;
use App\Mail\ProfileChangedByAdminMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ProfileChangedByAdminListener implements ShouldQueue
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
     * @param  \App\Events\ProfileChangedByAdminEvent  $event
     * @return void
     */
    public function handle(ProfileChangedByAdminEvent $event)
    {
        $event->approval->creator->activities()->create(['activity_id' => 10]);
        Mail::to($event->approval->creator->email)->send(new ProfileChangedByAdminMail($event->approval));
    }
}
