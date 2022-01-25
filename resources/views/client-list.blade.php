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

	<title>List of Clients</title>
</head>
<body>

	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-12">
				<div style="text-align: right; padding-bottom: 10px;">
					<button class="btn btn-warning backToInvoiceList">Back</button>
				</div>
				<div class="card">
					<div class="card-header">
						<div style="float: left; width: 50%; border: 0px solid black;">
							<i class="icon-list"></i> Clients <span id="tableHeader"></span>
						</div>
						<div style="float: right; width: 50%; border: 0px solid black; text-align: right;">
							<span class="addClient"><img src="{{ asset('images/add-icon.jpg') }}" style="width: 5%;"></span>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed" id="client-table">
								<thead>
									<th>Company Name</th>
									<th>Person Name & Surname</th>
									<th>Mobile</th>
									<th>Email</th>
									<th>Action</th>
								</thead>
								<tbody id='clientTableData'></tbody>
							</table>
							<div id="pager">
								<ul id="pagination" class="pagination-sm"></ul>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@include('add-client-modal');
	@include('edit-client-modal');

	<script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('toastr/toastr.min.js') }}"></script>

	<script type="text/javascript" src="{{ asset('js/clientlist.js') }}"></script>
	<script type="text/javascript" src="{{ asset('select2/dist/js/select2.min.js') }}" ></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js" ></script>

</body>
</html>

  
