<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMarketItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bot_id')->unsigned(); // the Assigned Bot
            $table->foreign('bot_id')->references('id')->on('steam_bots');

            $table->bigInteger('user_id')->unsigned(); // the User who owns the Item
            $table->foreign('user_id')->references('id64')->on('steam_users');

            $table->bigInteger('buyer_id')->unsigned()->nullable(); // the User who bought the item from the site
            $table->foreign('buyer_id')->references('id64')->on('steam_users');

            $table->bigInteger('trade_id')->unsigned()->unique()->nullable(); // trade# the Bot sends back, you can use this to lookup the trade
            $table->bigInteger('asset_id')->unsigned()->unique()->nullable(); // Instance ID of the Item, Changes on Trade, Bot Uses this to determine which item to give away, if this is set, it means that the item is in our possession
            $table->integer('price'); // Price in tokens of the item ( up to 2 Billion )
            $table->string('item_name');
            $table->string('description')->nullable(); // User Set Description of the Listing.
            $table->string('item_img')->nullable();
            $table->string('inspect_url')->nullable();
            $table->tinyInteger('last_status')->unsigned()->nullable(); // Status on the last Trade offer this was Associated with codes 0-255 Available
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
        Schema::drop('market_items');
    }
}
