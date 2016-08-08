<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event as Event;

use JavaScript;


class CalendarController extends Controller
{
	public function createEvent(Request $request)
	{
		try
		{
			$isFullDay = $request->input('FullDay');

			$event = new Event();
			$event->title = $request->input('createEventName');
			$event->start = $request->input("startDateV");
			$event->end = $request->input("endDateV");
			if($isFullDay)
				$event->fullDay = $isFullDay;
			else
				$event->fullDay = false;

			$event->save();

			$request['operation'] = 'Add Event';
	        $request['old_value'] = '-';
	        $request['new_value'] = $event;
	        LogController::create($request);
            $request->session()->put('success', 'Creation successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in creation');
        }

		return redirect()->action('CalendarController@view');
	}

	public function updateEvent(Request $request)
	{
		try
		{

			$isFullDay = $request->input('eventFullDay');

			$event = Event::find($request->input("eventUpdatetId"));

			$request['old_value'] = Event::find($request->input("eventUpdatetId"));

			$event->title = $request->input('eventName');
			$event->start = $request->input("startDateValue");
			$event->end = $request->input("endDateValue");
			if($isFullDay)
				$event->fullDay = $isFullDay;
			else
				$event->fullDay = false;

			$event->save();

	        $request['operation'] = 'Update Event';
	        $request['new_value'] = $event;
	        LogController::create($request);


            $request->session()->put('success', 'Update successfull');
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in update');
        }
		return redirect()->action('CalendarController@view');

	}

	public function deleteEvent(Request $request)
	{
		try
		{
			$event = Event::find($request->input("eventDeleteId"));

			$request['old_value'] = $event;
			
			$event->delete();

	        $request['operation'] = 'Delete Event';
	        $request['new_value'] = '-';
	        LogController::create($request);

	        $request->session()->put('success', 'Delete successfull');
    	
        }
        catch(\Exception $e)
        {
            $request->session()->put('error', 'Error in delete');
        }

		return redirect()->action('CalendarController@view');
	}

    public function view(Request $request, $EventId=-1)
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

    	$storedEvents = Event::all();

    	$events = [];

    	foreach ($storedEvents as $event) 
    	{
    		$events[] = \Calendar::event(
		    $event->title, //event title
		    $event->fullDay, //full day event?
		    new \DateTime($event->start), //start time (you can also use Carbon instead of DateTime)
		    new \DateTime($event->end), //end time (you can also use Carbon instead of DateTime)
		    $event->id, //optionally, you can specify an event ID
		        [
	                'url' => '/Calendar/view/'. $event->id . '#myModal'
                ]
			);
    	}


		#$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event

		$calendar = \Calendar::addEvents($events); //add an array with addEvents
		/*
		    ->addEvent($eloquentEvent, [ //set custom color fo this event
		        'color' => '#800',
		    ])->setOptions([ //set fullcalendar options
		        'firstDay' => 1
		    ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
		        'viewRender' => 'function() {alert("Callbacks!");}'
		    ]);
		    */ 

		if($EventId >= 0)
			JavaScript::put(["events" => Event::find($EventId)]);
		return view('calendar', compact('calendar'));

    }
}
