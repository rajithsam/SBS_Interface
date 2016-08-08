<?php

namespace App;

class AttendenceRecord
{
	public $date = null;
	public $firsIn = null;
	public $lastOut = null;
	public $lateArrival = 0;
	public $earlyDeparture = 0;
	public $type = ""; 
	public $approved = "No";
}