<?php

namespace App\Policies;

use App\User;
use App\Driver;
use Illuminate\Auth\Access\HandlesAuthorization;

class DriverPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create drivers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin() || $user->isApprover();
    }

    /**
     * Determine whether the user can update the driver.
     *
     * @param  \App\User  $user
     * @param  \App\Driver  $driver
     * @return mixed
     */
    public function update(User $user, Driver $driver)
    {
        return $user->role_id == 2 || $user->role_id == 3;
    }

    /**
     * Determine whether the user can delete the driver.
     *
     * @param  \App\User  $user
     * @param  \App\Driver  $driver
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->isAdmin();
    }
}
