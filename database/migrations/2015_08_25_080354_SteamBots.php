<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class SteamBots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steam_bots', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('id64')->unsigned()->unique();
            $table->string('ip');
            $table->integer('port')->unsigned();
            $table->string('key');
            $table->string('error_message')->nullable();
            $table->smallInteger('capacity')->default(0)->unsigned(); // up to 65,535, How many items the bot has, should only go to 999
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
        Schema::drop('steam_bots');
    }
}
