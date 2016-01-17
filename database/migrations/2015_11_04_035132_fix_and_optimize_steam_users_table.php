<?php

use Illuminate\Database\Migrations\Migration;

class FixAndOptimizeSteamUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'steam_users', function ( $table ) {
            $table->renameColumn( 'id64', 'id' );
            $table->dropColumn( [ 'first_name', 'last_name' ] );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'steam_users', function ( $table ) {
            $table->renameColumn( 'id', 'id64' );
            $table->string( 'first_name' )->nullable()->after( 'display_name' );
            $table->string( 'last_name' )->nullable()->after( 'first_name' );
        } );
    }
}
