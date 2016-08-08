<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Department as Department;
use JavaScript;

class DepartmentController extends Controller
{
    public function create(Request $request)
    {
        try
        {
        	$department = new Department();
        	$department->name = $request->input('DepartmentName');
        	$department->save();

            $request['operation'] = 'Add Department';
            $request['old_value'] = '-';
            $request['new_value'] = $department;
            LogController::create($request);

            $request->session()->put('success', 'Creation successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in creation');
        }

    	return redirect()->action('DepartmentController@index');
    }

    public function update(Request $request)
    {
        try
        {
        	$department = Department::find($request->input('DepartmentId'));
     
            $request['old_value'] = Department::find($request->input('DepartmentId'));
     
        	$department->name = $request->input('editDepartmentName');
        	$department->save();

            $request['operation'] = 'Update Department';
            $request['new_value'] = $department;
            LogController::create($request);

            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }

    	return redirect()->action('DepartmentController@index');
    }

    public function delete(Request $request, $id)
    {
        try
        {
        	$department = Department::find($id);

            $request['old_value'] = $department;

            $department->delete();

            $request['operation'] = 'Delete Department';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Delete successfull');
    	
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }

        return redirect()->action('DepartmentController@index');
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

    	$department = Department::all();
    	$data = array( 'Department' => $department
    		);
		JavaScript::put([
		'Department' => $department
		]);
    	return view('department' , $data );
    }
}
