<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alter1CardsInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards_info', function (Blueprint $table) {
            $table->string('password')->after('indate_at')->default('');
            $table->integer('user_id')->after('password')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards_info', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
