<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event_Log as Event_Log;
use App\Employee as Employee;
use App\ReportRecord as Record;
use App\Abscent as Abscent;
use App\OverTime as OverTime;
use App\Event as Event;
use App\AttendenceRecord as AttendenceRecord;
use Excel as Excel;
use App\EmployeeShift;
class ReportController extends Controller
{
	public function GenerateDetailedReport(Request $request)
    {
    	$empId = $request->input('empId');
    	$startDate =  $request->input('startDate');
    	$endDate =  $request->input('endDate');

		$records = [];

    	$employee = Employee::find($empId);

    	$current = new \DateTime($startDate);
    	$next = new \DateTime($startDate);
    	$end = new \DateTime($endDate);

		$records = [];

		while($current != $end)
		{
		    $shift = EmployeeShift::where('employee_id',$employee->id)->where('startDate', '<=' ,$current->format("Y-m-d"))->where('endDate' , '>' ,$current->format("Y-m-d"))->with('shift')->get();

			if(count($shift) == 0)
			{
				date_add($current, date_interval_create_from_date_string("1 days"));
				$attendence->type = "No Shift Assigned";
			}

			date_add($next, date_interval_create_from_date_string("1 days"));

	    	$eventIn = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 0)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'asc')->get();
			$eventOut = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 1)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'desc')->get();
			$abscents = Abscent::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
			$overtime = OverTime::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
			$event = Event::where('start' , '<=' ,$current->format("Y-m-d"))->where('end' , '>' ,$current->format("Y-m-d"))->get();

	    	$attendence = new AttendenceRecord();
	    	$attendence->date = $current->format("Y-m-d");

			if(count($event) > 0)
			{
				$attendence->type = $event[0]->title;
				$attendence->approved = "";
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}

			elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
	    	elseif(count($eventIn) > 0 || count($eventOut) > 0 )
	    	{

					if(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->StartSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->EndSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->StartMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->EndMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 1 )
					{

						if(count($eventIn) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->StartTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->EndTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->StartWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->EndWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->StartThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->EndThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}

					elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->StartFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->EndFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->StartSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->EndSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}					

		    	if(count($eventIn) > 0)
		    	{
		    		$attendence->firsIn = date('H:i' , $eventIn[0]->nDateTime);
		    		$attendence->approved = "";
		    	}
		    	else
		    	{
		    		$attendence->firsIn = "";
		    		$attendence->approved = "";
		    	}
		    	if(count($eventOut) > 0)
		    	{
		    		$attendence->lastOut = date('H:i' , $eventOut[0]->nDateTime);
		    		$attendence->approved = "";
		    	}
		    	else
		    	{
		    		$attendence->lastOut = "";
		    		$attendence->approved = "";
		    	}
			}
	    	elseif(count($abscents) > 0)
	    	{
	    		$attendence->type = "Abscent";
	    		if($abscents[0]->approved)
	    			$attendence->approved = "Yes";
	    	}
		    elseif(count($overtime) > 0)
		    {
				$attendence->type = "Overtime";
				if($overtime[0]->approved)
					$attendence->approved = "Yes";
			}
			else
			{
				$attendence->type = "Abscent";
			}
			$records[] = $attendence;
	    	date_add($current, date_interval_create_from_date_string("1 days"));
    	}

    	$data = array( 'Record' => $records , "Employee"=>$employee , 'EmpIds' => $request->input('empId'), 'StartDate'=> $request->input('startDate') , 'EndDate' => $request->input('endDate'));
    	return view('GenerateDetailedReport' , $data );
    }

    public function DownloadDetailed(Request $request)
    {
            Excel::create('Detailed Attendence', function($excel) use($request){

        $excel->sheet('Attendence', function($sheet) use($request){
        $sheet->setOrientation('landscape');

   		$empId = $request->input('empId');
    	$startDate =  $request->input('startDate');
    	$endDate =  $request->input('endDate');

		$records = [];

    	$employee = Employee::find($empId);

    	$current = new \DateTime($startDate);
    	$next = new \DateTime($startDate);
    	$end = new \DateTime($endDate);

		$records = [];

		while($current != $end)
		{
		    $shift = EmployeeShift::where('employee_id',$employee->id)->where('startDate', '<=' ,$current->format("Y-m-d"))->where('endDate' , '>' ,$current->format("Y-m-d"))->with('shift')->get();

			if(count($shift) == 0)
			{
				date_add($current, date_interval_create_from_date_string("1 days"));
				$attendence->type = "No Shift Assigned";
			}

			date_add($next, date_interval_create_from_date_string("1 days"));

	    	$eventIn = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 0)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'asc')->get();
			$eventOut = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 1)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'desc')->get();
			$abscents = Abscent::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
			$overtime = OverTime::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
			$event = Event::where('start' , '<=' ,$current->format("Y-m-d"))->where('end' , '>' ,$current->format("Y-m-d"))->get();

	    	$attendence = new AttendenceRecord();
	    	$attendence->date = $current->format("Y-m-d");

			if(count($event) > 0)
			{
				$attendence->type = $event[0]->title;
				$attendence->approved = "";
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}

			elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
			elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 0 )
			{
				$attendence->type = "Weekend";
				$attendence->approved = "";
				//date_add($current, date_interval_create_from_date_string("1 days"));
			}
	    	elseif(count($eventIn) > 0 || count($eventOut) > 0 )
	    	{

					if(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->StartSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->EndSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->StartMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->EndMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 1 )
					{

						if(count($eventIn) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->StartTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->EndTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->StartWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->EndWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->StartThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->EndThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}

					elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->StartFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->EndFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->StartSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$attendence->lateArrival = $minutes;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->EndSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$attendence->earlyDeparture = $minutes;
						}
					}					

		    	if(count($eventIn) > 0)
		    	{
		    		$attendence->firsIn = date('H:i' , $eventIn[0]->nDateTime);
		    		$attendence->approved = "";
		    	}
		    	else
		    	{
		    		$attendence->firsIn = "";
		    		$attendence->approved = "";
		    	}
		    	if(count($eventOut) > 0)
		    	{
		    		$attendence->lastOut = date('H:i' , $eventOut[0]->nDateTime);
		    		$attendence->approved = "";
		    	}
		    	else
		    	{
		    		$attendence->lastOut = "";
		    		$attendence->approved = "";
		    	}
			}
	    	elseif(count($abscents) > 0)
	    	{
	    		$attendence->type = "Abscent";
	    		if($abscents[0]->approved)
	    			$attendence->approved = "Yes";
	    	}
		    elseif(count($overtime) > 0)
		    {
				$attendence->type = "Overtime";
				if($overtime[0]->approved)
					$attendence->approved = "Yes";
			}
			else
			{
				$attendence->type = "Abscent";
			}
			$records[] = $attendence;
	    	$array[] = get_object_vars($attendence);
	    	date_add($current, date_interval_create_from_date_string("1 days"));
    	}

                    $sheet->fromArray($array);

                });
            })->export('xls');
    }
    public function GenerateReport(Request $request)
    {
    	$empIds = $request->input('empIds');


    	$startDate =  $request->input('startDate');
    	$endDate =  $request->input('endDate');

		$records = [];

		foreach($empIds as $empId)
		{
	    	$employee = Employee::find($empId);


	    	$current = new \DateTime($startDate);
	    	$next = new \DateTime($startDate);
	    	$end = new \DateTime($endDate);

			$record = new Record();

			while($current != $end)
			{

	    		$shift = EmployeeShift::where('employee_id',$employee->id)->where('startDate', '<=' ,$current->format("Y-m-d"))->where('endDate' , '>' ,$current->format("Y-m-d"))->with('shift')->get();

				if(count($shift) ==0)
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}

				date_add($next, date_interval_create_from_date_string("1 days"));
			
		    	$eventIn = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 0)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'asc')->get();
				$eventOut = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 1)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'desc')->get();
				$abscents = Abscent::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
				$overtime = OverTime::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
				$event = Event::where('start' , '<=' ,$current->format("Y-m-d"))->where('end' , '>' ,$current->format("Y-m-d"))->get();
		    	
		    	$record->empId = $empId;
		    	$record->empName = $employee->name;
		    	$record->startDate = $startDate;
		    	$record->endDate = $endDate;

			    if(count($overtime) >0)
					$record->overtimeNumber += 1;
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
		    	elseif(count($eventIn) > 0 || count($eventOut) > 0)
		    	{
					if(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->StartSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->EndSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}

					elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->StartMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->EndMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}


					elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->StartTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->EndTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->StartWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->EndWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->StartThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->EndThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->StartFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->EndFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->StartSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->EndSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}					
		    		$record->attendenceNumber += 1;
		    	}
		    	elseif(count($abscents) >0)
		    		$record->abscenseNumber += 1;
				else
					$record->abscenseNumber += 1;

		    	date_add($current, date_interval_create_from_date_string("1 days"));
	    	}

	    	$records[] = $record;
    	}

    	$data = array( 'Record' => $records, 'EmpIds' => implode(',',$request->input('empIds')), 'StartDate'=> $request->input('startDate') , 'EndDate' => $request->input('endDate'));
    	return view('GenerateReport' , $data );
    }

    public function DownloadSummary(Request $request)
    {
        Excel::create('Attendence', function($excel) use($request){

        $excel->sheet('Attendence', function($sheet) use($request){
        $sheet->setOrientation('landscape');

        $empIds = explode(',',$request->input('empId'));

    	$startDate =  $request->input('startDate');
    	$endDate =  $request->input('endDate');

		$records = [];

		foreach($empIds as $empId)
		{
	    	$employee = Employee::find($empId);

	    	$current = new \DateTime($startDate);
	    	$next = new \DateTime($startDate);
	    	$end = new \DateTime($endDate);

			$record = new Record();

			while($current != $end)
			{
	    		$shift = EmployeeShift::where('employee_id',$employee->id)->where('startDate', '<=' ,$current->format("Y-m-d"))->where('endDate' , '>' ,$current->format("Y-m-d"))->with('shift')->get();

				if(count($shift) ==0)
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}

				date_add($next, date_interval_create_from_date_string("1 days"));
			
		    	$eventIn = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 0)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'asc')->get();
				$eventOut = Event_Log::where('nUserID' , $employee->nUserID)->where('nTNAEvent' , 1)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'desc')->get();
				$abscents = Abscent::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
				$overtime = OverTime::where('employee_id' ,$employee->nUserID)->where('startDate' , '>' ,$current->format("Y-m-d"))->where('endDate' , '<' , $next->format("Y-m-d"))->get();
				$event = Event::where('start' , '<=' ,$current->format("Y-m-d"))->where('end' , '>' ,$current->format("Y-m-d"))->get();
		    	
		    	$record->empId = $empId;
		    	$record->empName = $employee->name;
		    	$record->startDate = $startDate;
		    	$record->endDate = $endDate;

			    if(count($overtime) >0)
					$record->overtimeNumber += 1;
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
				elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 0 )
				{
					date_add($current, date_interval_create_from_date_string("1 days"));
					continue;
				}
		    	elseif(count($eventIn) > 0 || count($eventOut) > 0)
		    	{
					if(date('N', strtotime($current->format("Y-m-d"))) == 7 && $shift[0]->shift->Sunday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->StartSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSunday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSunday;
							$dt = new \DateTime($shift[0]->shift->EndSunday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}

					elseif(date('N', strtotime($current->format("Y-m-d"))) == 1 && $shift[0]->shift->Monday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->StartMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartMonday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartMonday;
							$dt = new \DateTime($shift[0]->shift->EndMonday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}


					elseif(date('N', strtotime($current->format("Y-m-d"))) == 2 && $shift[0]->shift->Tuseday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->StartTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartTuseday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartTuseday;
							$dt = new \DateTime($shift[0]->shift->EndTuseday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 3 && $shift[0]->shift->Wednesday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->StartWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartWednesday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartWednesday;
							$dt = new \DateTime($shift[0]->shift->EndWednesday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 4 && $shift[0]->shift->Thursday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->StartThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartThursday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartThursday;
							$dt = new \DateTime($shift[0]->shift->EndThursday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 5 && $shift[0]->shift->Friday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->StartFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartFriday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartFriday;
							$dt = new \DateTime($shift[0]->shift->EndFriday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}
					elseif(date('N', strtotime($current->format("Y-m-d"))) == 6 && $shift[0]->shift->Saturday == 1 )
					{
						if(count($eventIn) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->StartSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventIn[0]->nDateTime));
							$interval  = $datetime2 - $datetime1;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->lateArrival)
								$record->lateArrivals += 1;
						}
						if(count($eventOut) > 0)
						{
							//if($shift->StartSaturday - date($eventIn[0]->nDateTime))
							#echo $shift[0]->shift->StartSaturday;
							$dt = new \DateTime($shift[0]->shift->EndSaturday);

							$datetime1 = strtotime($dt->format('H:i'));
							$datetime2 = strtotime(date( 'H:i',$eventOut[0]->nDateTime));
							$interval  = $datetime1 - $datetime2;
							$minutes   = round($interval / 60);
							if($minutes > $shift[0]->shift->earlyDeparture)
								$record->earlyDeparture += 1;
						}
					}					
		    		$record->attendenceNumber += 1;
		    	}
		    	elseif(count($abscents) >0)
		    		$record->abscenseNumber += 1;
				else
					$record->abscenseNumber += 1;
		    	date_add($current, date_interval_create_from_date_string("1 days"));
	    	}

	    	$records[] = $record;
	    	$array[] = get_object_vars($record);
    	}

                    $sheet->fromArray($array);

                });
            })->export('xls');
    }
    public function index()
    {
    	$employee = Employee::all();
    	$data = array( 'Employee' => $employee);
    	return view('Report', $data);
    }
}
