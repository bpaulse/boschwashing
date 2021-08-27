$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	$('#add-invoice-form').on('submit', function(e){

		e.preventDefault();

		var doAjax = true;
		if ( doAjax ) {

			var form = this;

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

	// $(document).on('click', '.saveInvoice', function(){
	// 	console.log('saveInvoice');
	// 	$.ajax({
	// 		url: '',
	// 		method: 'post'
	// 	});
	// 	$('#editInvoiceModal').modal('hide');
	// });

	$(document).on('click', '#add-invoice-line', function(e){
		console.log('add-invoice-line');
	});

	$(document).on('click', '.update-productline', function(e){

		const currency = 'R';

		console.log('update-productline');
		var quantity = $('#inputQuantity').val();
		var product_id = $('#inputProduct').val();
		var inv_line_id = $('#inv_line_id').val();

		console.log(inv_line_id);

		console.log(quantity, product_id);
		console.log(parseFloat(quantity).toFixed(2));

		var ajaxData = {
			invoice_line_id: inv_line_id,
			quantity: parseFloat(quantity).toFixed(2),
			product_id: product_id
		};

		console.log(ajaxData);

		$('#lineupdateform').hide();

		$.ajax({
			method: 'post',
			url: '/updateInvoiceLine',
			data: ajaxData,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(response) {
				console.log(response);

				if ( response.code === 1 ) {
					$('#lineupdateform').hide();
					toastr.success(response.msg);

					console.log(response.data.invoiceLine.product_id);
					console.log(response.data.products);

					var prodInfo = getProductInfo(response.data.products, response.data.invoiceLine.product_id);

					console.log('prodInfo');
					console.log(prodInfo);

					$('#' + inv_line_id + ' td:nth-child(1)').text(prodInfo.product_name);
					$('#' + inv_line_id + ' td:nth-child(2)').text(ajaxData.quantity);
					$('#' + inv_line_id + ' td:nth-child(3)').text(currency + ' ' + prodInfo.unitprice);

					var totalPrice = parseFloat(ajaxData.quantity) * parseFloat(prodInfo.unitprice);

					// n = 10000;
					// r = n.toFixed(2); //10000.00
					// addCommas(r); // 10,000.00

					$('#' + inv_line_id + ' td:nth-child(4)').text(currency + ' ' + addCommas(totalPrice.toFixed(2)));

					$('.invoiceTotal').text();

				} else {
					toastr.warning(response.msg);
				}

			},
			error: function(e) {
				console.log(e);
			}
		});

	});

	$('#add-invoice-line').hover(function() {
		$(this).css('cursor','pointer');
	});

	$(document).on('hover', '.delete-invoiceline', function(){
		$(this).css('cursor','pointer');
	});


	$(document).on('click', '.delete-invoiceline', function(){
		var trid = $(this).closest('tr').attr('id');
		console.log('delete');
		console.log(trid);
	});

	$(document).on('click', '.edit-invoiceline', function(){
	
		var trid = $(this).closest('tr').attr('id');
		// console.log('edit');
		// console.log(trid);
		$('#lineupdateform').show();

		//populate amount
		$.ajax({
			method: 'get',
			url: '/getInvoiceLineInfo',
			data: {inv_line_id: trid},
			dataType: 'json',
			contentType: false,
			success: function(data){
				// console.log(data.invoicelineInfo);
				populateProductSelect(data.products);
				$('#inputQuantity').val(parseFloat(data.invoicelineInfo.quantity).toFixed(2));
				$("#inputProduct").val(data.invoicelineInfo.product_id);
				// console.log('trid');
				// console.log(trid);
				$("#inv_line_id").val(trid);
			},
			error: function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			}
		});

	});

	$(document).on('click', '.deleteInvoice', function(){
		console.log('Delete Invoice');
		var i = $(this).closest('tr').attr('data-id');
		console.log(i);
	});

	$(document).on('click', '.editInvoice', function(){

		$('#lineupdateform').hide();

		let _token = $('meta[name="csrf-token"]').attr('content');
		var inv_id = $(this).closest('tr').attr('data-id');
		let ajaxData = {invoice_id: inv_id, _token: _token};

		$.ajax({
			method: 'get',
			url: '/getInvoiceDetails',
			data: ajaxData,
			dataType: 'json',
			contentType: false,
			success: function(data){

				const invoicedate = new Date(data.details.updated_at);
				var displayYearDate = invoicedate.getFullYear();
				var displayMonthDate = invoicedate.getMonth() + 1;
				var displayDayDate = invoicedate.getDate();

				$('#editInvoiceModal').modal('show');
				$('#invoice_id').text(padInvoiceNumber(data.details.id));
				$('#invoice_name').val(data.details.invoice_name);
				$('#invoice_desc').val(data.details.invoice_desc);
				$('#created_date').text(displayYearDate + '-' + displayMonthDate + '-' + displayDayDate);

				buildInvoiceLines(inv_id);

			},
			error: function (e) {
				console.log(e);
			}
		});

	});

});

function getProductInfo (products, product_id) {

	var returnProd;

	$.each(products, function(key, product){
		if ( product.id == product_id ){
			returnProd = product;
		}
	});

	return returnProd;
}

function addCommas(nStr) {
	nStr += '';
	var x = nStr.split('.');
	var x1 = x[0];
	var x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function populateProductSelect (products) {
	var $select = $('#inputProduct'); 
	$select.empty().append('<option value="">Choose a product</option>');
	$.each(products,function(key, product) {
		$select.append('<option value=' + product.id + '>' + product.product_name + '</option>');
	});
}

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

	$.ajax({
		url: '/getInvoiceLineDetails',
		type: 'get',
		data: {inv_id: invoiceid},
		success: function(response) {
			var allrows = '';
			$.each(response.invoicelinesData, function(data1,data2){
				var row = '<tr id="' + data2.invoice_line_id + '">' + TableCell(data2.product_name) + TableCell(data2.quantity) + TableCell(data2.unitprice) + TableCell(data2.linetotal) + actionInvoiceLine () + '</tr>';
				allrows = allrows + row;
			});
			$("#invoice-line-table>tbody").html(allrows);
		}
	});

}
function TableCell(val) {
	return '<td>' + val + '</td>';
}

function actionInvoiceLine () {
	return '<td style="text-align: center;">'+editInvoiceLine()+'&nbsp;'+deleteInvoiceLine()+'</i></td>';
}

function editInvoiceLine () {
	return '<i class="icon-pencil edit-invoiceline"></i>';
}

function deleteInvoiceLine () {
	return '<i class="icon-trash delete-invoiceline"></i>';
}

function editAndSaveButtons() {
	return '<button class="btn btn-info editInvoice"><i class="icon-pencil"></i></button>' + '&nbsp;' + '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
	// return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop"><i class="icon-pencil"></i></button>' + '&nbsp;' + '<button class="btn btn-danger deleteInvoice">' + '<i class="icon-trash"></i>' + '</button>';
}