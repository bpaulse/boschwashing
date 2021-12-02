<?php

namespace App\Http\Controllers;

use App\Models\InvoiceLine;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceLineController extends Controller
{
	private $currency = 'R';

	public function UpdateInvoiceLine(Request $request) {

		// var_dump(
		// 	$request->invoice_line_id, 
		// 	$request->quantity, 
		// 	$request->product_id
		// );

		if ( $request->invoice_line_id === NULL ) {

			$invoiceline = new InvoiceLine();
			$invoiceline->quantity = $request->quantity;
			$invoiceline->invoice_id = $request->invoice_id;
			$invoiceline->product_id = $request->product_id;

			$invoiceline->linetotal = $request->quantity * $this->getUnitprice($request->product_id);
			$save = $invoiceline->save();

			var_dump('save');
			var_dump($save);

		} else {

			$save = InvoiceLine::find($request->invoice_line_id)->update(
				[
					'quantity' => $request->quantity,
					'product_id' => $request->product_id,
					'linetotal' => $request->quantity * $this->getUnitprice($request->product_id),
				]
			);

			var_dump('update');
			var_dump($save);

		}

		var_dump($save);

		// $invoiceLine = InvoiceLine::find($request->invoice_line_id);	
		// $invoiceLine->quantity = $request->quantity;
		// $invoiceLine->product_id = $request->product_id;
		// $save = $invoiceLine->save();

		// if ( $save ){ 

		// 	$newTotal = $this->calculateNewTotal($invoiceLine->Invoice->id);

		// 	return response()->json([
		// 		'code' => 1,
		// 		'msg' => 'Invoice Line updated successfully!',
		// 		'data' => ['invoiceLine' => $invoiceLine, 'products' => Product::all(), 'newTotal' => $newTotal ]
		// 	]);
		// } else {
		// 	return response()->json([
		// 		'code' => 0,
		// 		'msg' => 'Something went wrong.',
		// 		'data' => null
		// 	]);
		// }

	}

	private function getUnitprice ( $productId ) {
		$product = Product::find( $productId );
		return $product->unitprice;
	}

	private function calculateNewTotal ($invoice_id) {
		$invoicelines = InvoiceLine::where('invoice_id', $invoice_id)->get();
		$total = 0;
		foreach ($invoicelines as $invoiceline) {
			$product  = Product::find($invoiceline->product_id);
			$total = $total + ( $invoiceline->quantity * $product->unitprice );
		}
		return $this->currency . ' ' . number_format((float) $total, 2, '.', ',');
	}

	public function getInvoiceLineById(Request $request) {
		$invoice_line_id = $request->inv_line_id;
		$invoicelineInfo = InvoiceLine::find($invoice_line_id);

		// print_r($invoicelineInfo->product_id);

		$products = Product::all();

		$productUnitPrice = 0;

		foreach ( $products as $product ) {
			if ( $product->id == $invoicelineInfo->product_id ) {
				$productUnitPrice = $product->unitprice;
			}
			// var_dump($product->unitprice);
		}

		return response()->json([ 'invoicelineInfo' => $invoicelineInfo, 'unitprice' => $productUnitPrice, 'products' => $products ]);
	}

	public function getProductInfo() {
		$products = Product::all();
		return response()->json([ 'products' => $products ]);
	}

	public function retrieveProduct (Request $request) {

		$productItem = Product::where('id', $request->id)->get();
		return response()->json($productItem);

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
