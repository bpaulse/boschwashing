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
	<title>WOD List</title>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-12">
				<div class="w-100 text-right p-1">
					<button class="btn btn-info text-right backEvent">Back</button>
				</div>
				<div class="card">
					<div class="card-header">
						<div style="float: left; width: 50%; border: 0px solid black;">
							<i class="icon-list"></i> <span id="tableHeader"></span>
						</div>
						<div style="float: right; width: 50%; border: 0px solid black; text-align: right;">
							<span class="addAthlete"><img src="{{ asset('images/athlete.png') }}" style="width: 5%;"></span>
							<span class="addWod"><img src="{{ asset('images/workout.png') }}" style="width: 5%;"></span>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-hover table-condensed" id="wodlist-table">
							<thead>
								<th style="width: 30%">Event</th>
								<th style="width: 60%">Description</th>
								<th style="width: 10%">Action</th>
							</thead>
							<tbody id='eventsData'></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('add-athlete-modal');
	@include('add-wod-modal');
	{{-- @include('edit-invoice-modal'); --}}

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/eventDetail.js') }}"></script>

</body>
</html>
