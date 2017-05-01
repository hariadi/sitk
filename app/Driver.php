<?php

namespace App;

use App\Traits\ButtonAttribute;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use RecordsActivity, ButtonAttribute;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'image',
    ];

    /**
     * Get a string path for the driver.
     *
     * @return string
     */
    public function path()
    {
        return "/drivers/{$this->id}";
    }

    /**
     * Get status for the driver.
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return true;
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($driver) {
            $driver->activity()->delete();
        });
    }
}
