<?php

namespace App\Listeners;

use App\Events\PaymentFailedEvent;
use App\Mail\PaymentFailedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PaymentFailedListener implements ShouldQueue
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
     * @param  PaymentFailedEvent  $event
     * @return void
     */
    public function handle(PaymentFailedEvent $event)
    {
        $event->order->user->activities()->create(['activity_id' => 4, 'reference' => $event->order->id]);

        Mail::to($event->order->user->email)->send(new PaymentFailedMail($event->order, $event->reason));
    }
}
