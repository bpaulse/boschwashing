<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
	public function send_mail($data) {

		$details = [
			'subject' => $data['subject'],
			'email' => $data['email'],
			'name' => $data['name'],
			'invoice_id' => $data['invoice_id']
		];

		$job = (new \App\Jobs\SendQueueEmail($details))->delay(now()->addSeconds(2));
		dispatch($job);
		return true;

	}

}
