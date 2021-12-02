<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAthletesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('athletes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('cellphone');
            $table->string('email');
            $table->unsignedInteger('athletetype_id');
            $table->unsignedInteger('gender_id');
            $table->unsignedInteger('wod_id');
            $table->timestamps();
            $table->foreign('wod_id')->references('id')->on('wods')->onDelete('cascade');
            $table->foreign('athletetype_id')->references('id')->on('settings')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('athletes');
    }
}
