<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGasStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gas_station', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('city')->default('');
            $table->string('address')->default('');
            $table->string('phone')->default('');
            $table->string('lat')->default('');
            $table->string('lng')->default('');
            $table->string('tags_service')->default('');
            $table->string('tags_fuel')->default('');
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
        Schema::drop('gas_station');
    }
}
