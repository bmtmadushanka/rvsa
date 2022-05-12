<?php

namespace App\Listeners;

use App\Events\VersionChangedEvent;
use App\Mail\VersionChangedMail;
use App\Models\NotificationVersionChanges;
use App\Models\OrderReport;
use App\Models\User;
use App\Models\VersionChange;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class VersionChangedListener implements ShouldQueue
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
     * @param  VersionChangedEvent  $event
     * @return void
     */
    public function handle(VersionChangedEvent $event)
    {
        $users = User::active()->notAdmin()->get();

        // create a notification to all the new users
        NotificationVersionChanges::insert(
            array_map(function($user) use ($event) {
                return [
                    'user_id' => $user['id'],
                    'child_copy_id' => $event->childCopy->id
                ];
            }, $users->toArray())
        );

        foreach ($users AS $user)
        {
            Mail::to($user->email)->send(new VersionChangedMail($user, $event->childCopy));
        }
    }
}
