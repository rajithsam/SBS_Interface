<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Abscent as Abscent;
use JavaScript;
use App\Leave as Leave;


class AbscentController extends Controller
{
	public function update(Request $request)
    {
        try
        {
        	$Abscent = Abscent::find($request->input('editAbscentId'));

            $request['old_value'] =Abscent::find($request->input('editAbscentId'));
            
        	$Abscent->leave_id = $request->input('leave');
        	$Abscent->note = $request->input('editAbscentNote');
        	$Abscent->approved = $request->input('editAbscentApproved');
        	$Abscent->approved_by_user = $request->user()->id;
        	$Abscent->approved_from_ip =  $request->ip();
        	$Abscent->save();

            $request['operation'] = 'Approve Abscent';
            $request['new_value'] = $Abscent;
            LogController::create($request);

            $request->session()->put('success', 'Approve successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in approve');
        }

    	return redirect()->action('AbscentController@index', 1);
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

    	$Abscent = Abscent::where('approved',$approve)->with('employee', 'leave', 'approver')->get();
    	$Leaves = Leave::all();
    	$data = array( 'Abscent' => $Abscent, 'Leaves' => $Leaves, 'approve' => $approve
    		);
		JavaScript::put([
		'Abscent' => $Abscent
		]);
    	return view('abscent' , $data );
    }
}
