<?php

namespace App\Listeners;

use App\Events\LoginSucceededEvent;
use App\Facades\Company;
use App\Facades\SMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginSucceededListener
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
     * @param  LoginSucceededEvent $event
     * @return void
     */
    public function handle(LoginSucceededEvent $event)
    {

        $event->user->activities()->create(['activity_id' => 2, 'remark' => $event->ip ]);

        $message = 'You\'ve just accessed your ' . Company::get('code') . ' web portal using IP: ' . $event->ip;
        SMS::send($message, $event->user->mobile_no);
    }
}
