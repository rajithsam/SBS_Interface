<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Log as Log;
use JavaScript;

class LogController extends Controller
{
    public static function create(Request $request)
    {
    	$Log = new Log();
    	$Log->user_id = $request->user()->id;
    	$Log->ip = $request->ip();
    	$Log->operation = $request->input('operation');
    	$Log->old_value = $request->input('old_value');
    	$Log->new_value = $request->input('new_value');
    	$Log->save();
    }

    public function index()
    {
    	$Log = Log::with('user')->get();
    	$data = array( 'Log' => $Log);
    	return view('Log' , $data );
    }
}
