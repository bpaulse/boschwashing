<?php

namespace App\Http\Controllers;

use App\Models\Wod;
use Illuminate\Http\Request;

class EventDetailController extends Controller {
	public function getWodsForEvent (Request $request) {
		var_dump('getWodsForEvent');
		var_dump($request->eventid);
	}
	
	public function addWod (Request $request) {

		$wodname = $request->input('wod_name');;
		$woddesc = $request->input('wod_desc');;
		$wodtype = $request->input('wod_type');;
		$eventid = $request->input('event_id');;

		$wod = new Wod();

		$wod->wodname = $wodname;
		$wod->woddesc = $woddesc;
		$wod->wodtype = $wodtype;
		$wod->event_id = $eventid;

		$save = $wod->save();

		if ( $save ) {

			$wodData = [
				'wod' => $wod
			];

			return response()->json([
				'code' => 1,
				'msg' => 'New WOD has been successfully created!',
				'data' => $wodData
			]);

		} else {
			return response()->json([
				'code' => 0,
				'msg' => 'Something went wrong.',
				'data' => null
			]);

		}

	}
}