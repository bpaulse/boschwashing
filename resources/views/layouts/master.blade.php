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
	<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel='stylesheet' type='text/css'>	

	<title>@yield('title')</title>
</head>
<body>

	@yield('content')

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
	<script type="text/javascript" src="{{ asset('select2/dist/js/select2.min.js') }}" ></script>



</body>
</html>

  
