<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('DiscountCardID');
            $table->string('Code')->unique();
            $table->integer('TransactionID');
            $table->string('name')->default('');
            $table->tinyInteger('gender')->default(0);
            $table->string('phone')->default('');
            $table->dateTime('birthday_at');
            $table->boolean('verified')->default(false);
            $table->timestamps();

            $table->index('DiscountCardID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cards');
    }
}
