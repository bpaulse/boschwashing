$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	$('#add-invoice-form').on('submit', function(e){

		e.preventDefault();

		var doAjax = true;
		if ( doAjax ) {

			var form = this;
			// var formData = new FormData(form);

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: new FormData(form),
				processData: false,
				dataType: "json",
				contentType: false,
				beforeSend: function() {
					$(form).find('span.error-text').text('');
				},
				success: function (response) {

					if ( response.code === 0 ) {
						$.each(response.error, function(prefix, val){
							$(form).find('span.'+prefix+'_error').text(val[0]);
						});
					} else {
						$(form)[0].reset();
						toastr.success(response.msg);
						//append to tableData
						console.log('bev');
						console.log(response.data);

						var invoice = response.data;

						console.log(invoice);

						console.log(invoice.id);
						console.log(invoice.name);
						console.log(invoice.desc);

						var row = invoiceRow(response.data.id, response.data.name, response.data.desc);
						$('#tableData').append(row);
					}
				}
			});

		}

	});

	getInvoiceList();

	$(document).on('click', '.saveInvoice', function(){
		console.log('saveInvoice');
		$.ajax({
			url: '',
			method: 'post'
		});
		$('#editInvoiceModal').modal('hide');
	});

	$(document).on('click', '#add-invoice-line', function(e){
		console.log('add-invoice-line');



	});

	$('#add-invoice-line').hover(function() {
		$(this).css('cursor','pointer');
	});

	$(document).on('click', '.deleteInvoice', function(){
		console.log('Delete Invoice');
		var i = $(this).closest('tr').attr('data-id');
		console.log(i);
	});

	$(document).on('click', '.editInvoice', function(){

		console.log('Edit Invoice');

		let _token   = $('meta[name="csrf-token"]').attr('content');
		var inv_id = $(this).closest('tr').attr('data-id');
		let ajaxData = {invoice_id: inv_id, _token: _token};

		$.ajax({
			method: 'get',
			url: '/getInvoiceDetails',
			data: ajaxData,
			dataType: 'json',
			contentType: false,
			success: function(data){
				// console.log(data.details.updated_at);
				const invoicedate = new Date(data.details.updated_at);
				// console.log('invoicedate');
				// console.log(invoicedate);
				var displayYearDate = invoicedate.getFullYear();
				var displayMonthDate = invoicedate.getMonth() + 1;
				var displayDayDate = invoicedate.getDate();

				$('#editInvoiceModal').modal('show');
				$('#invoice_id').text(padInvoiceNumber(data.details.id));
				$('#invoice_name').val(data.details.invoice_name);
				$('#invoice_desc').val(data.details.invoice_desc);
				$('#created_date').text(displayYearDate + '-' + displayMonthDate + '-' + displayDayDate);

				console.log(inv_id);

				buildInvoiceLines(inv_id);

			},
			error: function (e) {
				console.log(e);
			}
		});

	});

});

function padInvoiceNumber(id) {
	const prefix = 'INV_';
	let zeros;
	if ( id >= 0 && id < 10 ) {
		zeros = '00000';
	} else if ( id >= 10 && id < 100 ) {
		zeros = '0000';
	} else if ( id >= 100 && id < 1000 ) {
		zeros = '000';
	} else if ( id >= 1000 && id < 10000 ) {
		zeros = '00';
	} else if ( id >= 10000 && id < 10000 ) {
		zeros = '0';
	} else {
		zeros = '';
	}
	return prefix + zeros + id.toString();;
}

function getInvoiceList() {
	$.ajax({
		type: 'GET',
		url: '/getInvoicesList',
		data: '',
		processData: false,
		dataType: 'json',
		contentType: false,
		success: function (response) {
			var output = '';
			// console.log(response);
			$.each(response.details, function(data1,data2){
				var row = invoiceRow(data2.id, data2.invoice_name, data2.invoice_desc);
				output += row;
			});
			$('#tableData').html(output);
		},
		error: function(e) {
			console.log(e);
		}
	});
}

function invoiceRow (invoiceId, invoiceName, invoiceDesc) {
	return '<tr data-id="'+ invoiceId +'"><th>' + invoiceId + '</th><th>' + invoiceName + '</th><th>' + invoiceDesc  + '</th><th>' + editAndSaveButtons() + '</th></tr>';
}

function buildInvoiceLines (invoiceid) {

	var row = '<tr><td>Product 1</td><td>2</td><td>R20.00</td><td>R40.00</td></tr>';
	$("#invoice-line-table>tbody").html(row);

	

	{/* <div class="form-row">
	<div class="form-group col-md-6"><label for="inputCity">City</label><input type="text" class="form-control" id="inputCity"></div>
	<div class="form-group col-md-4"><label for="inputState">State</label><select id="inputState" class="form-control"><option selected>Choose...</option><option>...</option></select></div>
	<div class="form-group col-md-2"><label for="inputZip">Zip</label><input type="text" class="form-control" id="inputZip"></div>
	</div> */}

	// invoiceLinesData

}

function editAndSaveButtons() {
	return '<button class="btn btn-info editInvoice"><i class="icon-pencil"></i></button>' + '&nbsp;' + '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
	// return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"><i class="icon-pencil"></i></button>' + '&nbsp;' + '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
}