<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeShift extends Model
{
	public function shift()
	{
		return $this->belongsTo('App\Shift');
	}
}
