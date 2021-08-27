<?php

namespace App\Providers;

use App\Models\Mba;
use App\Models\MbaBenefits;
use App\Models\MbaPhoto;
use App\Models\MbaPlan;
use App\Models\User;
use App\Observers\MbaBenefitObserver;
use App\Observers\MbaObserver;
use App\Observers\MbaphotoObserver;
use App\Observers\MbaPlanObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Mba::observe(MbaObserver::class);
        User::observe(UserObserver::class);
        MbaPhoto::observe(MbaphotoObserver::class);
        MbaBenefits::observe(MbaBenefitObserver::class);
        MbaPlan::observe(MbaPlanObserver::class);
    }
}
