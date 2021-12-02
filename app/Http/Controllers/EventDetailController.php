<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Wod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventDetailController extends Controller {

	public function getWodsForEvent (Request $request) {

		$wods = DB::table('wods')->select('wods.id', 'wods.wodname', 'wods.woddesc', 'wods.event_id', 'wods.wodtype', 'settings.settingdesc')
		->join('settings', 'settings.id', '=', 'wods.wodtype')
		->where('event_id', $request->eventid)
		->get();

		return response()->json([
			'data' => $wods,
			'count' => sizeof($wods)
		]);

	}

	public function getAthletesForEvent (Request $request) {
		$eventid = $request->input('eventid');
		$athletes = DB::select("SELECT ath.id, ath.Name, ath.Surname, ath.email, gen.settingdesc as 'gender', athtype.settingdesc as 'athleteDivision', eve.event_name FROM `athletes` as ath INNER JOIN settings as gen ON ath.gender = gen.id INNER JOIN settings as athtype ON ath.athletetype = athtype.id INNER JOIN events as eve ON ath.event_id = eve.id WHERE ath.event_id = ? ORDER BY gen.id, athtype.id", [$eventid]);
		return response()->json($athletes);
	}
	
	public function searchAthlete (Request $request) {
		$eventid = $request->input('eventid');
		$searchterm = $request->input('searchterm');
		var_dump($eventid, $searchterm);
		$athletes = DB::select("
			SELECT 
				ath.id, 
				ath.Name, 
				ath.Surname, 
				ath.email, 
				gen.settingdesc as 'gender', 
				athtype.settingdesc as 'athleteDivision', 
				eve.event_name FROM `athletes` as ath 
			INNER JOIN 	
				settings as gen 
			ON 
				ath.gender = gen.id 
			INNER JOIN 
				settings as athtype 
			ON 
				ath.athletetype = athtype.id 
			INNER JOIN 
				events as eve 
			ON 
				ath.event_id = eve.id 
			WHERE ath.event_id = ? 
			AND (ath.Name LIKE ?) 
			ORDER 
				BY gen.id, athtype.id", [$eventid, '%'.$searchterm.'%']);
		// $athletes = DB::select("SELECT ath.id, ath.Name, ath.Surname, ath.email, gen.settingdesc as 'gender', athtype.settingdesc as 'athleteDivision', eve.event_name FROM `athletes` as ath INNER JOIN settings as gen ON ath.gender = gen.id INNER JOIN settings as athtype ON ath.athletetype = athtype.id INNER JOIN events as eve ON ath.event_id = eve.id WHERE ath.event_id = ? AND ( ath.Name OR ath.Surname OR ath.email) ORDER BY gen.id, athtype.id", [$eventid, ]);
		return response()->json($athletes);
	}

	public function addWod (Request $request) {

		$wodname = $request->input('wod_name');
		$woddesc = $request->input('wod_desc');
		$wodtype = $request->input('wod_type');
		$eventid = $request->input('event_id');

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
			// 'wod_id'		=>	$wod->wod_id,
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

		$athlete_name			= $request->input('athlete_name');
		$athlete_surname		= $request->input('athlete_surname');
		$email					= $request->input('athlete_email');
		$cellphone				= $request->input('athlete_mobile');
		$athletetype			= $request->input('athlete_type');
		$gender					= $request->input('gender');
		$eventid				= $request->input('event_id');
		// $wodid					= $request->input('wod_id');

		$athlete = new Athlete();

		$athlete->Name 			= $athlete_name;
		$athlete->Surname 		= $athlete_surname;
		$athlete->cellphone 	= $cellphone;
		$athlete->email 		= $email;
		$athlete->athletetype 	= $athletetype;
		$athlete->gender	 	= $gender;
		$athlete->event_id 		= $eventid;
		// $athlete->wod_id 		= $wodid;

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
		// return view('wod.details')->with(['eventid' => $eventid]);
	}

	public function getWODDesc (Request $request) {

		$wodid = $request->input('wodid');

		// var_dump('wodid: ');
		// var_dump($wodid);

		$wod = Wod::select('*');

		return response()->json($wod);

	}

	public function wodResults ($id) {

		$tabs = DB::select('SELECT settings.id, settings.settingdesc FROM athletes INNER JOIN settings ON athletes.athletetype = settings.id WHERE athletes.event_id = ? GROUP BY settings.settingdesc, settings.id', [$id]);



		$data = ['tabs' => $tabs];

		return view('wod.results')->with(['data' => $data]);

	}

}