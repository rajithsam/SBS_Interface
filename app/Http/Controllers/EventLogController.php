<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event_Log as Event_Log;
use App\Employee as Employee;
class EventLogController extends Controller
{
	public function events($employee_id)
    {
    	$Employee = Employee::with('events')->find($employee_id);

    	$data = array( 'Employee' => $Employee );
    	//echo $Employee;
    	return view('events' , $data );
    }

    public function index()
    {
    	$Employee = Employee::all();
    	$data = array( 'Employee' => $Employee);

    	return view('EmployeeLog' , $data );
    }


}
