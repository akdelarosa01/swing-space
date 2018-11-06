<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'firstname',
        'lastname',
        'email',
        'password',
        'actual_password',
        'user_type',
        'is_admin',
        'disabled',
        'language',
        'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function employee()
    {
        return $this->hasMany('App\Employee');
    }

    public function customer()
    {
        return $this->hasMany('App\Customer');
    }

    public function findForPassport($identifier)
    {
        return User::orWhere('email',$identifier)->where('disabled',0)->first();
    }
}
