<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    public function parent()
    {
    	return $this->belongsTo('App\Leave');
    }
    public function unit()
    {
    	return $this->belongsTo('App\Unit');
    }
}
