<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Bonus as Bonus;
use JavaScript;
use App\Unit as Unit;


class BonusController extends Controller
{
 public function create(Request $request)
    {
        try
        {
        	$Bonus = new Bonus();
        	$Bonus->type = $request->input('BonusName');
        	$Bonus->maxNumber = $request->input('maxNumber');
        	$Bonus->raise = $request->input('raise');
        	$Bonus->unit_id = $request->input('unit');

        	$Bonus->save();

            $request['operation'] = 'Add Bonus';
            $request['old_value'] = '-';
            $request['new_value'] = $Bonus;
            LogController::create($request);
            $request->session()->put('success', 'Creation successfull');
            

        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in creation');
        }

    	return redirect()->action('BonusController@index');
    }

    public function update(Request $request)
    {
        try
        {
        	$Bonus = Bonus::find($request->input('editBonusId'));

            $request['old_value'] = Bonus::find($request->input('editBonusId'));


        	$Bonus->type = $request->input('editBonusName');
        	$Bonus->maxNumber = $request->input('editmaxNumber');
        	$Bonus->raise = $request->input('editraise');
        	$Bonus->unit_id = $request->input('editunit');

        	$Bonus->save();

            $request['operation'] = 'Update Bonus';
            $request['new_value'] = $Bonus;
            LogController::create($request);
            $request->session()->put('success', 'Update successfull');
            

        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }

    	return redirect()->action('BonusController@index');
    }

    public function delete(Request $request, $id)
    {
        try
        {
        	$Bonus = Bonus::find($id);

            $request['old_value'] = $Bonus;

            $Bonus->delete();

            $request['operation'] = 'Delete Bonus';
            $request['new_value'] = '-';
            LogController::create($request);
            $request->session()->put('success', 'Delete successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }
    	return redirect()->action('BonusController@index');
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

    	$Bonus = Bonus::with('unit')->get();
    	$units = Unit::all();
    	$data = array( 'Bonus' => $Bonus, 'units' => $units
    		);
		JavaScript::put([
		'Bonus' => $Bonus
		]);
    	return view('Bonus' , $data );
    }
}
