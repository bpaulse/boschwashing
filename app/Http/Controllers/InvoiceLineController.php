<?php

namespace App\Http\Controllers;

use App\Models\InvoiceLine;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceLineController extends Controller
{
	private $currency = 'R';

	public function UpdateInvoiceLine(Request $request) {

		$invoiceLine = InvoiceLine::find($request->invoice_line_id);

		$invoiceLine->quantity = $request->quantity;
		$invoiceLine->product_id = $request->product_id;

		$save = $invoiceLine->save();

		if ( $save ){ 
			return response()->json([
				'code' => 1,
				'msg' => 'Invoice Line updated successfully!',
				'data' => ['invoiceLine' => $invoiceLine, 'products' => Product::all()]
			]);
		} else {
			return response()->json([
				'code' => 0,
				'msg' => 'Something went wrong.',
				'data' => null
			]);
		}

	}

	public function getInvoiceLineById(Request $request) {
		$invoice_line_id = $request->inv_line_id;
		$invoicelineInfo = InvoiceLine::find($invoice_line_id);
		$products = Product::all();
		return response()->json([ 'invoicelineInfo' => $invoicelineInfo, 'products' => $products ]);
	}

	public function getInvoiceLineDetails(Request $request) {

		$invoice_id = $request->inv_id;
		$invoicelines = InvoiceLine::where('invoice_id', $invoice_id)->get();

		$data = $this->buildInvoiceLines($invoicelines);

		return response()->json($data);

	}

	private function buildInvoiceLines($invoicelines) {

		$invoiceTotal = 0.00;
		$invoicelinesData = [];

		foreach ($invoicelines as $invoiceline) {

			$product = Product::where('id', $invoiceline->product_id)->get();
			$lineTotal = floatval($invoiceline->quantity) * floatval($product[0]->unitprice);
			$lineData = [
				'invoice_line_id' => $invoiceline->id,
				'quantity' => number_format((float) $invoiceline->quantity, 2, '.', ','),
				'product_id' => $invoiceline->product_id,
				'unitprice' => $this->currency . ' ' . number_format((float) $product[0]->unitprice, 2, '.', ','),
				'product_name' => $product[0]->product_name,
				'linetotal' => $this->currency . ' ' . number_format((float) $lineTotal, 2, '.', ','),
			];
			array_push($invoicelinesData, $lineData);
			$invoiceTotal = floatval($invoiceTotal) + floatval($lineTotal); 
		}

		return [
			'invoiceTotal' => $this->currency . ' ' . number_format((float) $invoiceTotal, 2, '.', ','),
			'invoicelinesData' => $invoicelinesData
		];

	}
}
