<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Reader as Reader;
use App\Abscent as Abscent;
use App\Overtime as Overtime;
use App\Employee as Employee;
use App\Event_Log as Event_Log;

use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function syncDevice(Request $request, $ip)
    {
        try
        {
            $employees = Employee::all();

            foreach($employees as $employee)
            {
                $output = shell_exec('BioStationManagement_CMD.exe sync ' . $ip. ' ' . $employee->nUserID);
            }

            $request['operation'] = 'Change Background';
            $request['old_value'] = '-';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Upload successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in upload');
        }

        return redirect()->action('HomeController@showDevices');
    }

    public function uploadImage(Request $request)
    {
        try
        {
            $imageFullPath = public_path()."/uploads/".'icon.png';
            $img = Image::make($request->file('file')->move(public_path()."/uploads/", "icon" ))->resize(320,240);
            $img->save($imageFullPath);

            $output = shell_exec('BioStationManagement_CMD.exe setImage "' . $imageFullPath. '"');

            $request['operation'] = 'Change Background';
            $request['old_value'] = '-';
            $request['new_value'] = '-';
            LogController::create($request);

            $request->session()->put('success', 'Upload successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in upload');
        }

        return redirect()->action('HomeController@showDevices');
    }

    public function showDevices(Request $request)
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

        $data = array( 'Devices' => $result);
        return view('connectedDevices' , $data);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::all();
        $present = [];

        $current = new \DateTime('now');
        $next = new \DateTime('now');

        date_add($next, date_interval_create_from_date_string("1 days"));

        foreach($employees as $employee)
        {
            //where('nTNAEvent' , 0)->
            $event = Event_Log::where('nUserID' , $employee->nUserID)->where('nDateTime' , '>' , strtotime($current->format("Y-m-d")))->where('nDateTime' , '<' , strtotime($next->format("Y-m-d")))->orderBy('nDateTime', 'desc')->get();
            if(count($event) > 0 && $event[0]->nTNAEvent == 0)
                $present=[$employee];

        }
        
        $output = shell_exec('BioStationManagement_CMD.exe search');
        $devices = explode(',', $output);

        $numDev = count($devices) - 1;

        $numAbs = count(Abscent::where('approved' , false)->get());

        $numOve = count(Overtime::where('approved' , false)->get());
        $numEmp = count($present);
        $data = array( 'numDev' => $numDev, 'numAbs' => $numAbs, 'numOve' => $numOve, 'numEmp'=> $numEmp);
        return view('home' , $data);
    }
}
