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
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css">
	<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css"> -->
	<title>Events List</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<i class="icon-list"></i> Event(s)
						<i class="icon-plus float-right" id="addEventForm"></i>
					</div>
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
		</div>
	</div>

	@include('edit-event-modal');
	@include('add-event-modal');

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>
	<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

	<script type="text/javascript" src="{{ asset('js/events.js') }}"></script>

</body>
</html>
