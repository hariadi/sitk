<?php

namespace App\Filters;

use App\User;

class VehicleFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['types'];

    /**
     * Filter the query by a given types.
     *
     * @param  string $types
     * @return Builder
     */
    protected function types($type)
    {
        return $this->builder->where('types', $type);
    }
}
