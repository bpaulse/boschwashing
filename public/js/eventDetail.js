// tinymce.init({selector:'textarea', inline: true});

$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	// get name of the event
	var eventid = window.location.href.split('/').pop();

	setTableHeader (eventid);
	loadWods(eventid);

	$(document).on('click', '.scoreboard', function(evt){
		let wodid = $(this).closest('tr').attr('data-wod_id');
		window.location.href = '/wodResults/' + eventid + '/' + wodid;
	});

	$(document).on('click', '.backEvent', backToEvents);

	$(document).on('click', '.addAthlete', function () {

		$('#event_id').val(eventid);
		$('#addAthleteModal').modal('show');

		console.log('show modal');

		$('input[name=sample-radio][value=NewUser]').prop('checked', true);
	
		$('#add-athlete-form').css('display', 'block');
		$('#assoc-athlete-form').css('display', 'none');

		getGender();

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
				wod_id: $('#wod_id').val(),
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
		var doAjax = true;

		//get value from dropdown
		var athlete_type = $('#athlete_type option:selected').val();
		var gender = $('#gender option:selected').val();

		console.log('gender');
		console.log(gender);

		if ( doAjax ) {

			var form = this;

			let ajaxData = {
				athlete_name:		$('#athlete_name').val(),
				athlete_surname:	$('#athlete_surname').val(),
				athlete_mobile:		$('#athlete_mobile').val(),
				athlete_email:		$('#athlete_email').val(),
				athlete_type:		athlete_type,
				gender:				gender,
				event_id:			$('#event_id').val(),
			};

			console.log(ajaxData);

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

						// console.log('success');
						$('#addAthleteModal').modal('hide');

						$(form)[0].reset();
						toastr.success(response.msg);

						// console.log(response.data);

						// var athlete = response.data;
						// console.log(athlete);

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
		var wodid = $(this).closest('tr').attr("data-wod_id");
		window.location.href = '/wodDetails/' + eventid + '/' + wodid;

	});

	$(document).on('click', '.editWod', function(evt){

		$('#editEventModal').modal('show');
		let wodid = $(this).closest('tr').attr('data-wod_id');

		$('#wod_id').val(wodid);

		let wodData = {
			wodid: wodid
		};

		getWODDetails(wodData);

	});

	$(document).on('click', '.updateWod', updateEventWod);

	$(document).on('change', 'input[name=sample-radio]', function(evt){
		
		console.log($(this).val());
		if ( $(this).val() == 'ExistingUser' ) {
			console.log('Existing');
			$('#add-athlete-form').css('display', 'none');
			$('#assoc-athlete-form').css('display', 'block');
			// console.log('hide form');
		} else {
			console.log('New');
			$('#add-athlete-form').css('display', 'block');
			$('#assoc-athlete-form').css('display', 'none');
			// console.log('show form');
		}

	});

	/*An array containing all the country names in the world:*/
	// var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
	var countries = [];

	/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
	autocomplete(document.getElementById("myInput"), countries);

});

function updateEventWod(evt){

	console.log('updateWod');

	evt.preventDefault();

	// wod_edit_name
	var ajaxData = {
		wod_id: $("#wod_id").val(),
		wod_name: $("#wod_edit_name").val(),
		wod_desc: $.trim($("#wod_edit_desc").val()),
		wod_type: $("#wod_edit_type option:selected").val(),
		wod_type_name: $("#wod_edit_type option:selected").text()
	};

	updateAjaxWod(ajaxData);

}

function updateAjaxWod(data) {

	$.ajax({
		type: 'GET',
		url: '/updateWod',
		data: data,
		dataType: 'json',
		contentType: false,
		success: function (response) {

			if ( response.update == 1 ) {

				toastr.success('WOD updated successfully...');
				$('#editEventModal').modal('hide');

				$('tr[data-wod_id="' + response.wod_id + '"] th:nth-child(1)').html(response.wodData.wodname);
				$('tr[data-wod_id="' + response.wod_id + '"] th:nth-child(2)').html(response.wodData.woddesc);
				$('tr[data-wod_id="' + response.wod_id + '"] th:nth-child(3)').text(response.wodData.wodtypename);


			} else {
				toastr.warning('ERROR updating the WOD. Please try again...');
			}

		},
		error: function(e) {
			console.log(e);
		}
	});

}

function getWODDetails (wodData) {

	$.ajax({
		type: 'GET',
		url: '/getWODDescAndSettings',
		data: wodData,
		dataType: 'json',
		contentType: false,
		success: function (response) {

			let wod = response.wod;

			$('#wod_edit_name').val(wod.wodname);
			$('#wod_edit_desc').val(wod.woddesc);

			let settings = response.settings;

			var ddl = $("#wod_edit_type");
			ddl.empty();
			ddl.append($("<option></option>").val("").html("--Select--"));

			$.each(settings, function (index, item) {

				if ( wod.wodtype == item.id ) {
					ddl.append($("<option selected></option>").val(item.id).html(item.settingdesc));
				} else {
					ddl.append($("<option></option>").val(item.id).html(item.settingdesc));
				}

			});

		},
		error: function(e) {
			console.log(e);
		}
	});

}

function backToEvents () {
	window.location.href = '/events';
}

function addAthlete () {
	$('#event_id').val(eventid);
	$('#addAthleteModal').modal('show');
}

function getGender() {

	$.ajax({
		type: 'GET',
		url: '/getGender',
		data: {},
		dataType: 'json',
		contentType: false,
		success: function (response) {

			var items = "";
			$.each(response, function(index,data2){
				items += "<option id='"+data2.id+"'>" + data2.settingdesc + "</option>";
			});
			$("#gender").append(items);

		},
		error: function(e) {
			console.log(e);
		}
	});

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
				output = wodRowNoData();
			} else {
				$.each(response.data, function(data1,data2){
					var row = wodRow({'id': data2.id, 'wodname': data2.wodname, 'woddesc': data2.woddesc, 'wodtype': data2.wodtype, 'settingdesc': data2.settingdesc, 'event_date': data2.event_date });
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

function wodRow (wod, type) {
	return '<tr data-wod_id="'+ wod.id +'"><th>' + wod.wodname + '</th><th>' + wod.woddesc + '</th><th>' + wod.settingdesc  + '</th><th>' + editAndSaveButtons(wod.event_date) + '</th></tr>';
}

function wodRowNoData() {
	return '<tr id="nodata"><th colspan="4" style="text-align: center; color: blue;">No WODS loaded...</th></tr>';
}

function editAndSaveButtons(event_date) {

	const eventDateObj = new Date(event_date);
	const currentDateObj = new Date();

	if ( eventDateObj < currentDateObj ) {
		return scoreBoardButton();
	} else {
		return editButton () + '&nbsp;' + '&nbsp;' + scoreBoardButton() + '&nbsp;' + '&nbsp;' + clickThroughButton();
	}

}

function clickThroughButton () {
	return '<button class="btn btn-success wodDetails">' + '<i class="icon-chevron-right"></i>' + '</button>';
}

function deleteButton() {
	return '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
}

function editButton () {
	return '<button class="btn btn-info editWod"><i class="icon-pencil"></i></button>';
}

function scoreBoardButton() {
	return '<button class="btn btn-warning scoreboard">' + '<i class="icon-list-ol"></i>' + '</button>';
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

function delete_search_history(id) {

	fetch("process_data.php", {

		method: "POST",
		body: JSON.stringify({
			action:'delete',
			id:id
		}),
		headers:{
			'Content-type' : 'application/json; charset=UTF-8'
		}

	}).then(function(response){

		return response.json();

	}).then(function(responseData){
		load_search_history();
	});
}

function load_search_history(){
	var search_query = document.getElementsByName('search_box')[0].value;

	if(search_query == '')
	{

		fetch("process_data.php", {

			method: "POST",

			body: JSON.stringify({
				action:'fetch'
			}),

			headers:{
				'Content-type' : 'application/json; charset=UTF-8'
			}

		}).then(function(response){

			return response.json();

		}).then(function(responseData){

			if(responseData.length > 0)
			{

				var html = '<ul class="list-group">';

				html += '<li class="list-group-item d-flex justify-content-between align-items-center"><b class="text-primary"><i>Your Recent Searches</i></b></li>';

				for(var count = 0; count < responseData.length; count++)
				{

					html += '<li class="list-group-item text-muted" style="cursor:pointer"><i class="fas fa-history mr-3"></i><span onclick="get_text(this)">'+responseData[count].search_query+'</span> <i class="far fa-trash-alt float-right mt-1" onclick="delete_search_history('+responseData[count].id+')"></i></li>';

				}

				html += '</ul>';

				document.getElementById('search_result').innerHTML = html;

			}

		});

	}
}

function get_text(event) {
	var string = event.textContent;

	//fetch api

	fetch("process_data.php", {

		method:"POST",

		body: JSON.stringify({
			search_query : string
		}),

		headers : {
			"Content-type" : "application/json; charset=UTF-8"
		}
	}).then(function(response){

		return response.json();

	}).then(function(responseData){

		document.getElementsByName('search_box')[0].value = string;
	
		document.getElementById('search_result').innerHTML = '';

	});

	

}

function load_data(query){
	if(query.length > 2)
	{
		var form_data = new FormData();
		form_data.append('query', query);
		var ajax_request = new XMLHttpRequest();
		ajax_request.open('POST', 'process_data.php');
		ajax_request.send(form_data);
		ajax_request.onreadystatechange = function()
		{
			if(ajax_request.readyState == 4 && ajax_request.status == 200)
			{
				var response = JSON.parse(ajax_request.responseText);

				var html = '<div class="list-group">';

				if(response.length > 0)
				{
					for(var count = 0; count < response.length; count++)
					{
						html += '<a href="#" class="list-group-item list-group-item-action" onclick="get_text(this)">'+response[count].post_title+'</a>';
					}
				}
				else
				{
					html += '<a href="#" class="list-group-item list-group-item-action disabled">No Data Found</a>';
				}

				html += '</div>';

				document.getElementById('search_result').innerHTML = html;
			}
		}
	}
	else
	{
		document.getElementById('search_result').innerHTML = '';
	}
}


function autocomplete(inp, arr) {
	/*the autocomplete function takes two arguments,
	the text field element and an array of possible autocompleted values:*/
	var currentFocus;
	/*execute a function when someone writes in the text field:*/
	inp.addEventListener("input", function(e) {
		var a, b, i, val = this.value;
		/*close any already open lists of autocompleted values*/
		closeAllLists();
		if (!val) { return false;}
		currentFocus = -1;
		/*create a DIV element that will contain the items (values):*/
		a = document.createElement("DIV");
		a.setAttribute("id", this.id + "autocomplete-list");
		a.setAttribute("class", "autocomplete-items");
		/*append the DIV element as a child of the autocomplete container:*/
		this.parentNode.appendChild(a);
		/*for each item in the array...*/
		for (i = 0; i < arr.length; i++) {
		/*check if the item starts with the same letters as the text field value:*/
		if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
			/*create a DIV element for each matching element:*/
			b = document.createElement("DIV");
			/*make the matching letters bold:*/
			b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
			b.innerHTML += arr[i].substr(val.length);
			/*insert a input field that will hold the current array item's value:*/
			b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
			/*execute a function when someone clicks on the item value (DIV element):*/
			b.addEventListener("click", function(e) {
				/*insert the value for the autocomplete text field:*/
				inp.value = this.getElementsByTagName("input")[0].value;
				/*close the list of autocompleted values,
				(or any other open lists of autocompleted values:*/
				closeAllLists();
			});
			a.appendChild(b);
		}
	}
});
	/*execute a function presses a key on the keyboard:*/
	inp.addEventListener("keydown", function(e) {
		var x = document.getElementById(this.id + "autocomplete-list");
		if (x) x = x.getElementsByTagName("div");
		if (e.keyCode == 40) {
			/*If the arrow DOWN key is pressed,
			increase the currentFocus variable:*/
			currentFocus++;
			/*and and make the current item more visible:*/
			addActive(x);
		} else if (e.keyCode == 38) { //up
			/*If the arrow UP key is pressed,
			decrease the currentFocus variable:*/
			currentFocus--;
			/*and and make the current item more visible:*/
			addActive(x);
		} else if (e.keyCode == 13) {
			/*If the ENTER key is pressed, prevent the form from being submitted,*/
			e.preventDefault();
			if (currentFocus > -1) {
			/*and simulate a click on the "active" item:*/
			if (x) x[currentFocus].click();
			}
		}
	});
	function addActive(x) {
		/*a function to classify an item as "active":*/
		if (!x) return false;
		/*start by removing the "active" class on all items:*/
		removeActive(x);
		if (currentFocus >= x.length) currentFocus = 0;
		if (currentFocus < 0) currentFocus = (x.length - 1);
		/*add class "autocomplete-active":*/
		x[currentFocus].classList.add("autocomplete-active");
	}
	function removeActive(x) {
		/*a function to remove the "active" class from all autocomplete items:*/
		for (var i = 0; i < x.length; i++) {
		x[i].classList.remove("autocomplete-active");
		}
	}
	function closeAllLists(elmnt) {
		/*close all autocomplete lists in the document,
		except the one passed as an argument:*/
		var x = document.getElementsByClassName("autocomplete-items");
		for (var i = 0; i < x.length; i++) {
		if (elmnt != x[i] && elmnt != inp) {
			x[i].parentNode.removeChild(x[i]);
		}
		}
	}
	/*execute a function when someone clicks in the document:*/
	document.addEventListener("click", function (e) {
		closeAllLists(e.target);
	});
}