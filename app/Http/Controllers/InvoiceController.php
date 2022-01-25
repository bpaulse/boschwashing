<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceClient;
use App\Http\Controllers\pdfController;
use Illuminate\Support\Facades\Validator;
// use Yajra\DataTables\Facades\DataTables;
// use PDF;

class InvoiceController extends Controller
{
	public function index () {
		return view('invoice-list');
	}

	public function buildAndSendInvoice (Request $request) {

		$invoice_id = $request->invoiceid;
		$updateArr = [ 'status' => 1 ];

		// now update the status of the invoice to sent
		$update = Invoice::where('id', $invoice_id)->update($updateArr);

		if ( $update ) {

			$pdf = new pdfController();
			$return = $pdf->create($invoice_id);

			// if ( $return['code'] === 1 ) {
			// 	return response()->json(['code' => $return['code'], 'msg' => $return['msg'], 'data' => $invoice_id ]);
			// } else {
			// 	return response()->json(['code' => $return['code'], 'msg' => $return['msg'] ]);
			// }

		} else {
			return response()->json(['code' => 2, 'msg' => 'Failure sending Invoice...']);
		}


		// 	if ( $update ) {
		// 		return response()->json(['code' => $return['code'], 'msg' => $return['msg'], 'data' => $update]);
		// 	} else {
		// 		return response()->json(['code' => $return
		// 		, 'msg' => $return['msg']]);
		// 	}

		// }

	}

	public function updateSingleInvoiceField (Request $request) {

		$updateArr = [
			'invoice_' . $request->type => $request->fieldValue
		];

		$update = Invoice::find($request->invoice_id)->update($updateArr);

		if ( $update ) {
			return response()->json(['code' => 1, 'msg' => 'Invoice ' . $request->type . ' updated successfully...']);
		} else {
			return response()->json(['code' => 0, 'msg' => 'Something went wrong with the updated...']);
		}

	}


	public function addInvoice(Request $request) {

		$validator = Validator::make($request->all(), [
			'invoice_name' => 'required|unique:invoices|max:255',
			'invoice_desc' => 'required',
		]);

		if ( !$validator->fails() ) {

			$name = $request->input('invoice_name');
			$desc = $request->input('invoice_desc');

			$invoice = new Invoice();

			$invoice->invoice_name = $name;
			$invoice->invoice_desc = $desc;
			$invoice->user_id = 1;

			$save = $invoice->save();

			if ( $save ) {

				$invoiceData = [
					'id' => $invoice->id,
					'name' => $name, 
					'desc' => $desc
				];

				return response()->json([
					'code' => 1,
					'msg' => 'New Invoice has been successfully created!',
					'data' => $invoiceData
				]);

			} else {

				return response()->json([
					'code' => 0,
					'msg' => 'Something went wrong.',
					'data' => null
				]);

			}

		} else {
			return response()->json([
				'code' => 0,
				'error' => $validator->errors()->toArray(),
				'data' => null
			]);
		}

	}

	public function getInvoiceDetails(Request $request) {
		$invoice_id = $request->invoice_id;
		$invoiceDetails = Invoice::find($invoice_id);
		$invoiceClient = InvoiceClient::where('invoice_id', $invoice_id)->get();

		if ( empty($invoiceClient[0]) ) {
			return response()->json(['details' => $invoiceDetails, 'invoiceClient' => NULL]);
		}

		return response()->json(['details' => $invoiceDetails, 'invoiceClient' => $invoiceClient]);

	}

	public function getInvoicesList() {

		$invoices = Invoice::all();
		return response()->json(['details' => $invoices]);

	}

	public function printInvoice () {
		return view('print.invoice');
	}

	public function printPDF() {

		// This  $data array will be passed to our PDF blade

		$data = [
			'title' => 'First PDF for Medium',
			'heading' => 'Hello from 99Points.info',
			'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'
		];

		// $pdf = PDF::loadView('print.pdf', $data);  
		// return $pdf->download('medium.pdf');
	}
}
