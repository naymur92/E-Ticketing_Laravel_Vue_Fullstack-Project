<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('seats', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('bogi_id');
      $table->unsignedBigInteger('train_id');
      $table->unsignedBigInteger('type')->default(0)->comment('0=shovon, 1=shovon chair, 2=f_chair, 3=f_seat, 4=f_berth, 5=snigdha, 6=ac_s, 7=ac_b');
      $table->unsignedBigInteger('booked')->default(0)->comment('0=open, 1=booked');
      $table->timestamps();

      $table->foreign('bogi_id')->references('id')->on('bogis');
      $table->foreign('train_id')->references('id')->on('trains');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('seats');
  }
}
