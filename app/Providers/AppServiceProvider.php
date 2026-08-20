<?php

namespace App\Providers;

use App\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Gateways\MidtransGateway;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, MidtransGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // super_admin always passes every policy check. This is the ONLY
        // place super_admin's blanket access is granted — individual
        // policies below stay explicit for every other role.
        Gate::before(function ($user, string $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}