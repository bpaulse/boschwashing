<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
// use Yajra\DataTables\Facades\DataTables;

use PDF;

class InvoiceController extends Controller
{
	public function index () {
		return view('invoice-list');
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
		return response()->json(['details' => $invoiceDetails]);
	}

	public function getInvoicesList() {

		$invoices = Invoice::all();
		return response()->json(['details' => $invoices]);
		// return json_encode($invoices);
		// var_dump($invoices);
		// return DataTables::of($invoices)->make(true);

	}

	public function printPDF()
    {
       // This  $data array will be passed to our PDF blade
       $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.'
		];
        
        // $pdf = PDF::loadView('pdf_view', $data);  
        // return $pdf->download('medium.pdf');
    }
}
