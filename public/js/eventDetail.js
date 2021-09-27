$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	// get name of the event
	var eventid = window.location.href.split('/').pop();

	setTableHeader (eventid);
	loadWods(eventid);

	$(document).on('click', '.backEvent', backToEvents);

	$(document).on('click', '.addAthlete', function () {
		console.log('addAthlete');
		$('#event_id').val(eventid);
		$('#addAthleteModal').modal('show');
	});

	$(document).on('click', '.addWod', function () {
		console.log('addWod');
		console.log(eventid);
		$('#addEventModal').modal('show');
		// hide time element

		$('#event_id').val(eventid);
		$('#fortime').hide();
	});

	$(document).on('change', '#wod_type', function () {

		if ( $('#wod_type option:selected').text() === 'For Time' ) {
			$('#fortime').show();
		} else {
			$('#fortime').hide();
		}

	});

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
						$('#wodData').append(row);
					}

				},
				error: function(xhr, ajaxOptions, thrownError) { console.log(xhr.responseText); }
			});

		}

	});

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

	$(document).on('click', '.wodDetails', function(evt) {
		console.log('wodDetails');
		// var event_id = $(this).closest('tr').attr("data-id");
		// var event_id = 6;
		window.location.href = '/wodDetails/' + eventid;
	});

});

function backToEvents () {
	console.log('back button');
	window.location.href = '/events';
}

function addAthlete () {
	console.log('addAthlete');
	$('#event_id').val(eventid);
	$('#addAthleteModal').modal('show');
}

function loadWods(eventid) {

	$.ajax({
		type: 'GET',
		url: '/getWodsForEvent',
		data: {eventid: eventid},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			var output = '';

			if ( response.count === 0 ) {
				// console.log('count zero');
				output = wodRowNoData();
			} else {
				$.each(response.data, function(data1,data2){
					var row = wodRow({'id': data2.id, 'wodname': data2.wodname, 'woddesc': data2.woddesc, 'wodtype': data2.wodtype, 'settingdesc': data2.settingdesc});
					output += row;
				});
			}

			$('#wodData').html(output);
		},
		error: function(e) {
			console.log(e);
		}
	});

}

function wodRow (event, type) {
	return '<tr data-id="'+ event.id +'"><th>' + event.wodname + '</th><th>' + event.woddesc + '</th><th>' + event.settingdesc  + '</th><th>' + editAndSaveButtons('') + '</th></tr>';
}

function wodRowNoData() {
	return '<tr id="nodata"><th colspan="4" style="text-align: center; color: blue;">No WODS loaded...</th></tr>';
}

function editAndSaveButtons() {
	return editButton () + '&nbsp;' + '&nbsp;' + clickThroughButton();
}

function clickThroughButton () {
	return '<button class="btn btn-success wodDetails">' + '<i class="icon-chevron-right"></i>' + '</button>';
}

function deleteButton() {
	return '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
}

function editButton () {
	return '<button class="btn btn-info editInvoice"><i class="icon-pencil"></i></button>';
}

function setTableHeader (event_id) {

	var ajaxData = {eventid: event_id};
	$.ajax({
		type: 'GET',
		url: '/getEventName',
		data: ajaxData,
		dataType: 'json',
		success: function (response) {
			let tableheader = 'Event' + ' (' + response.name + ')';
			$('#tableHeader').text(tableheader);
		},
		error: function(xhr) {
			console.log(xhr);
		}
	});

}