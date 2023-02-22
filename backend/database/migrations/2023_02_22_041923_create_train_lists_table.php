<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('train_lists', function (Blueprint $table) {
            $table->id();
            $table->string('train_name');
            $table->string('off_day')->nullable();
            $table->unsignedTinyInteger('up_down')->comment('0=up, 1=down');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('train_lists');
    }
}
