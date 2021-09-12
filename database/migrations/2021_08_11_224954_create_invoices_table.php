<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_name');
            $table->string('invoice_desc');
            $table->decimal('invoiceTotal',13,2)->default(0.00);
            $table->unsignedInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}


/*

add-invoice-form

			// alert('Load');

			// toastr.options.preventDuplicates = true;

			// $.ajaxSetup({
			// 	headers: ( 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') )
			// });

			// {{ route('add.invoice') }}

*/