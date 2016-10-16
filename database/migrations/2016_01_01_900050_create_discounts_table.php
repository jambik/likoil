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
            $table->increments('id');
            $table->integer('DiscountID');
            $table->integer('DiscountCardID');
            $table->dateTime('Date');
            $table->decimal('Amount', 8, 2);
            $table->decimal('Volume', 6, 2);
            $table->decimal('Price', 5, 2);
            $table->string('FuelName');
            $table->string('AZSCode');
            $table->timestamps();

            $table->index('DiscountID');
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
        Schema::drop('discounts');
    }
}
