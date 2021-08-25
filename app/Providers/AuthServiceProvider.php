<?php

namespace App\Providers;

use App\Models\Mba;
use App\Models\MbaBenefits;
use App\Models\MbaPhoto;
use App\Models\User;
use App\Policies\MbaBenefitPolicy;
use App\Policies\MbaPhotoPolicy;
use App\Policies\MbaPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Mba::class => MbaPolicy::class,
        User::class => UserPolicy::class,
        MbaPhoto::class => MbaPhotoPolicy::class,
        MbaBenefits::class => MbaBenefitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
