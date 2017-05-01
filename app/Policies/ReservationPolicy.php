<?php

namespace App\Policies;

use App\User;
use App\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the reservation.
     *
     * @param  \App\User   $user
     * @param  \App\Reservation $reservation
     * @return mixed
     */
    public function update(User $user, Reservation $reservation)
    {
        return $reservation->user_id == $user->id;
    }

    /**
     * Determine whether the user can edit the reservation.
     *
     * @param  \App\User   $user
     * @param  \App\Reservation $reservation
     * @return mixed
     */
    public function delete(User $user, Reservation $reservation)
    {
        return $user-> isAdmin() || $reservation->user_id == $user->id;
    }
}
