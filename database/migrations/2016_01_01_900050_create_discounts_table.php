<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('card_id')->index();
            $table->dateTime('date');
            $table->decimal('amount', 8, 2);
            $table->decimal('volume', 6, 2);
            $table->decimal('price', 5, 2);
            $table->string('fuel_name');
            $table->string('azs');
            $table->decimal('point', 4, 2)->nullable();
            $table->decimal('rate', 4, 2)->nullable();
            $table->dateTime('start_at')->nullable();
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
        Schema::drop('discounts');
    }
}
