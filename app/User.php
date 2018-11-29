<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const GUEST_TYPE = 'guest';
    const ADMIN_TYPE = 'admin';
    const SUPER_ADMIN_TYPE = 'sadmin';

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'color_code', 'user_role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->user_role === self::ADMIN_TYPE;
    }

    public function isSuperAdmin()
    {
        return $this->user_role === self.SUPER_ADMIN_TYPE;
    }
}
