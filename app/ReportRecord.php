<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportRecord extends Model
{
	public $empName = "";
	public $empId = 0 ;
	public $attendenceNumber = 0;
	public $lateArrivals = 0;
	public $earlyDeparture = 0;
	public $abscenseNumber = 0;
	public $overtimeNumber = 0;
	public $startDate = null;
	public $endDate = null;

}