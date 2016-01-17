<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSteamUsersCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steam_users_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('user_id')->unsigned(); // the User whose profile we are commenting on
            $table->foreign('user_id')->references('id64')->on('steam_users');

            $table->bigInteger('commenter_id')->unsigned(); // the User who commented
            $table->foreign('commenter_id')->references('id64')->on('steam_users');

            $table->string('comment'); // 255 Character Limit
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
        Schema::drop('steam_users_comments');
    }
}
