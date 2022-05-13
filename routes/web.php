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
use App\Http\Controllers\pdfController;
use App\Http\Controllers\SendMailController;

Route::get('/login', [CustomAuthController::class, 'login']);
Route::get('/registration', [CustomAuthController::class, 'registration']);

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
Route::get('/addEvent', [EventController::class, 'addEvent']);
Route::get('/getEventsList', [EventController::class, 'getEventsList'])->name('get.events.list');

Route::get('/changeEventStatus', [EventController::class, 'changeEventStatus']);

Route::get('/getEventDetails', [EventController::class, 'getEventDetails']);
Route::get('/updateEventData', [EventController::class, 'updateEventData']);

Route::get('/displayEventDetails/{id}', [EventController::class, 'displayEventDetails']);
Route::get('/getWodsForEvent', [EventDetailController::class, 'getWodsForEvent']);
Route::get('/getAthleteForEvent', [EventDetailController::class, 'getAthleteForEvent']);

Route::get('/getGender', [EventController::class, 'getGender']);

Route::get('/getEventName', [EventController::class, 'getEventName']);

Route::post('/add-wod', [EventDetailController::class, 'addWod'])->name('add.wod');
Route::post('/edit-wod', [EventDetailController::class, 'editWod'])->name('edit.wod');
Route::post('/add-score', [EventDetailController::class, 'addScore'])->name('add.score');
Route::post('/add-athlete', [EventDetailController::class, 'addAthlete'])->name('add.athlete');
Route::post('/add-client', [ClientController::class, 'addClient'])->name('add.client');

Route::get('/getWODDesc', [EventDetailController::class, 'getWODDesc']);
Route::get('/getWODDescAndSettings', [EventDetailController::class, 'getWODDescAndSettings']);

Route::get('/updateWod', [EventDetailController::class, 'updateWod']);

Route::get('/wodDetails/{id}/{wodid}', [EventDetailController::class, 'wodDetails']);
Route::get('/wodResults/{id}/{wodid}', [EventDetailController::class, 'wodResults']);
Route::get('/getAthletesForEvent', [EventDetailController::class, 'getAthletesForEvent']);
Route::get('/searchAthlete', [EventDetailController::class, 'searchAthlete']);

Route::get('/populateScoringInputForm', [EventDetailController::class, 'populateScoringInputForm']);
Route::get('/saveInputScoring', [EventDetailController::class, 'saveInputScoring']);

Route::get('/getAllDivisions', [EventDetailController::class, 'getAllDivisions']);
Route::get('/getLeaderBoardData', [EventDetailController::class, 'getLeaderBoardData']);

Route::get('/getOverallStandings', [EventDetailController::class, 'getOverallStandings']);
Route::get('/saveValueScoring', [EventDetailController::class, 'saveValueScoring']);

// User Management
// Route::get('dashboard', [CustomAuthController::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'login'])->name('auth.login');
// Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('registration');
// Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
// Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

Route::get('/pdf-create', [pdfController::class, 'create']);

Route::get('/print-invoice', [InvoiceController::class, 'printInvoice']);
Route::get('/send-email', [MailController::class, 'sendMail']);

Route::get('/getClientLineInfo', [ClientController::class, 'getClientLineInfo']);
Route::get('/getClient', [ClientController::class, 'getClient']);
Route::get('/saveClientToInvoice', [ClientController::class, 'saveClientToInvoice']);

Route::get('/deleteInvoiceLineData', [InvoiceLineController::class, 'deleteInvoiceLineData']);

Route::get('/client-list', [ClientController::class, 'index'])->name('client.list');
Route::post('/edit-client', [ClientController::class, 'editClient'])->name('edit.client');

Route::get('/getProductServicesList', [ProductController::class, 'getProductServicesList']);

Route::post('/updateProductLine', [ProductController::class, 'updateProductLine']);
Route::get('/deleteProduct', [ProductController::class, 'deleteProduct']);

Route::get('/buildAndSendInvoice', [InvoiceController::class, 'buildAndSendInvoice']);

Route::get('/updateSingleInvoiceField', [InvoiceController::class, 'updateSingleInvoiceField']);
Route::get('/send/mail', [SendMailController::class, 'send_mail'])->name('send_mail');