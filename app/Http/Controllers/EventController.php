<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
	public function eventslist()
	{
		return view('events');
	}

	public function addEvent(Request $request)
	{

		$event_name				= $request->event_name;
		$event_desc				= $request->event_desc;
		$event_location			= $request->event_location;
		$event_date				= $request->event_date;

		$validator = Validator::make($request->all(), [
			'event_name'		=> 'required|max:255',
			'event_desc'		=> 'required|max:255',
			'event_location'	=> 'required',
			'event_date'		=> 'required'
		]);

		if ( !$validator->fails() ) {

			$event = new Event();

			$event->event_name		= $event_name;
			$event->event_desc		= $event_desc;
			$event->event_location	= $event_location;
			$event->event_date		= $event_date;
			$event->published		= 0;
			$event->user_id			= 1;

			$save = $event->save();

			if ( $save ) {

				$eventData = [
					'id' => $event->id,
					'name' => $event->event_name,
					'desc' => $event->event_desc,
					'loc' => $event->event_location,
					'date' => $event->event_date,
					'published' => $event->published,
					'user_id' => $event->user_id
				];

				return response()->json([
					'code' => 1,
					'msg' => 'New Event has been successfully created!',
					'data' => $eventData
				]);

			} else {

				return response()->json([
					'code' => 0,
					'msg' => 'Something went wrong.',
					'data' => null
				]);

			}

		} else {

			var_dump('failed');
			var_dump($validator->errors()->toArray());
		}

	}

	public function getEventsList() {
		$events = Event::all();
		return response()->json(['details' => $events]);
	}

	public function getEventName(Request $request) {
		$eventid = $request->eventid;
		$event = Event::find($eventid);
		return response()->json(['name' => $event->event_name]);
	}

	public function displayEventDetails($eventid) {
		return view('events.detail')->with(['eventid' => $eventid]);
	}

}
