<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Wod;
use App\Models\AthleteEvent;
use App\Models\Score;
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
		$wodid =  $request->input('wodid');

		$athletes = DB::select("SELECT 
				ath_evt.id, 
				ath_evt.athlete_id, 
				ath_evt.event_id, 
				scr.wod_id, 
				ath.Name,
				ath.Surname,
				ath.email,
				gen.settingdesc as 'gender',
				athtype.settingdesc as 'athleteDivision',
				scr.score
			FROM `athlete_events` as ath_evt 
			INNER JOIN athletes AS ath ON ath.id = ath_evt.athlete_id
			INNER JOIN settings AS gen ON gen.id = ath_evt.gender
			INNER JOIN settings as athtype ON ath_evt.athletetype = athtype.id
			LEFT JOIN scores as scr ON scr.athlete_id = ath.id
			WHERE ath_evt.event_id = ? AND scr.wod_id = ?
			ORDER BY gen.id, athtype.id", [$eventid, $wodid]	
		);

		return response()->json($athletes);
	}
	
	
	public function searchAthlete (Request $request) {

		$eventid = $request->input('eventid');
		$wodid = $request->input('wodid');
		$searchterm = $request->input('searchterm');

		$athletes = DB::select("
			SELECT 
				ath_evt.id, 
				ath_evt.athlete_id, 
				ath_evt.event_id,
				scr.wod_id, 
				ath.Name,
				ath.Surname,
				ath.email,
				ath.cellphone,
				gen.settingdesc as 'gender',
				athtype.settingdesc as 'athleteDivision',
				scr.score
			FROM `athlete_events` as ath_evt 
			INNER JOIN athletes AS ath ON ath.id = ath_evt.athlete_id
			INNER JOIN settings AS gen ON gen.id = ath_evt.gender
			INNER JOIN settings as athtype ON ath_evt.athletetype = athtype.id
			LEFT JOIN scores as scr ON scr.athlete_id = ath.id
			WHERE ath_evt.event_id = ? AND scr.wod_id = ? AND (ath.Name LIKE ? OR ath.Surname LIKE ? OR gen.settingdesc LIKE ? OR athtype.settingdesc LIKE ? OR ath.email LIKE ? OR ath.cellphone LIKE ?) 
			ORDER BY gen.id, athtype.id", [$eventid, $wodid, '%'.$searchterm.'%', '%'.$searchterm.'%', '%'.$searchterm.'%', '%'.$searchterm.'%'
		]);

		$response = ['data' => $athletes];
		
		return response()->json($response);
	}

	public function insertScores ($data) {
		// return "INSERT INTO `scores` (`id`, `score`, `athlete_id`, `wod_id`, `created_at`, `updated_at`) VALUES (NULL, NULL, '14', '40', NULL, NULL), (NULL, NULL, '21', '40', NULL, NULL);";
		$score = new Score();
		$score->athlete_id = $data['athlete_id'];
		$score->wod_id = $data['wod_id'];
		$save = $score->save();
		return $save;
	}

	public function insertAthleteEvents ($data) {
		// return "INSERT INTO `athlete_events` (`athlete_id`, `event_id`) VALUES ('23', '1')";
		$athleteEvent = new AthleteEvent();
		$athleteEvent->athlete_id = $data['athlete_id'];
		$athleteEvent->event_id = $data['event_id'];
		$save = $athleteEvent->save();
		return $save;
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
	}

	public function saveInputScoring (Request $request) {

		$whereClause = ['wod_id' => $request->input('wod_id'), 'athlete_id' => $request->input('athlete_id')];
		$update = Score::where($whereClause)->update(['score' => $request->input('score')]);
		$data = ['wod_id' => $request->input('wod_id'), 'athlete_id' => $request->input('athlete_id'), 'score' => $request->input('score')];
		return response()->json(['data' => $data, 'update' => $update]);

	}

	public function populateScoringInputForm (Request $request) {

		$wodid = $request->input('wod_id');
		$athleteid = $request->input('athlete_id');
		$eventid = $request->input('event_id');

		$athInfo = DB::select('SELECT 
				ath.Name,
				ath.Surname,
				ath.cellphone,
				ath.email,
				wd.wodname,
				wd.woddesc,
				wd.wodtype,
				sett.settingdesc,
				scr.score,
				ath.id AS athlete_id,
				wd.id AS wod_id
			FROM 
				athlete_events AS atheve
			INNER JOIN 
				athletes AS ath
			ON 
				ath.id = atheve.athlete_id
			INNER JOIN 
				wods AS wd
			ON 
				wd.event_id = atheve.event_id
			INNER JOIN 
				settings AS sett
			ON 
				sett.id = wd.wodtype
			INNER JOIN 
				scores AS scr
			ON 
				scr.athlete_id = ath.id AND scr.wod_id = wd.id
			WHERE
				atheve.event_id = ?
			AND
				wd.id = ?
			AND
				ath.id = ?', 
			[$eventid, $wodid, $athleteid]
		);

		// var_dump($athInfo);

		return response()->json($athInfo);
	}

	public function getWODDesc (Request $request) {

		$id = $request->input('wodid');
		$wod = Wod::select('*')->where('id', $id)->firstOrFail();
		return response()->json($wod);

	}

	public function gender($event_id) {
		$gender = [];
		$athleteEvent = AthleteEvent::select('gender')->distinct('gender')->where('event_id', $event_id)->get();
		foreach ( $athleteEvent as $item ) {
			$gender[] = $item->gender;
		}
		return $gender;
	}


	public function divisionIDs ($eventid) {

		$output = [];

		$genders = $this->gender($eventid);

		foreach ( $genders as $gender ){
			$athletetype = DB::select('SELECT DISTINCT athletetype FROM athlete_events  WHERE gender = ?', [$gender]);
			foreach($athletetype as $type){
				$output[$gender][] = $type->athletetype;
			}
		}

		return $output;

		// $output = DB::select('SELECT DISTINCT athletetype FROM athlete_events  WHERE gender = ?', [$eventid]); 
		// $items = DB::select('SELECT DISTINCT athletetype FROM athlete_events  WHERE gender IN (SELECT DISTINCT gender FROM athlete_events WHERE event_id = ?)', [$eventid]);

	}

	public function getAllDivisions(Request $request) {

		$eventid = $request->input('eventid');
		$wodid = $request->input('wodid');
		$divs = $this->divisionIDs($eventid);

		$leaderboard = [];
		
		foreach ( $divs as $gender=>$div ) {
			foreach ( $div as $cat ) {
				$data = [
					'eventid' => $eventid,
					'wodid' => $wodid,
					'gender' => $gender,
					'cat' => $cat
				];
				$leaderboard[] = $this->getLeaderBoardData($data);
			}
		}

		$eventData = $this->tabsForDisplay($eventid, $wodid);

		return response()->json(['leaderboard' => $leaderboard, 'eventData' => $eventData]);

	}

	private function getLeaderBoardData ($details) {

		$ids = $this->getWodsIDs($details['eventid']);

		$wodleaderboard = [];

		foreach ( $ids as $wodInfo ) {

			$wod = Wod::select('*')->where('id', $wodInfo->id)->firstOrFail();

			if ( $wod->wodtype == 2 ) {

				// $wodleaderboard[$wodInfo->id][] = $this->leaderboardForTime(
				$wodleaderboard[$details['cat']][] = $this->leaderboardForTime(
					[
						'eventid'		=> $details['eventid'], 
						'wodid'			=> $wodInfo->id, 
						'gender'		=> $details['gender'],
						'athletetype'	=> $details['cat']
					]
				);

			} else {

				// $wodleaderboard[$wodInfo->id][] = $this->leaderboardOther(['eventid' => $details['eventid'], 'wodid' => $wodInfo->id]);

			}

		}

		return $wodleaderboard;
	}


	public function tabsForDisplay($eventid, $wodid) {

		$divisions = DB::select('SELECT 
				DISTINCT athletetype, st.settingdesc 
			FROM 
				athlete_events AS ae 
			INNER JOIN 
				settings AS st
			ON 
				st.id = ae.athletetype
			WHERE 
				ae.event_id = ?;',
			[$eventid]
		);

		$categories = DB::select('SELECT 
				DISTINCT gender, st.settingdesc
			FROM 
				athlete_events AS ae 
			INNER JOIN 
				settings AS st
			ON 
				st.id = ae.gender
			WHERE 
				ae.event_id = ?;',
			[$eventid]
		);

		$alldivisions = [];

		foreach ( $categories as $category ) {
			foreach ( $divisions as $division ) {
				$alldivisions[$division->athletetype][] = [
					'id' => $category->settingdesc . $division->settingdesc,
					'name' => $category->settingdesc . ' - ' . $division->settingdesc,
					'dvId' => $division->athletetype
				];
			}
		}

		$output = ['data' => $alldivisions, 'static' => ['wodid' => $wodid,'eventid' => $eventid]];

		return $output;

	}

	public function getWodsIDs ($event_id) {
		//
		$wodids = Wod::select('id')->where('event_id', $event_id)->get();
		return $wodids;
	}

	public function getLeaderBoardData1 (Request $request) {

		$details = $request->input('details');
		$ids = $this->getWodsIDs($details['eventid']);

		foreach ( $ids as $wodInfo ) {

			$wod = Wod::select('*')->where('id', $wodInfo->id)->firstOrFail();

			if ( $wod->wodtype == 2 ) {

				$wodleaderboard[$wodInfo->id][] = $this->leaderboardForTime(['eventid' => $details['eventid'], 'wodid' => $wodInfo->id]);

			} else {

				// $wodleaderboard[$wodInfo->id][] = $this->leaderboardOther(['eventid' => $details['eventid'], 'wodid' => $wodInfo->id]);

			}

		}

		// var_dump($wodleaderboard);

		return $wodleaderboard;

	}

	private function leaderboardOther($data) {

		$leaderboard = [];
		$sql = 'SELECT
			CONCAT(ath.Name, " ", ath.Surname) as fullname,
			sc.athlete_id,
			sc.wod_id,
			athev.event_id,
			sc.score
		FROM scores as sc
		inner join athletes as ath on ath.id = sc.athlete_id
		INNER JOIN athlete_events AS athev ON athev.athlete_id = sc.athlete_id
		WHERE athev.event_id = ? AND sc.wod_id = ?
		ORDER BY sc.score DESC';

		$prepvars = [(int)$data['eventid'], (int)$data['wodid']];

		$leaderboard = DB::select($sql, $prepvars);

		return $leaderboard;

	}

	public function leaderboardForTime($data) {

		$leaderboard = [];

		$sql = 'SELECT
			CONCAT(ath.Name, " ", ath.Surname) as fullname,
			sc.athlete_id,
			sc.wod_id,
			athev.event_id,
			sc.score
		FROM scores as sc
		inner join athletes as ath on ath.id = sc.athlete_id
		INNER JOIN athlete_events AS athev ON athev.athlete_id = sc.athlete_id
		WHERE athev.event_id = ? AND sc.wod_id = ? AND athev.athletetype = ? AND athev.gender = ?
		ORDER BY sc.score ASC';

		$prepvars = [(int)$data['eventid'], (int)$data['wodid'], (int)$data['athletetype'], (int)$data['gender']];

		$leaderboard = DB::select($sql, $prepvars);

		// var_dump('leaderboard');
		// var_dump((int)$data['athletetype'], (int)$data['gender']);
		// var_dump($leaderboard);
		// var_dump('______________________________________________________________________________________________');


		return $leaderboard;

	}

	public function wodResults ($id) {

		// $tabs = DB::select('SELECT 
		// 		settings.id, 
		// 		settings.settingdesc 
		// 	FROM 
		// 		athletes 
		// 	INNER JOIN 
		// 		settings 
		// 	ON 
		// 		athletes.athletetype = settings.id 
		// 	WHERE athletes.event_id = ? 
		// 	GROUP BY settings.settingdesc, settings.id', 
		// 	[$id]
		// );

		$tabs = DB::select('SELECT 
			* 
		FROM 
			athlete_events
		WHERE event_id = 1', 
		[]
	);



		$data = ['tabs' => $tabs];

		return view('wod.results')->with(['data' => $data]);

	}

}