<div class="modal fade bd-example-modal-lg" id="editInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="editInvoiceModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="editInvoiceModalLabel"><i class="icon-cog"></i> Edit Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<tr>
						<td>
							<div class="form-group">
								<label class="col-form-label" id="invoice_id"></label>
							</div>
						</td>
						<td>
							<div class="form-group">
								<label class="col-form-label" id="created_date"></label>
							</div>
						</td>
					</tr> 
					<tr>
						<form>
							<td>
								<div class="form-group">
									<label for="invoice_name" class="col-form-label">Invoice Name:</label>
									<input type="text" class="form-control" id="invoice_name" value="">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="invoice_desc" class="col-form-label">Invoice Desc:</label>
									<input type="text" class="form-control" id="invoice_desc" value="">
								</div>
							</td>
							<input type="hidden" class="form-control" id="invoice_id" value="">
						</form>
					</tr>
				</table>

				<div class="card">
					<div class="card-header">
						<div style="float: left; width: 49%; border: 0px solid black;">
							<i class="icon-list"></i> Invoice Lines
						</div>
						<div style="float: right; width: 49%; border: 0px solid black; text-align: right;">
							<i class="icon-plus" id="add-invoice-line" style=""></i>
						</div>
					</div>
					<div class="card-body">
						<table class="table table-hover table-condensed" id="invoice-line-table">
							<thead>
								<tr>
									<th>Product</th>
									<th>Qty</th>
									<th>Unit Price</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>
				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveInvoice">Update Invoice</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="deleteInvoiceModal" tabindex="-1" role="dialog" aria-labelledby="deleteInvoiceModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="deleteInvoiceModalLabel">Edit Invoice</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">Are you sure you want to delete the Invoice?</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveInvoice">Update Invoice</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>