<?php

namespace App\Http\Controllers;
use App\Mail\SystemMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
	public function sendMail () {
		$details = [
			'title' => 'Title of the email',
			'body' => 'This is for testing of the mail body'
		];

		Mail::to('bevanpaulse@gmail.com')->send(new SystemMail($details));
		return 'Email Sent';

		// Mail::send('emails.TestMail', [
		// 	'email' => 'email',
		// 	'HP' => 'kontak',
		// 	'nama' => 'nama', 
		// 	'posisi' => 'posisi', 
		// 	'CV' => $tambah->upload_cv = $fileName
		// ], function ($message) use ($request, $tambah, $email) {
	
		// 	$message->from('stevanajja@gmail.com', $request->posisi);   
	
		// 	$message->to('stevantinusl47@gmail.com')
		// 			->subject('Lamaran Baru')
		// 			->cc('stevanlai@yahoo.com.sg')
		// 			->replyTo($request->email);
	
		// 	$message->getSwiftMessage();
	
		// });


	}
}
