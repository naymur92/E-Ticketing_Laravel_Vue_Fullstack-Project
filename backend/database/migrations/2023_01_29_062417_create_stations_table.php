<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->id();
            $table->string(column: 'name');
            $table->string(column: 'address');
            $table->decimal(column: 'lat', total: 10, places: 7);
            $table->decimal(column: 'lon', total: 10, places: 7);
            $table->timestamps();

            $table->unique(['name', 'address', 'lat', 'lon']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stations');
    }
}
