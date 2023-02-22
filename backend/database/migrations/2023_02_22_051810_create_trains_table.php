<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('trains', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->dateTime('journey_date');
      $table->unsignedBigInteger('route_id');
      $table->timestamps();

      $table->foreign('route_id')->references('id')->on('train_lists');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('trains');
  }
}
