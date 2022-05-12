<?php

namespace App\Listeners;

use App\Events\PasswordResetByAdminEvent;
use App\Mail\PasswordResetByAdminMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PasswordResetByAdminListener implements ShouldQueue
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
     * @param  \App\Events\PasswordResetByAdminEvent  $event
     * @return void
     */
    public function handle(PasswordResetByAdminEvent $event)
    {
        $event->user->activities()->create(['activity_id' => 12]);
        Mail::to($event->user->email)->send(
            new PasswordResetByAdminMail($event->user)
        );
    }
}
