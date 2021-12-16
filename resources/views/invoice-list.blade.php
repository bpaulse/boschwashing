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
	{{-- <link href="{{ asset('bootstrap/css//font-awesome.css') }}" rel="stylesheet"> --}}
	<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel='stylesheet' type='text/css'>	

	<title>List of Invocies</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header"><i class="icon-list"></i> Invoices</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed" id="invoices-table">
								<thead>
									<th>#</th>
									<th>--</th>
									<th>Name</th>
									<th>Description</th>
									<th>Action</th>
								</thead>
								<tbody id='tableData'></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
					<div class="card-header">
						<i class="icon-plus-sign-alt"></i> Add New Invoice
					</div>
					<div class="card-body">
						<form action="{{ route('add.invoice') }}" method="POST" id="add-invoice-form">
							@csrf
							<div class="form-group">
								<label for="">Invoices</label>
								<input type="text" class="form-control" name="invoice_name" placeholder="Please Enter an Invoice Name..." />
								<span class="text-danger error-text invoice_name_error"></span>
							</div>
							<div class="form-group">
								<label for="">Invoice Desciption</label>
								<input type="text" class="form-control" name="invoice_desc" placeholder="Please enter an Invoice Description..." />
								<span class="text-danger error-text invoice_desc_error"></span>
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

	@include('edit-invoice-modal');

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

  
