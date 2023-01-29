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
            $table->unsignedBigInteger('station_id');
            $table->time('time');
            $table->float('ac_b_price');
            $table->float('ac_s_price');
            $table->float('snigdha_price');
            $table->float('f_berth_price');
            $table->float('f_seat_price');
            $table->float('f_chair_price');
            $table->float('s_chair_price');
            $table->float('shovon_price');
            $table->timestamps();

            $table->foreign('train_id')->references('id')->on('trains');
            $table->foreign('station_id')->references('id')->on('stations');
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
