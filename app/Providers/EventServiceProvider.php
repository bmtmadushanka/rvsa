<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => ['App\Listeners\UserRegistered'],
        'App\Events\LoginSucceededEvent' => ['App\Listeners\LoginSucceededListener'],
        'App\Events\VerifyMobileEvent' => ['App\Listeners\VerifyMobileListener'],

        'App\Events\PasswordResetByAdminEvent' => ['App\Listeners\PasswordResetByAdminListener'],
        'App\Events\PasswordChangedByClientEvent' => ['App\Listeners\PasswordChangedByClientListener'],

        'App\Events\PaymentSucceededEvent' => ['App\Listeners\PaymentSucceededListener'],
        'App\Events\PaymentFailedEvent' => ['App\Listeners\PaymentFailedListener'],

        'App\Events\DiscussionStartedEvent' => ['App\Listeners\DiscussionStartedListener'],
        'App\Events\DiscussionRepliedEvent' => ['App\Listeners\DiscussionRepliedListener'],

        'App\Events\VersionChangedEvent' => ['App\Listeners\VersionChangedListener'],
        'App\Events\NewModelReportAddedEvent' => ['App\Listeners\NewModelReportAddedListener'],

        'App\Events\ProfileChangedByAdminEvent' => ['App\Listeners\ProfileChangedByAdminListener'],
        'App\Events\ProfileChangeRequestedEvent' => ['App\Listeners\ProfileChangeRequestedListener'],
        'App\Events\ProfileChangesApprovedEvent' => ['App\Listeners\ProfileChangesApprovedListener'],

        'App\Events\CompressImagesEvent' => ['App\Listeners\CompressImagesListener'],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
