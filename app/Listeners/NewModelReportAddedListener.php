<?php

namespace App\Listeners;

use App\Events\NewModelReportAddedEvent;
use App\Mail\NewModelReportAddedMail;
use App\Models\NotificationVersionChanges;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewModelReportAddedListener implements ShouldQueue
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
     * @param  \App\Events\NewModelReportAddedEvent  $event
     * @return void
     */
    public function handle(NewModelReportAddedEvent $event)
    {
        $users = User::active()->notAdmin()->get();

        // create a notification to all the new users
        NotificationVersionChanges::insert(
            array_map(function($user) use ($event) {
                return [
                    'is_new' => true,
                    'user_id' => $user['id'],
                    'child_copy_id' => $event->childCopy->id
                ];
            }, $users->toArray())
        );

        foreach ($users AS $user)
        {
            Mail::to($user->email)->send(new NewModelReportAddedMail($user, $event->childCopy));
        }
    }
}
