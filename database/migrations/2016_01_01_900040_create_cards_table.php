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
            $table->integer('id')->unique();
            $table->string('code')->index();
            $table->integer('transaction_id');
            $table->string('name')->default('');
            $table->tinyInteger('gender')->default(0);
            $table->string('phone')->default('');
            $table->dateTime('birthday_at')->nullable();
            $table->boolean('verified')->default(false);
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
        Schema::drop('cards');
    }
}
