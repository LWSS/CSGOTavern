<?php

use Illuminate\Database\Migrations\Migration;

class AddSentinelSupportForSteamUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table( 'users', function ( $table ) {
            $table->string( 'email', 255 )->nullable()->change();
            $table->string( 'password', 255 )->nullable()->change();

            $table->string( 'display_name', 255 )->nullable()->after( 'last_name' );
            $table->string( 'trade_token', 255 )->nullable()->after( 'display_name' );
            $table->integer( 'tavern_tokens' )->default( 0 )->unsigned()->after( 'trade_token' );
            $table->integer( 'visibility_state' )->default( 3 )->after( 'password' ); // 3 = public
            $table->longText( 'avatar_url' )->nullable()->after( 'tavern_tokens' );
        } );
        Schema::table( 'steam_users', function ( $table ) {
            if ( Schema::hasColumn( 'steam_users', 'username' ) && !Schema::hasColumn( 'steam_users', 'display_name' ) ) {
                $table->renameColumn( 'username', 'display_name' );
            }
            $table->dropColumn( [ 'tavern_tokens', 'email', 'password' ] );
            $table->integer( 'user_id' )->unsigned()->after( 'id64' );
            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' );

        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table( 'users', function ( $table ) {
            $table->string( 'email', 255 )->change();
            $table->string( 'password', 255 )->change();

            $table->dropColumn( [ 'display_name', 'trade_token', 'tavern_tokens', 'visibility_state', 'avatar_url' ] );
        } );
        Schema::table( 'steam_users', function ( $table ) {
            $table->renameColumn( 'display_name', 'username' );
            $table->dropForeign( 'steam_users_user_id_foreign' );
            $table->dropColumn( 'user_id' );

            $table->string( 'password' )->nullable()->after( 'id64' );
            $table->string( 'email' )->nullable()->after( 'display_name' );
            $table->integer( 'tavern_tokens' )->default( 0 )->unsigned();
        } );
    }
}
