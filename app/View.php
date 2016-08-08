<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    public function permissions()
    {
        return $this->belongsToMany('App\Permission', 'views_permissions');
    }
    
}
