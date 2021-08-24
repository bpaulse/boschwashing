<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;



Route::get('/', function () { return view('welcome'); });
Route::get('/invoice-list', [InvoiceController::class, 'index'])->name('invoice.list');
Route::post('/add-invoice', [InvoiceController::class, 'addInvoice'])->name('add.invoice');
Route::get('/getInvoicesList', [InvoiceController::class, 'getInvoicesList'])->name('get.invoices.list');
// Route::get('/getInvoiceDetails', [InvoiceController::class, 'getInvoiceDetails'])->name('get.invoice.details');
Route::get('/getInvoiceDetails', [InvoiceController::class, 'getInvoiceDetails']);

Route::get('/getInvoiceLineDetails', [InvoiceLineController::class, 'getInvoiceLineDetails']);

Route::get('/printpdf', [InvoiceController::class, 'printPDF'])->name('print.pdf');