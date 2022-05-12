<?php

namespace App\Listeners;

use App\Events\PaymentSucceededEvent;
use App\Mail\PaymentSucceededMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PaymentSucceededListener implements ShouldQueue
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
     * @param  PaymentSucceededEvent  $event
     * @return void
     */
    public function handle(PaymentSucceededEvent $event)
    {
        $event->order->user->activities()->create(['activity_id' => 3, 'reference' => $event->order->id]);

        Mail::to($event->order->user->email)->send(new PaymentSucceededMail($event->order));
    }
}
