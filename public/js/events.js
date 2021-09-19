$(document).ready(function(){

	console.log('events');

	toastr.options.preventDuplicates = false;

	loadEvents();

	$(document).on('click', '.eventDetail', myFunc);

	$('#add-event-form').on('submit', function(e){

		e.preventDefault();

		console.log('add-event-form');

		var doAjax = true;
		if ( doAjax ) {

			var form = this;

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: new FormData(form),
				processData: false,
				dataType: "json",
				contentType: false,
				beforeSend: function() {
						$(form).find('span.error-text').text('');
				},
				success: function (response) {

					if ( response.code === 0 ) {
						// $.each(response.error, function(prefix, val){
						// 	$(form).find('span.'+prefix+'_error').text(val[0]);
						// });
					} else {

						console.log('success');
						$(form)[0].reset();
						toastr.success(response.msg);

						console.log(response.data);
						var event = response.data;
						console.log(event);

						var row = eventRow({'id': event.id, 'event_name': event.name, 'event_desc': event.desc, 'event_loc': event.loc});
						$('#eventsData').append(row);
					}
				}
			});

		}

	});

	function loadEvents() {
		$.ajax({
			type: 'GET',
			url: '/getEventsList',
			data: '',
			processData: false,
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
		return '<button class="btn btn-info editInvoice"><i class="icon-pencil"></i></button>' + '&nbsp;' + '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>' + '&nbsp;' + '<button class="btn btn-success eventDetail">' + '<i class="icon-chevron-right"></i>' + '</button>';
	}

	function myFunc(e){
		var event_id = $(this).closest('tr').attr("data-id");
		window.location.href = '/displayEventDetails/' + event_id;
	}

});
