<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWodsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wods', function (Blueprint $table) {
			$table->increments('id');
			$table->string('wodname');
			$table->string('woddesc');
			$table->unsignedInteger('wodtype');
			$table->unsignedInteger('event_id');
			$table->timestamps();
			$table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
		});

		Schema::create('settings', function (Blueprint $table) {
			$table->increments('id');
			$table->string('settingname');
			$table->string('settingdesc');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('wods');
	}
}
