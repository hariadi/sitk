<?php

namespace App\Policies;

use App\User;
use App\Vehicle;
use Illuminate\Auth\Access\HandlesAuthorization;

class VehiclePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given user can create vehicles.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->isAdmin() || $user->isApprover()) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the vehicle.
     *
     * @param  \App\User   $user
     * @param  \App\Vehicle $vehicle
     * @return mixed
     */
    public function update(User $user, Vehicle $vehicle)
    {
        return $user->role_id == 2 || $user->role_id == 3;
    }

    /**
     * Determine if the given user can delete vehicles.
     *
     * @param  \App\User  $user
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
