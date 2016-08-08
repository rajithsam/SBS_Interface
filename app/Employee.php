<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function department()
    {
    	return $this->belongsTo('App\Department');
    }

    public function events()
    {
    	return $this->hasMany('App\Event_Log' , 'nUserID', 'nUserID');
    }

    public function shifts()
    {
    	return $this->hasMany("App\EmployeeShift")->join('shifts', 'shifts.id' , '=' , 'employee_shifts.shift_id')->select('employee_shifts.*', 'shifts.name');
    }

    public function connectedUser()
    {
        return $this->belongsTo('App\ConnectedUser' , 'nUserID', 'nUserID');
    }
}
