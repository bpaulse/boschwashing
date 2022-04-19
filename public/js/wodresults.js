$(document).ready(function(){

	console.log('leaderboards');

	toastr.options.preventDuplicates = false;

	var chunks = window.location.href.split('/');
	var eventid = chunks[chunks.length-2];
	var wodid = chunks[chunks.length-1];

	// console.log('wodid');
	// console.log(wodid);

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

			let divDetails = response.static;

			$.each(response.data, function(data1,division){

				if ( data1 == 0 ) {
					buildTabs('First', division, divDetails);
				} else {
					buildTabs('Other', division, divDetails);
				}

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
	return '<div style="float: left; padding: 10px;"><table style="border: 1px solid black; width: 120px; font-size: 8pt;">'+tablecontent+'</table></div>';
}

function tableContent(details, id) {

	$.ajax({
		type: 'GET',
		url: '/getLeaderBoardData',
		data: {details: details},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			console.log('TABLECONTENT');
			// console.log(response);

			let divisionData = ''; 
			let table = '';
			$.each(response, function(data1,leaderboard){

				let rows = TableHeader();

				$.each(leaderboard, function(data1,event){

					let num = 0;
					for (var i in event) {
						num = Number(i) + Number(1);
						rows += '<tr><td>'+num+'</td><td>'+event[i].fullname+'</td><td>'+event[i].score+'</td></tr>';
					}

				});

				divisionData += createTable(rows); 

			});

			console.log(divisionData);
			$("#"+id).append(divisionData);

		},
		error: function(e) {
			console.log(e);
		}
	});
}

function TableHeader () {
	return '<tr><td>#</td><td>Name</td><td>Score</td></tr>';
}

function populateLeaderboard(wodid) {
	console.log('--wodid--');
	console.log(wodid);
}