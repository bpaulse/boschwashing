<div class="modal fade bd-example-modal-lg" id="addAthleteModal" tabindex="-1" role="dialog" aria-labelledby="addAthleteModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addAthleteModalLabel"><i class="icon-cog"></i> Add Athlete</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table">
					<form>
						<tr>
							<td>
								<div class="form-group">
									<label for="athlete_name" class="col-form-label">Athlete Name:</label>
									<input type="text" class="form-control" id="athlete_name" value="">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="athlete_surname" class="col-form-label">Athlete Surname:</label>
									<input type="text" class="form-control" id="athlete_surname" value="">
								</div>
							</td>
							{{-- <input type="hidden" class="form-control" id="invoice_id" value=""> --}}
						</tr>
						<tr>
							<td>
								<div class="form-group">
									<label for="athlete_mobile" class="col-form-label">Cellphone:</label>
									<input type="text" class="form-control" id="athlete_mobile" value="">
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="athlete_email" class="col-form-label">Email:</label>
									<input type="text" class="form-control" id="athlete_email" value="">
								</div>
							</td>
						</tr>
						<tr>athlete_type
							<td>
								<div class="form-group">
									<label for="athlete_type" class="col-form-label">Category:</label>
									<select class="form-control" id="athlete_type">
										<option>-----</option>
										<option>RX</option>
										<option>Intermediate</option>
										<option>Beginner</option>
									  </select>
								</div>
							</td>
							<td>
								<div class="form-group">
									<label for="gender" class="col-form-label">Gender:</label>
									<select class="form-control" id="gender">
										<option>-----</option>
										<option>Female</option>
										<option>Male</option>
									  </select>
								</div>
							</td>
						</tr>
					</form>
				</table>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary saveInvoice">Add</button>
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