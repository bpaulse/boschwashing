<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceLineController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;

Route::get('/', function () { return view('welcome'); });
Route::get('/invoice-list', [InvoiceController::class, 'index'])->name('invoice.list');
Route::post('/add-invoice', [InvoiceController::class, 'addInvoice'])->name('add.invoice');
Route::get('/getInvoicesList', [InvoiceController::class, 'getInvoicesList'])->name('get.invoices.list');
Route::get('/getInvoiceDetails', [InvoiceController::class, 'getInvoiceDetails']);

Route::get('/getInvoiceLineDetails', [InvoiceLineController::class, 'getInvoiceLineDetails']);

Route::get('/getInvoiceLineInfo', [InvoiceLineController::class, 'getInvoiceLineById']);
Route::get('/getProductInfo', [InvoiceLineController::class, 'getProductInfo']);
Route::post('/updateInvoiceLine', [InvoiceLineController::class, 'UpdateInvoiceLine']);

Route::get('/retrieveProduct', [InvoiceLineController::class, 'retrieveProduct']);

Route::get('/printpdf', [InvoiceController::class, 'printPDF'])->name('print.pdf');

// Events
Route::get('/events', [EventController::class, 'eventslist']);
Route::post('/add-event', [EventController::class, 'addEvent'])->name('add.event');
Route::get('/getEventsList', [EventController::class, 'getEventsList'])->name('get.events.list');


Route::get('/displayEventDetails/{id}', [EventController::class, 'displayEventDetails']);
Route::get('/getWodsForEvent', [EventDetailController::class, 'getWodsForEvent']);
Route::get('/getAthleteForEvent', [EventDetailController::class, 'getAthleteForEvent']);

Route::get('/getEventName', [EventController::class, 'getEventName']);

Route::post('/add-wod', [EventDetailController::class, 'addWod'])->name('add.wod');
Route::post('/add-score', [EventDetailController::class, 'addScore'])->name('add.score');
Route::post('/add-athlete', [EventDetailController::class, 'addAthlete'])->name('add.athlete');

Route::get('/getWODDesc', [EventDetailController::class, 'getWODDesc']);
Route::get('/wodDetails/{id}/{wodid}', [EventDetailController::class, 'wodDetails']);
Route::get('/wodResults/{id}', [EventDetailController::class, 'wodResults']);
Route::get('/getAthletesForEvent', [EventDetailController::class, 'getAthletesForEvent']);
Route::get('/searchAthlete', [EventDetailController::class, 'searchAthlete']);

// User Management
// Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'login'])->name('auth.login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('registration');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('pdf-create','pdfcontroller@create');

Route::get('/print-invoice', [InvoiceController::class, 'printInvoice']);

Route::get('/send-email', [MailController::class, 'sendMail']);

Route::get('/getClientLineInfo', [ClientController::class, 'getClientLineInfo']);
Route::get('/getClient', [ClientController::class, 'getClient']);
Route::get('/saveClientToInvoice', [ClientController::class, 'saveClientToInvoice']);

Route::get('/deleteInvoiceLineData', [InvoiceLineController::class, 'deleteInvoiceLineData']);

Route::get('/client-list', [ClientController::class, 'index'])->name('client.list');
Route::post('/edit-client', [ClientController::class, 'editClient'])->name('edit.client');

Route::get('/getProductServicesList', [ProductController::class, 'getProductServicesList']);