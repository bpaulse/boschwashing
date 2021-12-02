<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;

class pdfcontroller extends Controller
{
    public function create()
    {
    	$data = ['title' => 'Laravel 7 Generate PDF From View Example Tutorial'];
        $pdf = PDF::loadView('pdf', $data);
        // return $pdf->download('Nicesnippets.pdf');

        // $pdf = PDF::loadView('pdf.invoice', $data);
        // Storage::put('public/pdf/invoice.pdf', $pdf->output());
        // return $pdf->download('invoice.pdf');

        $path = public_path('pdf/');

        // $fileName =  $post['title'] . '.' . 'pdf' ;
        $fileName =  'invoice' . '.' . 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        return $pdf->download($fileName);

    }
}
