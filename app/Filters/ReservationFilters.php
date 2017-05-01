<?php

namespace App\Filters;

use App\User;

class ReservationFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['reason', 'status'];

    /**
     * Filter the query by a given reason.
     *
     * @param  string $reason
     * @return Builder
     */
    protected function reason($reason)
    {
        return $this->builder->where('reason', 'like', $reason);
    }

    /**
     * Filter the query by a given status.
     *
     * @param  string $status
     * @return Builder
     */
    protected function status($status)
    {
        return $this->builder->where('status', $status);
    }
}
