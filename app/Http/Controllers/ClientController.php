<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceClient;
use Illuminate\Http\Request;

class ClientController extends Controller
{
	public function getClientLineInfo(Request $request) {
		$clients = Client::where('user_id', $request->user_id)->get();
		return response()->json($clients);
	}

	public function saveClientToInvoice(Request $request) {

		// var_dump('saveClientToInvoice');
		// var_dump('clientid', $request->clientid);
		
		$check = InvoiceClient::where('invoice_id', $request->invoiceid)->get();
		$clientDetails = Client::find($request->clientid);

		// var_dump('invoiceDetails');
		// var_dump($invoiceDetails);

		$type = '';
		$save = null;

		if ( empty($check[0]) ) {

			$invClint = new InvoiceClient();
			$invClint->client_id = $request->clientid;
			$invClint->invoice_id = $request->invoiceid;
			$save = $invClint->save();
			$type = 'create';

		} else {

			// var_dump('dit is nie leeg nie');
			// var_dump($check[0]->id);

			$invClint = InvoiceClient::find($check[0]->id);
			$invClint->client_id = $request->clientid;
			$save = $invClint->save();
			$type = 'update';
		}

		if ( $save ) {

			$invoiceClientData = [
				'type' => $type,
				'id' => $invClint->id,
				'clientid' => $invClint->client_id,
				'invoiceid' => $invClint->invoice_id
			];

			return response()->json([
				'code' => 1,
				'msg' => 'New InvoiceClient has been successfully created!',
				'data' => ['invoiceClientData' => $invoiceClientData, 'clientDetails' => $clientDetails]
			]);

		} else {

			return response()->json([
				'code' => 0,
				'msg' => 'Something went wrong.',
				'data' => null
			]);

		}

	}
}
