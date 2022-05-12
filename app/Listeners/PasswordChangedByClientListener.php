<?php

namespace App\Listeners;

use App\Events\PasswordChangedByClientEvent;
use App\Mail\PasswordChangedByCustomerMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PasswordChangedByClientListener implements ShouldQueue
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
     * @param PasswordChangedByClientEvent $event
     * @return void
     */
    public function handle(PasswordChangedByClientEvent $event)
    {
        $event->user->activities()->create(['activity_id' => 11]);

        Mail::to($event->user->email)->send(
            new PasswordChangedByCustomerMail($event->user)
        );
    }
}
