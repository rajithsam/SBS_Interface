<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abscent extends Model
{
    public function employee()
    {
    	return $this->belongsTo('App\Employee');
    }
    public function approver()
    {
    	return $this->belongsTo('App\User','approved_by_user');
    }
    public function leave()
    {
    	return $this->belongsTo('App\Leave');
    }
}
