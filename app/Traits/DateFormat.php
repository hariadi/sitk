<?php

namespace App\Traits;

use Carbon\Carbon;

trait DateFormat
{
    protected $newDateFormat = 'd M Y g:i A';

    /**
     * Get start_at formatting date
     *
     * @param  Carbon\Carbon $value
     * @return string
     */
    public function getApprovedAtAttribute($value) {
       return Carbon::parse($value)->format($this->newDateFormat);
    }

    /**
     * Get start_at formatting date
     *
     * @param  Carbon\Carbon $value
     * @return string
     */
    public function getStartAtAttribute($value) {
       return Carbon::parse($value)->format($this->newDateFormat);
    }

    /**
     * Get end_at formatting date
     *
     * @param  string $value
     * @return string
     */
    public function getEndAtAttribute($value) {
        return Carbon::parse($value)->format($this->newDateFormat);
    }

    /**
     * Set the start date with proper db fromatting
     *
     * @param  string  $value
     * @return Carbon\Carbon
     */
    public function setStartAtAttribute($value)
    {
        $this->attributes['start_at'] = Carbon::parse($value)->toDateTimeString();
    }

    /**
     * Set the end date with proper db fromatting
     *
     * @param  string  $value
     * @return Carbon\Carbon
     */
    public function setEndAtAttribute($value)
    {
        $this->attributes['end_at'] = Carbon::parse($value)->toDateTimeString();
    }
}