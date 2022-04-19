@extends('layouts.app')

@section('content')	
	<div class="container">
		<div class="row" style="margin-top: 45px">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header"><i class="icon-list"></i> Invoices</div>
					<div class="card-body">
						<table class="table table-hover table-condensed" id="invoices-table">
							<thead>
								<th>#</th>
								<th>Name</th>
								<th>Description</th>
								<th>Action</th>
							</thead>
							<tbody id='tableData'></tbody>
						</table>
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
	<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>
@endsection
