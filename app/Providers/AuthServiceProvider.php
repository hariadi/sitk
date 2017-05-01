<?php

namespace App\Providers;

use App\Driver;
use App\Vehicle;
use App\Reservation;
use App\Policies\DriverPolicy;
use App\Policies\VehiclePolicy;
use App\Policies\ReservationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Reservation::class => ReservationPolicy::class,
        Vehicle::class => VehiclePolicy::class,
        Driver::class => DriverPolicy::class
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
