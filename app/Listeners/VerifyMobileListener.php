<?php

namespace App\Listeners;

use App\Events\VerifyMobileEvent;
use App\Facades\Company;
use App\Facades\SMS;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class VerifyMobileListener
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
     * @param  VerifyMobileEvent  $event
     * @return void
     */
    public function handle(VerifyMobileEvent $event)
    {
        $token = random_int(100000, 999999);

        session()->put(['auth_token' => [
            'user_id' => $event->user->id,
            'mobile_no' => $event->user->mobile_no,
            'code' => $token
        ]]);

        SMS::send((Company::get('code') . ' verification code: '  . $token), $event->user->mobile_no);

    }
}
