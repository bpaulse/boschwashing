<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SystemMail extends Mailable
{
	use Queueable, SerializesModels;

	public $details;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($details) {
		$this->details = $details;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {

		// $this->details['title'];
		// return $this->subject('Test Mail from Bevan')->view('emails.TestMail')->attach('pdf/invoice.pdf');
		return $this->subject($this->details['title'])->view('emails.TestMail')->attach('pdf/' . $this->details['attachment']);

		// ->attachFromStorage(
		// 	public_path('pdf/'), 
		// 	'invoice.pdf', 
		// 	[
		// 		'mime' => 'application/pdf'
		// 	]
		// );
		
		// attach(public_path('/pdf/invoice.pdf'));
		// return $this->view('view.name');
	}
}
