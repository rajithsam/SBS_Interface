<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Employee as Employee;
use App\ConnectedUser as ConnectedUser;
use App\Department as Department;
use JavaScript;

class EmployeeController extends Controller
{

    public function enrollFinger(Request $request)
    {
        try
        {
            $output = shell_exec('BioStationManagement_CMD.exe createUser '  . $request->input('nID') . ' ' . $request->input('nName') . ' ' . $request->input('nDevice'));

            $request->session()->put('success', 'Enroll successfull');
        }

        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in enroll');
        }

        return redirect()->action('EmployeeController@index');
    }
   public function create(Request $request)
    {
        try
        {
        	$Employee = new Employee();
        	$Employee->name = $request->input('EmployeeName');
        	$Employee->phone = $request->input('phone');
        	$Employee->card_number = $request->input('card_number');
        	$Employee->department_id = $request->input('department_id');
            $Employee->nUserID = $request->input('nUserID');
        	$Employee->salary = $request->input('salary');
/*
            $temp = new ConnectedUser();
            $temp->sUserName = $request->input('EmployeeName');
            $temp->nDepartmentIdn =0;
            $temp->sUserID = $request->input('card_number');
            $temp->sPassword;
            $temp->bPassword2;
            $temp->nStartDate = 946684800;
            $temp->nEndDate = 1924988400;
            $temp->nAdminLevel = 241;
            $temp->nAuthMode = 0;
            $temp->nAuthLimitCount = 0;
            $temp->nTimedAPB =0;
            $temp->nEncryption = 0;
            $temp->save();
*/

        	$Employee->save();

            $request['operation'] = 'Add Employee';
            $request['old_value'] = '-';
            $request['new_value'] = $Employee;
            LogController::create($request);

            $request->session()->put('success', 'Creation successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in create');
        }

    	return redirect()->action('EmployeeController@index');
    }

    public function update(Request $request)
    {
        try
        {
        	$Employee = Employee::find($request->input('EmployeeId'));

            $request['old_value'] =Employee::find($request->input('EmployeeId'));

        	$Employee->name = $request->input('editEmployeeName');
        	$Employee->phone = $request->input('editphone');
        	$Employee->card_number = $request->input('editcard_number');
        	$Employee->department_id = $request->input('editdepartment_id');
            $Employee->nUserID = $request->input('edit_nUserID');
        	$Employee->salary = $request->input('editsalary');
        	$Employee->save();

            $request['operation'] = 'Update Employee';
            $request['new_value'] = $Employee;
            LogController::create($request);

            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }

    	return redirect()->action('EmployeeController@index');
    }

    public function delete(Request $request,$id)
    {
        try
        {
        	$Employee = Employee::find($id);

            $request['old_value'] = $Employee;

            $Employee->delete();

            $request['operation'] = 'Delete Employee';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Delete successfull');
        
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }

    	return redirect()->action('EmployeeController@index');
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

        $output = shell_exec('BioStationManagement_CMD.exe search');
        $devices = str_replace("s", " ", explode(',', $output));

        $result = [];

        foreach ($devices as $device) {

            $temp = explode(':', $device);

            if(count($temp) > 1)
                $result[]= $temp;

        }

    	$Employee = Employee::with('department')->get();
    	$departments = Department::all();
    	$data = array( 'Employee' => $Employee , 'departments' => $departments,
    		 'Devices' => $result );
		JavaScript::put([
		'Employee' => $Employee,  'departments' => $departments
		]);
    	return view('Employee' , $data );
    }
}
