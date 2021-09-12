<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceLineController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\EventController;


Route::get('/', function () { return view('welcome'); });
Route::get('/invoice-list', [InvoiceController::class, 'index'])->name('invoice.list');
Route::post('/add-invoice', [InvoiceController::class, 'addInvoice'])->name('add.invoice');
Route::get('/getInvoicesList', [InvoiceController::class, 'getInvoicesList'])->name('get.invoices.list');
Route::get('/getInvoiceDetails', [InvoiceController::class, 'getInvoiceDetails']);

Route::get('/getInvoiceLineDetails', [InvoiceLineController::class, 'getInvoiceLineDetails']);

Route::get('/getInvoiceLineInfo', [InvoiceLineController::class, 'getInvoiceLineById']);
Route::get('/getProductInfo', [InvoiceLineController::class, 'getProductInfo']);
Route::post('/updateInvoiceLine', [InvoiceLineController::class, 'UpdateInvoiceLine']);

Route::get('/printpdf', [InvoiceController::class, 'printPDF'])->name('print.pdf');

Route::get('/events', [EventController::class, 'eventslist']);
Route::post('/add-event', [EventController::class, 'addEvent'])->name('add.event');
Route::get('/getEventsList', [EventController::class, 'getEventsList'])->name('get.events.list');

// Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'login'])->name('auth.login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('registration');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');