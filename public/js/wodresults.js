$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	var chunks = window.location.href.split('/');
	var eventid = chunks[chunks.length-2];
	var wodid = chunks[chunks.length-1];

	// add li tabs
	populateUL(eventid, wodid);

	$(document).on('click', '.backWodList', function(evt){
		window.location.href = '/displayEventDetails/' + eventid;
	});

});

function populateUL(eventid, wodid) {

	getDivision(eventid, wodid);

}

function BuildInitialTabs (data) {
	var counter = 0;
	$.each(data, function(data1,gender){
		for (let i = 0; i < gender.length; i++) {
			if ( counter == 0 ){
				$(".nav-tabs").append(tabHTML('active', gender[i]));
				$(".tab-content").append(contentHTML('in active', gender[i]));
			} else {
				$(".nav-tabs").append(tabHTML('', gender[i]));
				$(".tab-content").append(contentHTML('', gender[i]));
			}
			counter++;
		}
	});
}

function getDivision(eventid, wodid) {

	$.ajax({
		type: 'GET',
		url: '/getAllDivisions',
		data: {eventid: eventid, wodid: wodid},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			let eventData = response.eventData;
			BuildInitialTabs(eventData.data);
			buildLeaderBoards(response);

		},
		error: function(e) {
			console.log(e);
		}
	});

}

function buildLeaderBoards(response) {

	var data = response.leaderboard;
	var wods = data[response.eventData.static.eventid];

	console.log(response.eventData)

	var divId;

	$.each(wods, function(wodid,wod){
		$.each(wod, function(gender,athletetypeArray){
			$.each(athletetypeArray, function(athletetype, participants){
				let row = '';
				for ( var j = 0; j < participants.length; j++ ) {
					row += singleRow(Number(j) + 1, participants[j]);
				}
				divId = response.eventData.data[athletetype][0].id;
				$('#' + divId).append(createTable(row));

			});
		});
	});

	addOverallLeaderBoard(1, 13, 5, 'TeamsIntermediate');
	addOverallLeaderBoard(1, 13, 4, 'TeamsRX');

}

function addOverallLeaderBoard (eventid, gender, athletetype, divId) {

	var ajaxData = {
		eventid: eventid,
		gender: gender, 
		athletetype: athletetype, 
		divId: divId
	};

	$.ajax({
		type: 'GET',
		url: '/getOverallStandings',
		data: ajaxData,
		dataType: 'json',
		success: function (response) {

			var rows = '';

			$.each(response, function(index,data){
				rows += singleRowOverall(index, data);
			});

			$('#' + divId).append(createTable(rows));

		},
		error: function(e) {
			console.log(e);
		}
	});

}

function singleRow(index, board) {
	return '<tr><td>'+index+'</td><td>'+board.AthleteName+'</td><td>'+board.score+'</td></tr>';
}

function singleRowOverall(index, board) {
	var num = Number(index)+1;
	return '<tr><td>'+num+'</td><td>'+board.athletename+'</td><td>'+board.totalscore+'</td></tr>';
}

function tabHTML(classStr, data){
	let html = '<li class="'+classStr+'"><a data-toggle="tab" href="#'+data.id+'">'+data.name+'</a></li>';
	return html;
}

function contentHTML(classStr, data){
	let html = '<div id="'+data.id+'" class="tab-pane fade '+classStr+'"><h3>'+data.name+'</h3></div>';
	return html;
}

function createTable (tablecontent) {
	return '<div style="float: left; padding: 10px;"><table style="border: 1px solid black; width: 120px; font-size: 8pt;">'+TableHeader()+tablecontent+'</table></div>';
}

function TableHeader () {
	return '<tr><td>#</td><td>Name</td><td>Score</td></tr>';
}

function populateLeaderboard(wodid) {
	console.log('--wodid--');
	console.log(wodid);
}