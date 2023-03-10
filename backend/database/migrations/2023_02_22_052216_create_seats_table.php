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
      $table->string('seat_name');
      $table->unsignedBigInteger('bogi_id');
      $table->unsignedTinyInteger('booked')->default(0)->comment('0=open, 1=selected, 2=booked');
      $table->timestamps();

      $table->foreign('bogi_id')->references('id')->on('bogis')->onDelete('cascade');
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
