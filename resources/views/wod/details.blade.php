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
	<title>Wod Details</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="w-25 text-left p-3">
				<div class="form-group">
					<input type="text" class="form-control" id="athlete_search" value="" placeholder="Search">
				</div>
			</div>
			<div class="w-25 text-left p-3">
			</div>
			<div class="w-50 text-right p-3">
				<button class="btn btn-info text-right backEventDetails">Back</button>
			</div>
			<div class="col-md-12">
				<div class="card">
					<div class="card-header"><i class="icon-list"></i> WOD Detail(s) </div>
					<div class="card-body">
						<table class="table table-hover table-condensed" id="athletes-table">
							<thead>
								<th style="width: 30%">Name</th>
								<th style="width: 30%">Category</th>
								<th style="width: 25%">Gender</th>
								<th style="width: 15%">Action</th>
							</thead>
							<tbody id='athleteData'></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('add-woddetail-modal');

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/woddetails.js') }}"></script>

</body>
</html>
