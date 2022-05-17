<?php

namespace App\Http\Controllers;

use App\Models\Athlete;
use App\Models\Wod;
use App\Models\AthleteEvent;
use App\Models\Score;
use App\Models\Setting;
use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventDetailController extends Controller {

	public function getWodsForEvent (Request $request) {

		$wods = DB::table('wods')->select('wods.id', 'wods.wodname', 'wods.woddesc', 'wods.event_id', 'wods.wodtype', 'settings.settingdesc', 'events.event_date')
		->join('settings', 'settings.id', '=', 'wods.wodtype')
		->join('events', 'events.id', '=', 'wods.event_id')
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
		$score = new Score();
		$score->athlete_id = $data['athlete_id'];
		$score->wod_id = $data['wod_id'];
		$save = $score->save();
		return $save;
	}

	public function insertAthleteEvents ($data) {
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

		$athlete = new Athlete();

		$athlete->Name 			= $athlete_name;
		$athlete->Surname 		= $athlete_surname;
		$athlete->cellphone 	= $cellphone;
		$athlete->email 		= $email;

		if ( $athlete->save() ) {

			$athleteEvent = new AthleteEvent();

			$athleteEvent->athlete_id	= $athlete->id;
			$athleteEvent->event_id		= $eventid;
			$athleteEvent->gender		= $this->getGenderId($gender);
			$athleteEvent->athletetype	= $athletetype;

			if ( $athleteEvent->save() ) {

				// get all the WODS for the event
				$wodIDS = $this->getWodsIDs($eventid);
				$saveScores = $this->multipleScoreEntries($wodIDS, $athlete->id);

				if ( $saveScores ) {

					$athleteData = [
						'athlete' => $athlete
					];

					return response()->json([
						'code' => 1,
						'msg' => 'New Athlete/Team has been successfully created!',
						'data' => $athleteData
					]);
				}
			}

		}

		return response()->json([
			'code' => 0,
			'msg' => 'Something went wrong.',
			'data' => null
		]);

	}

	public function multipleScoreEntries ($wodIDS, $athlete_id) {

		$length = sizeof($wodIDS);
		$counter = 0;

		foreach ( $wodIDS as $wod ) {
			// var_dump('wod_id');
			// var_dump($wod->id);
			$score = new Score();
			$score->score		= NULL;
			$score->wod_id		= $wod->id;
			$score->athlete_id	= $athlete_id;
			$score->save();
			$counter++;
		}

		if ( $length == $counter ) {
			return true;
		} else { 
			return false;
		}

	}

	public function wodDetails () {
		return view('wod.details');
	}

	public function getGenderId($str) {
		$idObj = DB::select('SELECT id FROM settings WHERE settingdesc = ?', [$str]);
		return $idObj[0]->id;
	}

	public function saveInputScoring (Request $request) {

		$whereClause = ['wod_id' => $request->input('wod_id'), 'athlete_id' => $request->input('athlete_id')];
		$update = Score::where($whereClause)->update(['score' => $request->input('score')]);
		$data = ['wod_id' => $request->input('wod_id'), 'athlete_id' => $request->input('athlete_id'), 'score' => $request->input('score')];
		return response()->json(['data' => $data, 'update' => $update]);

	}

	public function saveValueScoring(Request $request) {

		$score = $request->input('wodvalue');
		$type = $request->input('submittype');
		$athleteid = $request->input('athleteid');
		$wodid = $request->input('wodid');

		// update score
		$whereClause = ['wod_id' => $wodid, 'athlete_id' => $athleteid];
		$update = Score::where($whereClause)->update(['score' => $score]);

		$data = ['wod_id' => $wodid, 'athlete_id' => $athleteid, 'score' => $score];

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

	public function getWODDescAndSettings (Request $request) {

		$id = $request->input('wodid');
		$wod = Wod::select('*')->where('id', $id)->firstOrFail();
		$settings = $this->getSettingGroup('wod_type');
		return response()->json(['wod' => $wod, 'settings' => $settings]);

	}

	public function updateWod(Request $request) {

		$wod_id = $request->input('wod_id');
		$wod_name = $request->input('wod_name');
		$wod_desc = $request->input('wod_desc');
		$wod_type = $request->input('wod_type');
		$wod_type_name = $request->input('wod_type_name');

		$wodData = [
			'wodname' => $request->input('wod_name'),
			'woddesc' => $request->input('wod_desc'),
			'wodtype' => $request->input('wod_type')
		];

		$update = Wod::where('id', '=', $wod_id)->update($wodData);

		$wodData['wodtypename'] = $wod_type_name;

		$data = ['wod_id' => $wod_id, 'wodData' => $wodData, 'update' => $update];

		return response()->json($data);

	}

	public function getSettingGroup($settingDesc) {
		return Setting::select('*')->where('settingname', $settingDesc)->get();
	}

	public function getWODDesc (Request $request) {

		$id = $request->input('wodid');
		$wod = Wod::select('*')->where('id', $id)->firstOrFail();
		return response()->json($wod);

	}

	public function wodResults ($id) {

		// var_dump('event id');
		// var_dump($id);

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
			WHERE event_id = ?', 
			[$id]
		);

		$data = ['tabs' => $tabs];

		return view('wod.results')->with(['data' => $data]);

	}

	public function getAllDivisionsTest() {

		$eventid = 1;
		$wodid = 40;

		return response()->json($this->allDivisions($eventid, $wodid));

	}

	public function settings () {
		$settings = Setting::all();
		$output = [];
		foreach ( $settings as $setting ){
			$output[$setting->id] = $setting->settingdesc;
		}
		return $output;
	}

	public function getAllDivisions(Request $request) {

		$eventid = $request->input('eventid');
		$wodid = $request->input('wodid');

		$output = [];

		$settings = $this->settings();
		// var_dump($settings);

		$genderlist = $this->gender($eventid);
		foreach ( $genderlist as $key => $gender ) {
			$athleteType = $this->getAthleteTypeIDs ($gender, $eventid);
			foreach( $athleteType as $item ) {
				$output[$gender][$item->athletetype] = $settings[$gender] . $settings[$item->athletetype];
			}

		}

		return response()->json(['allDivisions' => $this->allDivisions($eventid, $wodid), 'overallLeaderBoard' => $output]);

	}



	private function allDivisions($eventid, $wodid){

		$divs = $this->divisionIDs($eventid, $wodid);
		$eventData = $this->tabsForDisplay($eventid, $wodid);
		return ['leaderboard' => $divs, 'eventData' => $eventData];

	}

	public function divisionIDs ($eventid, $wodid) {

		$output = [];

		$this->clearEventLeaderBoard($eventid);

		$wodids = $this->getWodsIDs ($eventid);
		foreach ( $wodids as $wod ) {
			$genders = $this->gender($eventid);
			foreach ( $genders as $gender ){
				$athletetypeIds = $this->getAthleteTypeIDs ($gender, $eventid);
				foreach($athletetypeIds as $athletetypeId){
					if ( $wod->wodtype == 2 ) {
						$output[$eventid][$wod->id][$gender][$athletetypeId->athletetype] = $this->leaderboardForTime(
							[
								'eventid'		=> $eventid, 
								'wodid'			=> $wod->id, 
								'gender'		=> $gender,
								'athletetype'	=> $athletetypeId->athletetype
							]
						);
					} else {
						$output[$eventid][$wod->id][$gender][$athletetypeId->athletetype] = $this->leaderboardOther(
							[
								'eventid'		=> $eventid,
								'wodid'			=> $wod->id, 
								'gender'		=> $gender,
								'athletetype'	=> $athletetypeId->athletetype
							]
						);
					}
				}
			}
		}

		return $output;

	}

	public function gender($event_id) {
		$gender = [];
		$athleteEvent = AthleteEvent::select('gender')->distinct('gender')->where('event_id', $event_id)->get();
		foreach ( $athleteEvent as $item ) {
			$gender[] = $item->gender;
		}
		return $gender;
	}

	private function getLeaderBoardData ($details) {

		$ids = $this->getWodsIDs($details['eventid']);

		$wodleaderboard = [];

		foreach ( $ids as $wodInfo ) {

			// var_dump($wodInfo);exit();

			$wod = Wod::select('*')->where('id', $wodInfo->id)->firstOrFail();

			if ( $wod->wodtype == 2 ) {

				$wodleaderboard[$wod->id][$details['cat']][] = $this->leaderboardForTime(
					[
						'eventid'		=> $details['eventid'], 
						'wodid'			=> $wodInfo->id, 
						'gender'		=> $details['gender'],
						'athletetype'	=> $details['cat']
					]
				);
			} else {

				$wodleaderboard[$wod->id][$details['cat']][] = $this->leaderboardOther(
					[
						'eventid' => $details['eventid'],
						'wodid' => $wodInfo->id, 
						'gender'		=> $details['gender'],
						'athletetype'	=> $details['cat']
					]
				);
			}

		}

		return $wodleaderboard;
	}

	public function getWodsIDs ($event_id) {
		$wodids = Wod::select('id', 'wodtype')->where('event_id', $event_id)->get();
		return $wodids;
	}

	public function getAthleteTypeIDs ($gender, $eventid) {
		$athletetypeIds = DB::select('SELECT DISTINCT athletetype FROM athlete_events  WHERE gender = ? and event_id = ?', [$gender, $eventid]);
		return $athletetypeIds;
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

	private function leaderboardOther($data) {

		$leaderboard = [];
		$sql = 'SELECT
			@i:=@i+1 AS position, 
			cast(sc.score as int) as score, 
			CONCAT(ath.Name, " ", ath.Surname) as AthleteName,
			sc.athlete_id
		FROM scores AS sc 
		INNER JOIN athlete_events ae on ae.athlete_id = sc.athlete_id 
		INNER JOIN (SELECT @i:=0) foo 
		INNER JOIN athletes ath on ath.id = ae.athlete_id 
		WHERE sc.wod_id = ? AND ae.gender = ? AND ae.athletetype = ?
		ORDER BY score DESC';

		// WHERE ae.event_id ? AND sc.wod_id = ? AND ae.gender = ? AND ae.athletetype = ?
		// $prepvars = [(int)$data['eventid'], (int)$data['wodid'], (int)$data['gender'], (int)$data['athletetype']];
		$prepvars = [(int)$data['wodid'], (int)$data['gender'], (int)$data['athletetype']];
		$leaderboard = DB::select($sql, $prepvars);

		if ( !empty($leaderboard) ) {
			$this->saveLeaderBoard($leaderboard, $data);
		}

		return $leaderboard;

	}

	public function getOverallStandings(Request $request) {

		$data = [
			'eventid'		=> $request->input('eventid'),
			'gender'		=> $request->input('gender'),
			'athletetype'	=> $request->input('athletetype')
		];

		// var_dump($data);

		return response()->json($this->overallStanding ($data));
	}

	public function overallStanding ($data) {

		$standing = [];

		$sql = 'SELECT 
				@i:=@i+1 AS position,
				lb.athlete_id,
				lb.athletename, 
				SUM(lb.points) as totalscore
			FROM leaderboards AS lb
			INNER JOIN athlete_events as ae ON ae.athlete_id = lb.athlete_id
			INNER JOIN (SELECT @i:=0) foo 
			WHERE lb.event_id = ? AND ae.gender = ? AND ae.athletetype = ?
			GROUP BY lb.athlete_id, lb.athletename
			ORDER BY totalscore';
		$prepvars = [(int)$data['eventid'], (int)$data['gender'], (int)$data['athletetype']];

		$standing = DB::select($sql, $prepvars);

		return $standing;

	}

	public function leaderboardForTime($data) {

		$leaderboard = [];

		$sql = 'SELECT 
				@i:=@i+1 AS position, 
				sc.score, 
				CONCAT(ath.Name, " ", ath.Surname) as AthleteName,
				sc.athlete_id
			FROM scores AS sc 
			INNER JOIN athlete_events ae on ae.athlete_id = sc.athlete_id 
			INNER JOIN (SELECT @i:=0) foo 
			INNER JOIN athletes ath on ath.id = ae.athlete_id 
			WHERE sc.wod_id = ? AND ae.gender = ? AND ae.athletetype = ? 
			ORDER BY sc.score ASC';


		// WHERE ae.event_id = ? AND sc.wod_id = ? AND ae.gender = ? AND ae.athletetype = ? 
		// $prepvars = [(int)$data['eventid'], (int)$data['wodid'], (int)$data['gender'], (int)$data['athletetype']];
		$prepvars = [(int)$data['wodid'], (int)$data['gender'], (int)$data['athletetype']];
		$leaderboard = DB::select($sql, $prepvars);

		if ( !empty($leaderboard) ) {

			$this->saveLeaderBoard($leaderboard, $data);

		}

		return $leaderboard;

	}

	public function saveLeaderBoard($leaderboard, $data) {

		foreach ( $leaderboard as $leaderboardAthlete ) {

			$leaderboardEntry = new Leaderboard();
			$leaderboardEntry->points		= ( is_null($leaderboardAthlete->score) ) ? 0: (int)$leaderboardAthlete->position;
			$leaderboardEntry->athletename	= $leaderboardAthlete->AthleteName;
			$leaderboardEntry->athlete_id	= $leaderboardAthlete->athlete_id;
			$leaderboardEntry->wod_id		= (int)$data['wodid'];
			$leaderboardEntry->event_id		= (int)$data['eventid'];
			$leaderboardEntry->score		= ( is_null($leaderboardAthlete->score) ) ? 0: (int)$leaderboardAthlete->score;
			$leaderboardEntry->save();

		}

		return 0;

	}

	public function clearEventLeaderBoard($eventid) {
		return Leaderboard::where('event_id', $eventid)->delete();
	}


}