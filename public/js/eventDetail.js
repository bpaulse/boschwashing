$(document).ready(function(){

	console.log('eventDetail');

	toastr.options.preventDuplicates = false;

	// get name of the event
	var eventid = window.location.href.split('/').pop();
	setTableHeader (eventid);
	loadWods(eventid);

	$(document).on('click', '.backEvent', backToEvents);
	$(document).on('click', '.addAthlete', addAthlete);

	$(document).on('click', '.addWod', function () {
		console.log('addWod');
		console.log(eventid);
		$('#addEventModal').modal('show');
		// hide time element

		$('#event_id').val(eventid);
		$('#fortime').hide();
	});

	$(document).on('change', '#wod_type', function () {
		console.log('Testr');
		console.log($('#wod_type option:selected').text());
		if ( $('#wod_type option:selected').text() === 'For Time' ) {
			// display for time
			console.log('For Time');
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

			// console.log(form);
			// console.log($(form).attr('method'));
			// console.log($(form).attr('action'));

			// let ajaxData = new FormData(form);

			let ajaxData = {
				wod_name: $('#wod_name').val(),
				wod_type: $('#wod_type').val(),
				wod_desc: $('#wod_desc').val(),
				event_id: $('#event_id').val(),
			};

			// console.log('ajaxData');
			// console.log(ajaxData);

			// console.log($('#wod_name').val());
			// console.log($('#event_id').val());

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
						$('#addEventModal').hide();
						$(form)[0].reset();
						toastr.success(response.msg);
						// console.log(response.data);
						// var event = response.data;
						// console.log(event);
						// var row = eventRow({'id': event.id, 'event_name': event.name, 'event_desc': event.desc, 'event_loc': event.loc});
						// $('#eventsData').append(row);
					}

				},
				error: function(xhr, ajaxOptions, thrownError) { console.log(xhr.responseText); }
			});

		}

	});

});



function backToEvents () {
	console.log('back button');
	window.location.href = '/events';
}

function addAthlete () {
	console.log('addAthlete');
	$('#addAthleteModal').modal('show');
}

function loadWods(eventid) {
	$.ajax({
		type: 'GET',
		url: '/getWodsForEvent',
		data: {eventid: eventid},
		// processData: false,
		dataType: 'json',
		contentType: false,
		success: function (response) {
			var output = '';
			$.each(response.details, function(data1,data2){
				var row = eventRow({'id': data2.id, 'event_name': data2.event_name, 'event_desc': data2.event_desc, 'event_loc': data2.event_location});
				output += row;
			});
			$('#eventsData').html(output);
		},
		error: function(e) {
			console.log(e);
		}
	});
}

function eventRow (event) {
	return '<tr data-id="'+ event.id +'"><th>' + event.event_name + '</th><th>' + event.event_desc + '</th><th>' + event.event_loc  + '</th><th>' + editAndSaveButtons() + '</th></tr>';
}

function editAndSaveButtons() {
	return editButton () + '&nbsp;' + deleteButton() + '&nbsp;' + clickThroughButton();
}

function clickThroughButton () {
	return '<button class="btn btn-success eventDetail">' + '<i class="icon-chevron-right"></i>' + '</button>';
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
		error: function(e) {
			console.log(e);
		}
	});

}