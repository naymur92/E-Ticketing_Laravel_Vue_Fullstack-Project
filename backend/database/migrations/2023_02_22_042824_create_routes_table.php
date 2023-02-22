<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->unsignedBigInteger('route_id');
            $table->unsignedBigInteger('station_id');
            $table->time('time_from_prev_station')->nullable();
            $table->unsignedTinyInteger('sl_no');
            $table->timestamps();

            $table->foreign('route_id')->references('id')->on('train_lists');
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
        Schema::dropIfExists('routes');
    }
}
