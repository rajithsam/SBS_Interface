<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Overtime as Overtime;
use JavaScript;
use App\Bonus as Bonus;

class OvertimeController extends Controller
{
	public function update(Request $request)
    {
        try
        {
        	$Overtime = Overtime::find($request->input('editOvertimeId'));

            $request['old_value'] =Overtime::find($request->input('editOvertimeId'));

        	$Overtime->bonus_id = $request->input('bonus');
        	$Overtime->note = $request->input('editOvertimeNote');
        	$Overtime->approved = $request->input('editOvertimeApproved');
        	$Overtime->approved_by_user = $request->user()->id;
        	$Overtime->approved_from_ip =  $request->ip();
        	$Overtime->save();

            $request['operation'] = 'Approve Overtime';
            $request['new_value'] = $Overtime;
            LogController::create($request);
            $request->session()->put('success', 'Approve successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in approve');
        }

    	return redirect()->action('OvertimeController@index', 0);
    }
    public function index(Request $request, $approve)
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

    	$Overtime = Overtime::where('approved',$approve)->with('employee', 'bonus', 'approver')->get();
    	$Bonuss = Bonus::all();
    	$data = array( 'Overtime' => $Overtime, 'Bonuss' => $Bonuss, 'approve' => $approve
    		);
		JavaScript::put([
		'Overtime' => $Overtime
		]);
    	return view('overtime' , $data );
    }
}
