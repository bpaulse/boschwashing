<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
use App\Mail\SystemMail;
use App\Models\InvoiceLine;
use Illuminate\Support\Facades\Mail;

class pdfController extends Controller
{
	public function create($invoice_id) {

		var_dump($invoice_id);
		$this->data['item'] = InvoiceLine::where('invoice_id', $invoice_id)->get();
		$obj = $this->data['item'];
		// var_dump($obj);

		foreach ( $obj as $item ) {
			print_r($item);

			$item['id'];
			$item['quantity'];
			$item['linetotal'];
			$item['created_at'];
			$item['updated_at'];
			$item['invoice_id'];
			$item['product_id'];

		}


	}
}
