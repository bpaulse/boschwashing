$(document).ready(function(){

	console.log('leaderboards');

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

function getDivision(eventid, wodid) {
	$.ajax({
		type: 'GET',
		url: '/getAllDivisions',
		data: {eventid: eventid, wodid: wodid},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			// console.log(response);

			let eventData = response.eventData;

			console.log('eventData');
			console.log(eventData.data[5][0]);

			$.each(eventData.data, function(data1,gender){
				for (let i = 0; i < gender.length; i++) {

					if ( data1 == 0 ){
						$(".nav-tabs").append(tabHTML('active', gender[i]));
						$(".tab-content").append(contentHTML('in active', gender[i]));
					} else {
						$(".nav-tabs").append(tabHTML('', gender[i]));
						$(".tab-content").append(contentHTML('', gender[i]));
					}
				}
			});


			$.each(response.leaderboard, function(data1,mann){

				console.log(mann);

				// var elementId;

				var divId = '';

				$.each(mann, function(index,wodloaderboard){

					// divId = eventData.data[]


					console.log(index);
					var board = wodloaderboard[4][0];
					console.log('board');
					console.log(board);

					console.log('athletetype');
					console.log(board[0].athletetype);

					var num = 1;
					var rows;
					for ( var j = 0; j < board.length; j++ ){
						rows += '<tr><td>'+num+'</td><td>'+board[j].fullname+'</td><td>'+board[j].score+'</td></tr>';
						num = Number(num) + 1;
					}

					console.log(eventData.data[board[0].athletetype][0].id);

				});

				// var elementId = eventData.data[category][0].id;
				// console.log('elementId');
				// console.log(elementId);

				// var category = Object.keys(mann)[0];
				// $.each(mann, function(data1,leaderboard){

				// 	currLeaderboard = leaderboard[0];

				// 	let rows = '';
				// 	let num = 0;

				// 	for (let i = 0; i < currLeaderboard.length; i++) {

				// 		num = Number(i) + 1;
				// 		rows += '<tr><td>'+num+'</td><td>'+currLeaderboard[i].fullname+'</td><td>'+currLeaderboard[i].score+'</td></tr>';
				// 	}

				// 	let divId = eventData.data[category][0].id;

				// 	$("#"+divId).append(createTable(rows));
				// });

			});


		},
		error: function(e) {
			console.log(e);
		}
	});
}

function buildTabs (index, data, details) {


	if ( index == 'First') {

		$(".nav-tabs").append(tabHTML('active', data));
		$(".tab-content").append(contentHTML('in active', data));

		// $("#"+data.id).append(createTable(data));
		tableContent(details, data.id);

	} else {

		// $(".nav-tabs").append(tabHTML('', data));
		// $(".tab-content").append(contentHTML('', data));

		// $("#"+data.id).append(createTable(data));
		// console.log(data.id);

	}


	// populateLeaderboard(data.wodid);

	// $('.tab-content').append(createTableHeader(data));
	//populate table
	// $('.tab-content').append();

	return 0;
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