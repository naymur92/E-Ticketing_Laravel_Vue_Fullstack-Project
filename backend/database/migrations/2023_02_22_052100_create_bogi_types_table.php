<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBogiTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bogi_types', function (Blueprint $table) {
            $table->id();
            $table->string('bogi_type_name', 20)->comment('shovon, s_chair, f_chair, f_seat, f_berth, snigdha, ac_s, ac_b');
            $table->unsignedTinyInteger('seat_count')->comment('number of seats in this type bogi');
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
        Schema::dropIfExists('bogi_types');
    }
}
