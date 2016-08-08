<?php

namespace App;

use Cache;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'users_permissions');
    }

    public function cachedPermissions()
    {
        return Cache::remember('permissions' , 1 , function() 
        {
            return $this->permissions();
        });
        #return $this->belongsToMany('App\Permission', 'views_permissions');
    }

}
