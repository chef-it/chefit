<?php

namespace app;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function Profile()
    {
        return $this->hasOne('App\UserProfile');
    }

    public function MasterList()
    {
        return $this->hasMany('App\MasterList');
    }

    public function Recipes()
    {
        return $this->hasMany('App\Recipe');
    }
    
    public function Invoices()
    {
        return $this->hasMany('App\Invoice');
    }
}
