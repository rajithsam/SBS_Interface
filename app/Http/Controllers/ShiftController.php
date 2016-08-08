<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Shift as Shift;
use JavaScript;

class ShiftController extends Controller
{
    public function create(Request $request)
    {
        $Shift = new Shift();
         $Shift->name = $request->input('addShiftName');
echo $request->input('addStartSaturday');
echo $request->input('addEndSaturday');
        if($request->input('addsaturdayCheck'))
        {
            $Shift->Saturday = true;
            $Shift->StartSaturday = $request->input('addStartSaturday');
            $Shift->StartSaturday = $request->input('addEndSaturday');
        }
        else
            $Shift->Saturday = false;


        if($request->input('addmondayCheck'))
        {
            $Shift->Monday = true;
            $Shift->StartMonday = $request->input('addStartMonday');
            $Shift->StartMonday = $request->input('addEndMonday');
        }
        else
            $Shift->Monday = false;


        if($request->input('addtusedayCheck'))
        {
            $Shift->Tuseday = true;
            $Shift->StartTuseday = $request->input('addStartTuseday');
            $Shift->StartTuseday = $request->input('addEndTuseday');
        }
        else
            $Shift->Tuseday = false;


        if($request->input('addwednesdayCheck'))
        {
            $Shift->Wednesday = true;
            $Shift->StartWednesday = $request->input('addStartWednesday');
            $Shift->StartWednesday = $request->input('addEndWednesday');
        }
        else
            $Shift->Wednesday = false;


        if($request->input('addthursdayCheck'))
        {
            $Shift->Thursday = true;
            $Shift->StartThursday = $request->input('addStartThursday');
            $Shift->StartThursday = $request->input('addEndThursday');
        }
        else
            $Shift->Thursday = false;


        if($request->input('addfridayCheck'))
        {
            $Shift->Friday = true;
            $Shift->StartFriday = $request->input('addStartFriday');
            $Shift->StartFriday = $request->input('addEndFriday');
        }
        else
            $Shift->Friday = false;


        if($request->input('addsundayCheck'))
        {
            $Shift->Sunday = true;
            $Shift->StartSunday = $request->input('addStartSunday');
            $Shift->StartSunday = $request->input('addEndSunday');
        }
        else
            $Shift->Sunday = false;

        $Shift->lateArrival = $request->input('addlateArrival');
        $Shift->earlyDeparture = $request->input('addearlyDeparture');

        $Shift->save();

        $request['operation'] = 'Add Shift';
        $request['old_value'] = '-';
        $request['new_value'] = $Shift;
        LogController::create($request);


        return redirect()->action('ShiftController@index');
    }

    public function update(Request $request)
    {
        try
        {
            if($request->input('ShiftId') > 0)
            {
        	   $Shift = Shift::find($request->input('ShiftId'));

               $request['operation'] = 'Update Shift';
               $request['old_value'] = Shift::find($request->input('ShiftId'));
            }
            else
            {
                $Shift = new Shift();

                $request['operation'] = 'Add Shift';
                $request['old_value'] = '-';
            }
            

      	     $Shift->name = $request->input('addShiftName');

        	if($request->input('addsaturdayCheck'))
        	{
        		$Shift->Saturday = true;
        		$Shift->StartSaturday = $request->input('addStartSaturday');
        		$Shift->EndSaturday =  $request->input('addEndSaturday');
        	}
        	else
        		$Shift->Saturday = false;


        	if($request->input('addMondayCheck'))
        	{
        		$Shift->Monday = true;
        		$Shift->StartMonday = $request->input('addStartMonday');
        		$Shift->EndMonday = $request->input('addEndMonday');
        	}
        	else
        		$Shift->Monday = false;


        	if($request->input('addTusedayCheck'))
        	{
        		$Shift->Tuseday = true;
        		$Shift->StartTuseday = $request->input('addStartTuseday');
        		$Shift->EndTuseday = $request->input('addEndTuseday');
        	}
        	else
        		$Shift->Tuseday = false;


        	if($request->input('addWednesdayCheck'))
        	{
        		$Shift->Wednesday = true;
        		$Shift->StartWednesday = $request->input('addStartWednesday');
        		$Shift->EndWednesday = $request->input('addEndWednesday');
        	}
        	else
        		$Shift->Wednesday = false;


        	if($request->input('addThursdayCheck'))
        	{
        		$Shift->Thursday = true;
        		$Shift->StartThursday = $request->input('addStartThursday');
        		$Shift->EndThursday = $request->input('addEndThursday');
        	}
        	else
        		$Shift->Thursday = false;


        	if($request->input('addFridayCheck'))
        	{
        		$Shift->Friday = true;
        		$Shift->StartFriday = $request->input('addStartFriday');
        		$Shift->EndFriday = $request->input('addEndFriday');
        	}
        	else
        		$Shift->Friday = false;


        	if($request->input('addSundayCheck'))
        	{
        		$Shift->Sunday = true;
        		$Shift->StartSunday = $request->input('addStartSunday');
        		$Shift->EndSunday = $request->input('addEndSunday');
        	}
        	else
        		$Shift->Sunday = false;

        	$Shift->lateArrival = $request->input('addlateArrival');
        	$Shift->earlyDeparture = $request->input('addearlyDeparture');

        	$Shift->save();

            $request['new_value'] = $Shift;
            LogController::create($request);

            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }

    	return redirect()->action('ShiftController@index');
    }

    public function delete(Request $request,$id)
    {
        try
        {
        	$Shift = Shift::find($id);

            $request['old_value'] = $Shift;

            $Shift->delete(); 

            $request['operation'] = 'Delete Leave';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Delete successfull');
        
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }

    	return redirect()->action('ShiftController@index');
    }

    public function index(Request $request)
    {
        if($request->session()->has('error'))
        {
            flash()->error($request->session()->get('error'));
            $request->session()->forget('error');
        }
        if($request->session()->has('success'))
        {
            flash()->success($request->session()->get('success'));
            $request->session()->forget('success');
        }

    	$Shift = Shift::all();
    	$data = array( 'Shift' => $Shift
    		);
		JavaScript::put([
		'Shift' => $Shift
		]);
    	return view('Shift' , $data );
    }
}
