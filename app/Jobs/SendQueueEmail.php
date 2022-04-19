<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mail;
use PDF;
// use Barryvdh\DomPDF\PDF;

class SendQueueEmail implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	protected $details;
	public $timeout = 7200;
	public $ds = DIRECTORY_SEPARATOR;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($details)
	{
		//
		$this->details = $details;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$input['subject'] = $this->details['subject'];
		$input['email'] = $this->details['email'];
		$input['name'] = $this->details['name'];

		// var_dump($this->createFileName());

		$pdffile = $this->createPDF($this->createFileName());

		$attachment_mime = [
			'as' => $pdffile . '.pdf',
			'mine' => 'application/pdf'
		];

		\Mail::send('emails.Test_mail', ['name' => 'Bevan'], function($message) use($input, $attachment_mime){
			$message
			->to($input['email'], $input['name'])
			->subject($input['subject'])
			->attach(public_path('pdf' . $this->ds . $attachment_mime['as']), $attachment_mime);
		});

	}

	public function createFileName() {

		$currentDate = date('dmYHms');

		$filenameStr = 'invoice' . '_' . $this->details['invoice_id'] . '_' . $currentDate;
		return $filenameStr;
	}

	public function createPDF ($fileName) {

		$public = 'public';

		$data = [];
		$pdf = PDF::loadView('print.pdf', $data);
		$fullpathName = $public . $this->ds . 'pdf' . $this->ds . $fileName . '.pdf';
		$pdf->save($fullpathName);

		return $fileName;

	}
}
