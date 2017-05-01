<?php

namespace App;

use App\User;
use App\Driver;
use App\Vehicle;
use Carbon\Carbon;
use App\Traits\DateFormat;
use App\Traits\ButtonAttribute;
use App\Filters\ReservationFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Reservation extends Model
{
    use RecordsActivity, ButtonAttribute, DateFormat;

    /**
     * The attributes that allowed to fill.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'start_at', 'end_at', 'reason', 'destination'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_at', 'end_at', 'approved_at'];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['owner', 'approver', 'vehicle', 'driver'];

    /**
     * Get a string path for the reservation.
     *
     * @return string
     */
    public function path()
    {
        return "/reservations/{$this->id}";
    }

    /**
     * Get the approved for reservations.
     * @return string
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the approved for reservations.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Get the driver for reservation.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    /**
     * Get the vehicle for reservation.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * Indicate if reservations is approved.
     */
    public function isApproved()
    {
        return $this->status == 'Lulus';
    }

    /**
     * Indicate if reservations is rejected.
     */
    public function isRejected()
    {
        return $this->status == 'Ditolak';
    }

    /**
     * Scope a query to only include active reservations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('end_at', '>=', Carbon::now());
    }

    /**
     * Scope a query to only include approved reservations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'Lulus');
    }

    /**
     * Scope a query to only include not approved reservations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotApproved($query)
    {
        return $query->where('status', 'Ditolak');
    }

    /**
     * Scope a query to only include pending reservations.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'Dalam Tindakan');
    }

    /**
     * Scope a query to only include reservations of a given status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include reservations create by user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBy($query, $owner)
    {
        return $query->where('user_id', $owner);
    }

    /**
     * Apply all relevant reservation filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ReservationFilters $filters)
    {
        return $filters->apply($query);
    }

    public function getStatusClassAttribute()
    {
        if ($this->isApproved()) {
            return 'success';
        }

        if ($this->isRejected()) {
            return 'danger';
        }

        return 'warning';
    }

    public static function statuses()
    {
        return [
            'D' => 'Dalam Tindakan',
            'L' => 'Lulus',
            'T' => 'Ditolak',
        ];
    }

    public static function status_labels()
    {
        return [
            'D' => 'warning',
            'L' => 'success',
            'T' => 'danger',
        ];
    }


}
