<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Wod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventDetailController extends Controller {
	public function getWodsForEvent (Request $request) {

		$wods = DB::table('wods')->select('wods.wodname', 'wods.woddesc', 'wods.event_id', 'wods.wodtype', 'settings.settingdesc')
		->join('settings', 'settings.id', '=', 'wods.wodtype')
		->where('event_id', $request->eventid)
		->get();

		return response()->json([
			'data' => $wods,
			'count' => sizeof($wods)
		]);

	}

	public function getAthletesForEvent () {
		var_dump('Nevan');
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

		// get wodtype name
		$wodtypename = DB::table('settings')->select('settingname', 'settingdesc')->where('id', $wod->wodtype)->first();

		$myWod = (object) [
			'wodname'		=>	$wod->wodname,
			'woddesc'		=>	$wod->woddesc,
			'wodtype'		=>	$wodtypename->settingdesc,
			'wodtype_id'	=>	$wod->wodtype,
			'event_id'		=>	$wod->event_id,
			'id'			=>	$wod->id
		];

		if ( $save ) {

			$wodData = [
				'wod' => $myWod
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
	
	public function addAthlete (Request $request) {

		$athlete_name		= $request->input('athlete_name');
		$athlete_surname	= $request->input('athlete_surname');
		$email				= $request->input('athlete_email');
		$cellphone			= $request->input('athlete_mobile');
		$athletetype		= $request->input('athlete_type');
		// $gender				= $request->input('gender');
		$eventid			= $request->input('event_id');

		$athlete = new Athlete();

		$athlete->Name 			= $athlete_name;
		$athlete->Surname 		= $athlete_surname;
		$athlete->cellphone 	= $cellphone;
		$athlete->email 		= $email;
		$athlete->athletetype 	= $athletetype;
		// $athlete->gender	 	= $gender;
		$athlete->event_id 		= $eventid;

		$save = $athlete->save();

		if ( $save ) {

			$athleteData = [
				'athlete' => $athlete
			];

			return response()->json([
				'code' => 1,
				'msg' => 'New Athlete/Team has been successfully created!',
				'data' => $athleteData
			]);

		} else {
			return response()->json([
				'code' => 0,
				'msg' => 'Something went wrong.',
				'data' => null
			]);

		}

	}

	public function wodDetails () {
		return view('wod.details');
	}

}