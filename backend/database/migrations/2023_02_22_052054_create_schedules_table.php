<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schedules', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('train_id');
      $table->unsignedBigInteger('from_station_id');
      $table->unsignedBigInteger('to_station_id');
      $table->dateTime('left_station_at');
      $table->dateTime('reach_destination_at');
      $table->float('ac_b_price')->nullable();
      $table->float('ac_s_price')->nullable();
      $table->float('snigdha_price')->nullable();
      $table->float('f_berth_price')->nullable();
      $table->float('f_seat_price')->nullable();
      $table->float('f_chair_price')->nullable();
      $table->float('s_chair_price')->nullable();
      $table->float('shovon_price')->nullable();
      $table->timestamps();


      $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
      $table->foreign('from_station_id')->references('id')->on('stations')->onDelete('cascade');
      $table->foreign('to_station_id')->references('id')->on('stations')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('schedules');
  }
}
