<?php

namespace App;

use Carbon\Carbon;
use App\Filters\VehicleFilters;
use App\Traits\ButtonAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use RecordsActivity, ButtonAttribute;

    protected $fillable = [
        'approver_id',
        'registration_no',
        'types',
        'model',
        'image',
        'capacity',
    ];

    /**
     * Get a string path for the vehicle.
     *
     * @return string
     */
    public function path()
    {
        return "/vehicles/{$this->id}";
    }

    /**
     * Get status for the vehicle.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return true;
    }

    /**
     * Apply all relevant vehicle filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, VehicleFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($vehicle) {
            $vehicle->activity()->delete();
        });
    }
}