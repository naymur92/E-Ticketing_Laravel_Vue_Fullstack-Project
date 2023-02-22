<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBogisTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('bogis', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->unsignedBigInteger('train_id');
      $table->integer('style')->default(0)->comment('0=shovon, 1=shovon chair, 2=f_chair, 3=f_seat, 4=f_berth, 5=snigdha, 6=ac_s, 7=ac_b');
      $table->timestamps();

      $table->foreign('train_id')->references('id')->on('trains')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('bogis');
  }
}
