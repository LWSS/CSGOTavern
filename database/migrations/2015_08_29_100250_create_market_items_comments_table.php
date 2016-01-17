<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarketItemsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_items_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('market_id')->unsigned(); // Market Item that is being commented on
            $table->foreign('market_id')->references('id')->on('market_items');

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
        Schema::drop('market_items_comments');
    }
}
