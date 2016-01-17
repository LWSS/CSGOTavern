<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSteamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steam_users', function ( Blueprint $table ) {
            $table->bigInteger('id64')->unsigned()->unique();
            $table->primary('id64');
            $table->string('password')->nullable();
            $table->string('username');
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('trade_token')->nullable();
            $table->integer('tavern_tokens')->default(0)->unsigned();
            $table->integer('visibility_state'); // 3 = public
            $table->string('avatar_url');
            $table->boolean('developer')->default(0); // Developer flag
            $table->boolean('anonymous')->default(0); // Anonymous Listings Flag
            $table->boolean('lock3d')->default(0); // LockScreen Animation
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
        Schema::drop('steam_users');
    }
}
