<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Leave as Leave;
use JavaScript;
use App\Unit as Unit;

class LeaveController extends Controller
{
    public function create(Request $request)
    {
        try
        {
        	$Leave = new Leave();
        	$Leave->type = $request->input('LeaveName');
        	$Leave->maxNumber = $request->input('maxNumber');
        	$Leave->deduction = $request->input('deduction');
        	$Leave->unit_id = $request->input('unit');
        	if($request->input('parentCheck'))
        		$Leave->leave_id = $request->input('parent');

        	$Leave->save();

            $request['operation'] = 'Add Leave';
            $request['old_value'] = '-';
            $request['new_value'] = $Leave;
            LogController::create($request);

            $request->session()->put('success', 'Creation successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in create');
        }

    	return redirect()->action('LeaveController@index');
    }

    public function update(Request $request)
    {
        try
        {
        	$Leave = Leave::find($request->input('editLeaveId'));

            $request['old_value'] = Leave::find($request->input('editLeaveId'));

        	$Leave->type = $request->input('editLeaveName');
        	$Leave->maxNumber = $request->input('editmaxNumber');
        	$Leave->deduction = $request->input('editdeduction');
        	$Leave->unit_id = $request->input('editunit');
        	if($request->input('editparentCheck'))
        		$Leave->leave_id = $request->input('editparent');

        	$Leave->save();

            $request['operation'] = 'Update Leave';
            $request['new_value'] = $Leave;
            LogController::create($request);

            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }
    	return redirect()->action('LeaveController@index');
    }

    public function delete(Request $request, $id)
    {
        try
        {
        	$Leave = Leave::find($id);
            
            $request['old_value'] = $Leave;

            $Leave->delete();

            $request['operation'] = 'Delete Leave';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Delete successfull');
        
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }

    	return redirect()->action('LeaveController@index');
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
    	$Leave = Leave::with('unit', 'parent')->get();
    	$units = Unit::all();
    	$data = array( 'Leave' => $Leave, 'units' => $units
    		);
		JavaScript::put([
		'Leave' => $Leave
		]);
    	return view('Leave' , $data );
    }
}
