$(document).ready(function(){

	toastr.options.preventDuplicates = false;

	$("#clientinfo").select2();

	$("#inputQuantity").focus(function() { $(this).select(); } );

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
						var invoice = response.data;
						var row = invoiceRow(response.data.id, response.data.name, response.data.desc, response.data.status);
						$('#tableData').append(row);
					}
				}
			});

		}

	});	

	getClientList();

	$(document).on('click', '#add-invoice-line', function(e){

		$('#lineupdateform').show();
		$('.update-productline').html('Add');

		//populate amount
		$.ajax({
			method: 'get',
			url: '/getProductInfo',
			data: {},
			dataType: 'json',
			contentType: false,
			success: function(data){
				populateProductSelect(data.products);
				// reset values
				$('#quantityDesc').text(1);
				$('#inputQuantity').val(1)
				$('#unitpriceDesc').text('');
				$('#TotalDesc').text('');
			},
			error: function(xhr, ajaxOptions, thrownError){
				alert(xhr.status);
				alert(thrownError);
			}
		});

	});

	$(document).on('change', '#clientinfo', function(event){

		console.log('save clientid');

		var client_id = event.target.value;
		var invoice_id = $('#inv_id').val();
		saveClientToInvoice(client_id, invoice_id);

	});

	$(document).on('change', '#inputProduct', function(event){

		var product_id = event.target.value;

		if ( product_id === undefined || product_id == null || product_id === 0 || product_id === '' ) {

			// console.log('product undefined');
			$('#unitpriceDesc').text('');
			$('#TotalDesc').text('');

		} else {

			retrieveProduct(product_id);

		}

	});

	$(document).on('click', '.close-line-item', function(e) {
		console.log('close-line-item');
		$('#lineupdateform').hide();
	});

	$(document).on('click', '.update-productline', function(e) {

		const currency = 'R';

		var quantity = $('#inputQuantity').val();
		var product_id = $('#inputProduct').val();
		var inv_line_id = $('#inv_line_id').val();

		var inv_id = $('#inv_id').val();

		var ajaxData = {
			invoice_id: inv_id,
			invoice_line_id: inv_line_id,
			quantity: parseFloat(quantity).toFixed(2),
			product_id: product_id
		};

		// console.log(ajaxData);

		$('#lineupdateform').hide();

		$.ajax({
			method: 'post',
			url: '/updateInvoiceLine',
			data: ajaxData,
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			success: function(response) {

				console.log(response.data.invoiceLine.id);

				if ( response.code === 1 ) {

					$('#lineupdateform').hide();
					toastr.success(response.msg);
					// var prodInfo = getProductInfo(response.data.products, response.data.invoiceLine.product_id);

					// console.log(prodInfo);

					buildInvoiceLines(inv_id);

					// add to 

					// $('#' + inv_line_id + ' td:nth-child(1)').text(prodInfo.product_name);
					// $('#' + inv_line_id + ' td:nth-child(2)').text(ajaxData.quantity);
					// $('#' + inv_line_id + ' td:nth-child(3)').text(currency + ' ' + prodInfo.unitprice);

					// var totalPrice = parseFloat(ajaxData.quantity) * parseFloat(prodInfo.unitprice);
					// $('#' + inv_line_id + ' td:nth-child(4)').text(currency + ' ' + addCommas(totalPrice.toFixed(2)));

					// $('.invoiceTotal').text(response.data.newTotal);

				} else {
					toastr.warning(response.msg);
				}

			},
			error: function(e) { console.log(e) }

		});

	});

	$('#add-invoice-line').hover(function() {
		$(this).css('cursor','pointer');
	});

	$('.close-line-item').hover(function() {
		$(this).css('cursor','pointer');
	});

	$(document).on('hover', '.delete-invoiceline', function(){
		$(this).css('cursor','pointer');
	});

	$(document).on('click', '.delete-invoiceline', function(){
		var trid = $(this).closest('tr').attr('id');
		deleteInvLine(trid);
	});

	$(document).on('click', '.add-invoiceline', function(){
		console.log('add-invoiceline');
	});

	$(document).on('click', '.edit-invoiceline', function(){
		var trid = $(this).closest('tr').attr('id');
		$('#lineupdateform').show();
		getInvoiceLineInfo(trid);
	});

	$(document).on('click', '.deleteInvoice', function(){
		console.log('Delete Invoice');
		var i = $(this).closest('tr').attr('data-id');
		console.log(i);
	});``

	$(document).on('keyup', '#inputQuantity', function(event){

		var quantityVal = $(this).val();
		var product_id = $('#inputProduct').val();

		if ( !isNumberKey(event).status ) {
			var currentString = $(this).val();
			// check the number of occurances of the dots
			newString = currentString.slice(0, -1);
			$(this).val(newString);
			quantityVal = newString;
		}

		$('#quantityDesc').text(quantityVal);
		retrieveProduct(product_id)

	});

	$(document).on('click', '.editInvoice', function(){

		$('#lineupdateform').hide();
		$('#clientinfodisplay').empty();

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

				var currentClientId;

				if ( data.invoiceClient !== null ) {
					console.log('get clientid');
					currentClientId = data.invoiceClient[0].client_id;
					// if (typeof myVar === 'undefined') {
				} else {
					console.log('null');
					currentClientId = 0;
				}

				const invoicedate = new Date(data.details.updated_at);
				var displayYearDate = invoicedate.getFullYear();
				var displayMonthDate = invoicedate.getMonth() + 1;
				var displayDayDate = invoicedate.getDate();

				$('#editInvoiceModal').modal('show');
				$('#invoice_id').text(padInvoiceNumber(data.details.id));
				$('#inv_id').val(inv_id);
				$('#invoice_name').val(data.details.invoice_name);
				$('#invoice_desc').val(data.details.invoice_desc);
				$('#created_date').text(displayYearDate + '-' + displayMonthDate + '-' + displayDayDate);

				// PLEASE CHANGE
				var user_id = 1;

				populateClientDropdown(user_id, currentClientId);
				buildInvoiceLines(inv_id);

			},
			error: function (e) {
				console.log(e);
			}
		});

	});

	$(document).on('click', '.addProduct', function () {
		console.log('addProduct');
		$('#productModal').modal('show');
	});

	$(document).on('click', '.backToInvoiceList', backToInvoiceList);

	$(document).on('click', '.deleteClient', deleteClientModal);

	$(document).on('click', '.deleteClientRow', deleteClientRow);

	$(document).on('click', '.editClient', openClientEditModal);

	// editClientSubmit

	// this is the id of the form
	$("#edit-client-form").submit(submitClientForm);

		// $(document).on('click', '.addClient', openClientAddModal);

});

function submitClientForm(e) {

	e.preventDefault(); // avoid to execute the actual submit of the form.

	var form = $(this)[0];
	var formData = new FormData(form);

	var url = $(this).attr('action');

	console.log(url);
	console.log(formData);

	ajaxData = {
		id: $('#client_id').val(),
		name: $('#name').val(),
		surname: $('#surname').val(),
		mobile: $('#mobile').val(),
		email: $('#email').val(),
		website: $('#website').val(),
		landline: $('#landline').val(),
		vat: $('#vat').val(),
		companyreg: $('#companyreg').val(),
		companyname: $('#companyname').val(),
		address: $('#address').val()
	}

	console.log(ajaxData);

	$.ajax({
		type: $(form).attr('method'),
		url: $(form).attr('action'),
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		data: ajaxData,
		success: function (response) {

			if (response.code === 1 ) {
				form.reset();
				$('#editClientModal').modal('hide');
				toastr.success(response.msg);

				// Update values in the list

				// console.log($('#client_id').val());

				console.log(response.data.companyname);

				$('tr[id="' + $('#client_id').val() + '"] th:nth-child(1)').text(response.data.companyname);
				$('tr[id="' + $('#client_id').val() + '"] th:nth-child(2)').text(response.data.name + ' ' + response.data.surname);
				$('tr[id="' + $('#client_id').val() + '"] th:nth-child(3)').text(response.data.mobile);
				$('tr[id="' + $('#client_id').val() + '"] th:nth-child(4)').text(response.data.email);


			} else {
				form.reset();
				$('#editClientModal').modal('hide');
				toastr.success(response.msg);
			}

		}
	});

}

function openClientAddModal() {
	$('#addClientModal').modal('show');
}

function openClientEditModal() {

	var clientid = null;
	console.log('openClientEditModal');
	$('#editClientModal').modal('show');

	clientid = $(this).closest("tr").attr("id");
	console.log('clientid');
	console.log(clientid);

	if ( clientid === null || clientid === undefined ) {
		console.log('klient is nil');
	} else {
		console.log('kliente id bestaan');
		// get client info
		getClient(clientid);
	}

}

function deleteClientRow(e) {
	console.log('deleteClientRow');
	var ajaxData = {clientid: $('#modal_clientid').val()};
	console.log(ajaxData);

	$.ajax({

		method: 'get',
		url: '/deleteClientLine',
		data: ajaxData,
		dataType: 'json',
		success: function(response){

			if (response.code === 1 ) {

				toastr.success(response.msg + invLineId);
				$('#' + invLineId).remove();

			} else {

				alert(response.msg + invLineId);

			}
			
			// update invoice total
			var invoiceId = $('#inv_id').val();
			// console.log(invoiceId);
			updateInvoiceTotal(invoiceId);

		},
		error: function (e) {
			console.log(e);
		}
	});

}

function deleteClientModal() {
	$('#deleteClientModal').modal('show');
	var clientid = $(this).closest("tr").attr("id");
	$('#modal_clientid').val(clientid);
}

function backToInvoiceList(e){
	window.location.href = '/invoice-list';
}

async function deleteInvLine(invLineId) {
	var ajaxData = {ivlId: invLineId};
	await deleteInvoiceLineData(ajaxData, invLineId);
}

function getClientList() {

	var user_id = 1;

	var ajaxData = {user_id: user_id};

	$.ajax({
		type: 'GET',
		url: '/getClientLineInfo',
		data: ajaxData,
		dataType: 'json',
		// processData: false,
		// contentType: false,
		success: function (response) {

			console.log(response);

			var output = '';

			$.each(response, function(index,data2){
				var row = clientRow(data2);
				output += row;
			});
			$('#clientTableData').html(output);
		},
		error: function(e) {
			console.log(e);
		}
	});
}

function deleteInvoiceLineData (ajaxData, invLineId) {

	$.ajax({

		method: 'get',
		url: '/deleteInvoiceLineData',
		data: ajaxData,
		dataType: 'json',
		success: function(response){

			if (response.code === 1 ) {

				toastr.success(response.msg + invLineId);
				$('#' + invLineId).remove();

			} else {

				alert(response.msg + invLineId);

			}
			
			// update invoice total
			var invoiceId = $('#inv_id').val();
			// console.log(invoiceId);
			updateInvoiceTotal(invoiceId);

		},
		error: function (e) {
			console.log(e);
		}
	});

}

function setClientDropdown(inv_id) {
	var client_id = 1;
	$('#clientinfo').val(1);
	$("#clientinfo option[value=2]").attr('selected', 'selected');
}

function populateClientDropdown(user_id, currentClientId) {
	getClientLineInfo(user_id, currentClientId);
}

function saveClientToInvoice(client_id, invoice_id) {

	console.log('saveClientToInvoice');

	var ajaxData = {
		clientid: client_id,
		invoiceid: invoice_id
	};

	console.log(ajaxData);

	$.ajax({
		method: 'get',
		url: '/saveClientToInvoice',
		data: ajaxData,
		dataType: 'json',
		success: function(response){
			// console.log(response.data.clientDetails);
			// console.log('SaveClientToInvoice');
			$('#clientinfodisplay').empty();

			var item = response.data.clientDetails;
			// console.log('item');
			// console.log(item);

			var clientinfodisplay = "<div style='float: left;'>" + item.companyname + "<br />" + item.name + ' ' + item.surname + "<br />" + item.landline + "<br />" + item.mobile + "<br />" + item.companyreg + "</div>" + "<div style='float: right;'>" + item.address + "<br />" + item.email + "<br />" + item.website + "<br />" + item.vat + "</div>";
			$('#clientinfodisplay').html(clientinfodisplay);
		},
		error: function (e) {
			console.log(e);
		}
	});
}

function getClient ( client_id ) {

	console.log('client_id');
	console.log(client_id);

	$.ajax({
		method: 'get',
		url: '/getClient',
		data: {clientid: client_id},
		dataType: 'json',
		contentType: false,
		success: function(data){
			console.log('getClient');
			console.log(data);

			$('#name').val(data.name);
			$('#surname').val(data.surname);

			$('#mobile').val(data.mobile);
			$('#email').val(data.email);

			$('#website').val(data.website);
			$('#landline').val(data.landline);

			$('#vat').val(data.vat);
			$('#companyreg').val(data.companyreg);

			$('#companyname').val(data.companyname);
			$('#address').val(data.address);

			$('#client_id').val(data.id);

		},
		error: function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
			console.log(ajaxOptions);
		}
	});

}

function getClientLineInfo (user_id, currentClientId) {

	// console.log('user_id');
	// console.log(user_id);
	$.ajax({
		method: 'get',
		url: '/getClientLineInfo',
		data: {user_id: user_id},
		dataType: 'json',
		contentType: false,
		success: function(data){

			populateClientSelect(data, currentClientId);

		},
		error: function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function getInvoiceLineInfo (invoicelineid) {

	$.ajax({
		method: 'get',
		url: '/getInvoiceLineInfo',
		data: {inv_line_id: invoicelineid},
		dataType: 'json',
		contentType: false,
		success: function(data){

			populateProductSelect(data.products);

			$('#inputQuantity').val(parseFloat(data.invoicelineInfo.quantity).toFixed(2));
			$("#inputProduct").val(data.invoicelineInfo.product_id);
			$("#inv_line_id").val(invoicelineid);

			var linetotal = data.invoicelineInfo.quantity * data.unitprice;

			$('#quantityDesc').text(parseFloat(data.invoicelineInfo.quantity).toFixed(2));
			$('#unitpriceDesc').text('R ' + data.unitprice);
			$('#TotalDesc').text('R ' + linetotal);

			$('.update-productline').text('Update');

		},
		error: function(xhr, ajaxOptions, thrownError){
			alert(xhr.status);
			alert(thrownError);
		}
	});
}

function isNumberKey(evt) {
	var charCode = (evt.which) ? evt.which : evt.keyCode;
	if (charCode != 46 && charCode != 190 && charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105)) {
		// console.log('failed: ' + charCode);
		return {'status': false};
	}
	return {'status': true};
}

function invoiceLineStatusString (quantity, unitprice) {
	var tt = quantity * unitprice;

	output = '<table style="border: 1px solid black;">';
	output = output + '<tr><td>UnitPrice</td><td>'+unitprice+'</td><td>Total</td></tr>'
	output = output + '<tr><td>Quantity</td><td>'+quantity+'</td><td>'+tt+'</td></tr>';
	output = output + '</table>';

	return output;
}

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
		$select.append('<option value="' + product.id + '" data-unitprice="' + product.unitprice	 + '">' + product.product_name + '</option>');
	});
}

function populateClientSelect (data, currentclientid) {
	var $select = $('#clientinfo');
	$select.empty().append('<option value="">Choose a Client</option>');
	$.each(data,function(key, item) {

		if ( item.id === currentclientid ) {

			$select.append('<option value="'+item.id+'" selected="true">'+item.companyname+'</option>');
			$('#clientinfodisplay').empty();
			var clientinfodisplay = "<div style='float: left; border: 1px solid black;'>" + item.companyname + "<br />" + item.name + ' ' + item.surname + "<br />" + item.landline + "<br />" + item.mobile + "<br />" + item.companyreg + "</div>" + "<div style='float: right; border: 1px solid black;'>" + item.address + "<br />" + item.email + "<br />" + item.website + "<br />" + item.vat + "</div>";
			$('#clientinfodisplay').html(clientinfodisplay);

		} else {
			$select.append('<option value="'+item.id+'">'+item.companyname+'</option>');
		}

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

function retrieveProduct(productid) {
	// console.log('productid:');
	// console.log(productid);
	$.ajax({
		type: 'GET',
		url: '/retrieveProduct',
		data: {id: productid},
		success: function (response) {
			let product = response[0];
			console.log('product');
			console.log(product);
			$('#unitpriceDesc').text( 'R ' + product.unitprice);
			var quantity = $('#inputQuantity').val();
			let total = product.unitprice * quantity; 
			$('#TotalDesc').text( 'R ' + total);
		},
		error: function(e) {
			console.log(e);
		}
	});
}

function lineStatus(invoiceStatus) {
	output = '';
	if ( invoiceStatus == 0 ) {
		output = 'new_invoice.jfif';
	} else if ( invoiceStatus == 1 ) {
		output = 'overdue.png';
	} else {
		output = 'paid.jpg'
	}
	return '<img src="images/' + output + '" style="width: 35px;" />';
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
			$('#invoice-line-table>tbody').html(allrows);
			$('.invoiceTotal').text(response.invoiceTotal);
		}
	});

}

function updateInvoiceTotal (invoiceid) {

	$.ajax({
		url: '/getInvoiceLineDetails',
		type: 'get',
		data: {inv_id: invoiceid},
		success: function(response) {
			console.log(response.invoiceTotal);
			$('.invoiceTotal').text(response.invoiceTotal);
		}
	});

}

function clientRow (item) {
	return '<tr id="'+ item.id +'">' + 
	tablecell(item.companyname) + 
	tablecell(item.name + ' ' + item.surname) + 
	tablecell(item.mobile) + 
	tablecell(item.email) + 
	tablecell(editAndSaveButtons()) +
	'</tr>';
}

function tablecell(val) {
	return '<th>' + val + '</th>';
}

function editItem () {
	return '<button class="btn btn-info editClient"><i class="icon-pencil"></i></button>';
}

function deleteItem () {
	return '<button class="btn btn-danger deleteClient"><i class="icon-trash"></i></button>';
}

function editAndSaveButtons() {
	return editItem() + '&nbsp;' + deleteItem	();
}