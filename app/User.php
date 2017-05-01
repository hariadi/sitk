<?php

namespace App;

use App\Activity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ic',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Determine if the given user have role as admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id == 3;
    }

    /**
     * Determine if the given user have role as approver.
     *
     * @return bool
     */
    public function isApprover()
    {
        return $this->role_id == 2;
    }

    /**
     * Get all activity for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
