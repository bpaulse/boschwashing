<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<title>Events List</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header"><i class="icon-list"></i> Event(s)</div>
					<div class="card-body">
						<table class="table table-hover table-condensed" id="invoices-table">
							<thead>
								<th style="width: 25%">Event</th>
								<th style="width: 25%">Description</th>
								<th style="width: 25%">Location</th>
								<th style="width: 25%">Action</th>
							</thead>
							<tbody id='eventsData'>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<i class="icon-plus-sign-alt"></i> Add New Event
					</div>
					<div class="card-body">
						<form action="{{ route('add.event') }}" method="POST" id="add-event-form">
							@csrf
							<div class="form-group">
								<label for="">Event Name</label>
								<input type="text" class="form-control" name="event_name" placeholder="Please Enter an Event Name..." />
								<span class="text-danger error-text event_name_error"></span>
							</div>
							<div class="form-group">
								<label for="">Event Desciption</label>	
								<input type="text" class="form-control" name="event_desc" placeholder="Please enter an Event Description..." />
								<span class="text-danger error-text event_desc_error"></span>
							</div>
							<div class="form-group">
								<label for="">Event Location</label>	
								<input type="text" class="form-control" name="event_location" placeholder="Please enter an Event Location..." />
								<span class="text-danger error-text event_location_error"></span>
							</div>
							<div class="form-group">
								<label for="">Event Date</label>	
								<input type="text" class="form-control" name="event_date" id="event_date" placeholder="Please enter an Event Date..." />
								<span class="text-danger error-text event_date_error"></span>
							</div>
							<div class="form-group">
								<button class="btn btn-block btn-success" type="submit">SAVE</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- @include('edit-invoice-modal'); --}}

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/events.js') }}"></script>

</body>
</html>
