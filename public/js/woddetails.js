$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	// var eventid = window.location.href.split('/').pop();
	var chunks = window.location.href.split('/');

	// console.log(chunks.length);
	var wodid = chunks[chunks.length-1];
	var eventid = chunks[chunks.length-2];

	console.log('wodid');
	console.log(wodid);

	loadAthletes(eventid);

	$(document).on('click', '.backEventDetails', function(evt){
		console.log('backeventdetails');
		// window.location.href = '/wodDetails/' + eventid + '/' + wodid;
		window.location.href = '/displayEventDetails/' + eventid;
	});

	$(document).on('click', '.insertScores', function(evt){
		console.log('enter wod scores');
		$('#wodScoreModal').modal('show');

		// set wodid on modal
		console.log(wodid);
		$('#wod_id').val(wodid);

		var woddesc = getWODDesc(wodid);

		console.log(woddesc);

		$('#woddescinfo').html(woddesc);

	});

	$("#athlete_search").keyup(function() {

		var event_id = 1;

		var dInput = $(this).val();
		console.log(dInput);

		$.ajax({
			type: 'GET',
			url: '/searchAthlete',
			data: { eventid: event_id, searchterm: dInput},
			dataType: 'json',
			contentType: false,
			sucess: function(response) {
				console.log(response);
			}
		})

	});

	/*
	$(document).on('submit', '#add-wod-form', function(evt){

		evt.preventDefault();
		var doAjax = true;

		if ( doAjax ) {

			var form = this;

			let ajaxData = {
				wod_name: $('#wod_name').val(),
				wod_type: $('#wod_type').val(),
				wod_desc: $('#wod_desc').val(),
				event_id: $('#event_id').val(),
			};

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: ajaxData,

				success: function (response) {

					var type = '';

					if ( response.code === 0 ) {
						// $.each(response.error, function(prefix, val){
						// 	$(form).find('span.'+prefix+'_error').text(val[0]);
						// });
					} else {

						$(form)[0].reset();

						$('#addEventModal').modal('hide');

						toastr.success(response.msg);
						var event = response.data;

						var row = wodRow(
							{
								'id': event.wod.id, 
								'wodname': event.wod.wodname, 
								'woddesc': event.wod.woddesc, 
								'wodtype': event.wod.wodtype_id, 
								'settingdesc': event.wod.wodtype
							},
							type
						);

						$('#nodata').remove();
					}

				},
				error: function(xhr, ajaxOptions, thrownError) { console.log(xhr.responseText); }
			});

		}

	});
	*/

	/*
	$(document).on('submit', '#add-athlete-form', function(evt){

		evt.preventDefault();
		// console.log('add-athlete-form - BEVAN');

		var doAjax = true;

		console.log(doAjax);

		//get value from dropdown
		var athlete_type = $('#athlete_type option:selected').val();

		// console.log('athlete_type');
		// console.log(athlete_type);

		if ( doAjax ) {

			var form = this;

			let ajaxData = {
				athlete_name:		$('#athlete_name').val(),
				athlete_surname:	$('#athlete_surname').val(),
				athlete_mobile:		$('#athlete_mobile').val(),
				athlete_email:		$('#athlete_email').val(),
				athlete_type:		athlete_type,
				event_id:			$('#event_id').val(),
			};

			// console.log(ajaxData);

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: ajaxData,
				// beforeSend: function() {
						// $(form).find('span.error-text').text('');
				// },
				success: function (response) {

					console.log(response);

					if ( response.code === 0 ) {
						// $.each(response.error, function(prefix, val){
						// 	$(form).find('span.'+prefix+'_error').text(val[0]);
						// });
					} else {

						console.log('success');
						$('#addAthleteModal').modal('hide');

						$(form)[0].reset();
						toastr.success(response.msg);

						console.log(response.data);

						var athlete = response.data;
						console.log(athlete);

						// var row = eventRow({'id': event.id, 'event_name': event.name, 'event_desc': event.desc, 'event_loc': event.loc});
						// $('#eventsData').append(row);
					}

				},
				error: function(xhr, ajaxOptions, thrownError) { console.log(xhr.responseText); }
			});


		} else {
			console.log('Skip Ajax Request');
		}

	});
	*/

	/*
	$(document).on('click', '.wodDetails', function(evt) {
		console.log('wodDetails');
		// var event_id = $(this).closest('tr').attr("data-id");
		window.location.href = '/wodDetails';
	});
	*/

});

function getWODDesc(wodid) {
	console.log(wodid);

	$.ajax({
		type: 'GET',
		url: '/getWODDesc',
		data: {wodid: wodid},
		dataType: 'json',
		contentType: false,
		sucess: function(response) {
			console.log(response);
		}
	})
}

function loadAthletes(eventid) {

	console.log('loadAthletes');

	$.ajax({
		type: 'GET',
		url: '/getAthletesForEvent',
		data: {eventid: eventid},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			console.log(response);

			var output = '';
			// if ( response.count === 0 ) {
			// 	output = athleteRowNoData();
			// } else {
			$.each(response, function(data1,data2){
				var row = athleteRow({'id': data2.id, 'name': data2.Name + ' ' + data2.Surname, 'category': data2.athleteDivision, 'gender': data2.gender});
				output += row;
			});
			// }

			$('#athleteData').html(output);
		},
		error: function(e) {
			console.log(e);
		}
	});

}


function athleteRow (athlete) {
	return '<tr data-id="'+ athlete.id +'"><th>' + athlete.name + '</th><th>' + athlete.category + '</th><th>' + athlete.gender  + '</th><th>' + editAndSaveButtons('') + '</th></tr>';
}

function athleteRowNoData() {
	return '<tr id="nodata"><th colspan="4" style="text-align: center; color: blue;">No ATHLETES loaded...</th></tr>';
}

function editAndSaveButtons() {
	// return editButton () + '&nbsp;' + '&nbsp;' + clickThroughButton();
	return editButton ();
}

function clickThroughButton () {
	return '<button class="btn btn-success wodDetails">' + '<i class="icon-chevron-right"></i>' + '</button>';
}

function deleteButton() {
	return '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
}

function editButton () {
	return '<button class="btn btn-info insertScores"><i class="icon-pencil"></i></button>';
}

function scoreBoardButton() {
	return '<button class="btn btn-info scoreboard">' + '<i class="icon-trash"></i>' + '</button>';
}