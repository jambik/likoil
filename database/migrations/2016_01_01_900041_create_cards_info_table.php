<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards_info', function (Blueprint $table) {
            $table->integer('card_id')->unique();
            $table->string('name')->default('');
            $table->string('last_name')->default('');
            $table->string('patronymic')->default('');
            $table->tinyInteger('gender')->default(0);
            $table->string('phone')->default('');
            $table->dateTime('birthday_at')->nullable();
            $table->string('card_number')->default('');
            $table->string('issue_place')->default('');
            $table->string('type')->default('');
            $table->dateTime('issued_at')->nullable();
            $table->string('document_type')->default('');
            $table->string('document_number')->default('');
            $table->dateTime('document_at')->nullable();
            $table->string('document_issued')->default('');
            $table->string('car_brand')->default('');
            $table->string('car_number')->default('');
            $table->dateTime('indate_at')->nullable();
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
        Schema::drop('cards_info');
    }
}
