<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tickets', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger(column: 'station_from');
      $table->unsignedBigInteger(column: 'station_to');
      $table->unsignedBigInteger(column: 'user_id');
      $table->unsignedBigInteger(column: 'train_id');
      $table->unsignedBigInteger(column: 'seat_id');
      $table->unsignedMediumInteger(column: 'price');
      $table->dateTime(column: 'journey_time');
      $table->string(column: 'train_name');
      $table->string(column: 'bogi_name');
      $table->string(column: 'seat_name');
      $table->unsignedTinyInteger(column: 'adult');
      $table->unsignedTinyInteger(column: 'child')->nullable();
      $table->timestamps();

      $table->foreign('station_from')->references('id')->on('stations');
      $table->foreign('station_to')->references('id')->on('stations');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('train_id')->references('id')->on('trains');
      $table->foreign('seat_id')->references('id')->on('seats');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('tickets');
  }
}
