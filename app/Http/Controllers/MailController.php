<?php

namespace App\Http\Controllers;
use App\Mail\SystemMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {

	public function sendMail () {

		$details = [
			'title' => 'NavBilling 1.0- Title of the email',
			'body' => 'This is for testing of the mail body'
		];

		Mail::to('bevanpaulse@gmail.com')->send(new SystemMail($details));
		return 'Email Sent';


	}
}
