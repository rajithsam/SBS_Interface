<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Shift;
use App\Employee;
use App\EmployeeShift;
use JavaScript;

class ShiftAssignmentController extends Controller
{
    public function update(Request $request)
    {
        $empId =  $request->input('empId');
        try
        {
            if($request->input('ShiftId') > 0)
            {
               $EmployeeShift = EmployeeShift::find($request->input('ShiftId'));

               $request['operation'] = 'Update Shift Assignment';
               $request['old_value'] = EmployeeShift::find($request->input('ShiftId'));
            }
            else
            {
                $EmployeeShift = new EmployeeShift();

                $request['operation'] = 'Add Shift Assignment';
                $request['old_value'] = '-';
            }
            

            $EmployeeShift->employee_id = $request->input('empId');
            $EmployeeShift->shift_id = $request->input('selectShift');
            echo $request->input('addStartSaturday');
            echo $request->input('empId');
            echo $request->input('selectShift');
            echo $request->input('addEndSaturday');
            $EmployeeShift->startDate = new \datetime($request->input('addStartSaturday'));
            $EmployeeShift->endDate =   new \datetime($request->input('addEndSaturday'));
            

            $EmployeeShift->save();

            $request['new_value'] = $EmployeeShift;
            LogController::create($request);

            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }

        return redirect()->action('ShiftAssignmentController@index', $empId);
    }

    public function delete(Request $request, $id)
    {
        $empId=-1;
        try
        {
            $EmployeeShift = EmployeeShift::find($id);

            $empId = $EmployeeShift->employee_id;

            $request['old_value'] = $EmployeeShift;

            $EmployeeShift->delete(); 

            $request['operation'] = 'Delete Employee Shift';
            $request['new_value'] = '-';
            LogController::create($request);

           $request->session()->put('success', 'Delete successfull');
        
        }
       catch(\Exception $e)
        {
           $request->session()->put('error', 'Error in delete');
        }

        return redirect()->action('ShiftAssignmentController@index', $empId);
    }

    public function index(Request $request, $id)
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

    	$Employee = Employee::where('id', $id)->with('shifts')->get();
        $Shifts = Shift::all();

    	$data = array( 'Employee' => $Employee, 'Shifts' => $Shifts);

		JavaScript::put([
		'Employee' => $Employee,
        'Shifts' => $Shifts
		]);
    	return view('shiftAssignment', $data);
    }
}
