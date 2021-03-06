<?php

namespace App\Providers;

use App\Models\Investments;
use App\Models\Mba;
use App\Models\MbaBenefits;
use App\Models\MbaPhoto;
use App\Models\MbaPlan;
use App\Models\Message;
use App\Models\User;
use App\Models\Wallet;
use App\Policies\InvestmentPolicy;
use App\Policies\MbaBenefitPolicy;
use App\Policies\MbaPhotoPolicy;
use App\Policies\MbaPlanPolicy;
use App\Policies\MbaPolicy;
use App\Policies\MessagePolicy;
use App\Policies\UserPolicy;
use App\Policies\WalletPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        Mba::class => MbaPolicy::class,
        User::class => UserPolicy::class,
        Wallet::class => WalletPolicy::class,
        MbaPhoto::class => MbaPhotoPolicy::class,
        MbaBenefits::class => MbaBenefitPolicy::class,
        MbaPlan::class => MbaPlanPolicy::class,
        Investments::class => InvestmentPolicy::class,
        Message::class => MessagePolicy::class,

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });
    }
}
