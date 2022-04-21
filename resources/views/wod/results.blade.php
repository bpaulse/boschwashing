<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
	<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
	<title>Results</title>
</head>
<body>

	<div class="container">
		<div class="w-100 text-right p-3"><button class="btn btn-info text-right backWodList">Back</button></div>
		<h2>Dynamic Tabs</h2>
		<p>To make the tabs toggleable, add the data-toggle="tab" attribute to each link. Then add a .tab-pane class with a unique ID for every tab and wrap them inside a div element with class .tab-content.</p>
		
		<ul class="nav nav-tabs"></ul>
		<div class="tab-content">Leader Board Data</div>

	</div>

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	{{-- <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script> --}}
	{{-- <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script> --}}
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}


	<script type="text/javascript" src="{{ asset('js/wodresults.js') }}"></script>

</body>
</html>
