<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Libraries\SteamQuery;
use App\Models\SteamUser;
use App\Models\TavernUser;
use Cache;
use Exception;
use HipChat;
use Illuminate\Routing\Redirector;
use Log;
use Sentinel;
use Session;
use SteamLogin;

class SteamController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Sentinel::setModel( 'App\Models\TavernUser' );
    }

    public static function getParsedInventoryRaw()
    {
        if ( SteamUser::check() === true ) {
            $invData = Cache::remember( 'inv_' . SteamUser::getID(), 10, function () {
                return SteamQuery::getInventory( SteamUser::getID(), true );
            } );
            if ( $invData === null || !isset( $invData['rgInventory'] ) ) {
                return null;
            }
            $inventoryArray = array();
            foreach ( $invData['rgInventory'] as $itemid => $info ) {
                $inventoryArray[$info['pos']] = array(
                    'info' => $info,
                    'desc' => $invData['rgDescriptions'][$info['classid'] . '_' . $info['instanceid']],
                );
            }
            return $inventoryArray;
        }
        return null;
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|Redirector
     * @throws \Exception
     */
    public function login()
    {
        try {
            return $this->loginOrNew( strval(SteamLogin::validate()) ); // validate returns an ID64, or throws an error
        } catch ( Exception $e ) {
            // Re-attempt to authenticate them if it failed
            // TODO: Handle multiple failed attempts to login through steam
            return redirect( SteamLogin::url( route( 'steam.oauth.callback' ) ) );
        }
    }

    private function loginOrNew( $id64 )
    {
        $steamUser = SteamUser::find( strval($id64) );
        /** @var TavernUser $user */
        $user = Sentinel::check();
        //dd($steamUser->user);

        if ( $user != false && $steamUser != null ) { // If the user is logged in and the steam user is part of our records
            // User is already fully logged in OR they are trying to get into someone else's account
            if ( $steamUser->user->id != $user->id ) {
                //HipChat::message_room(Config::get('services.hipchat.room.id'), 'Tavern Website', $msg, true, 'red');
                HipChat::message(
                    "<strong>Security Warning: </strong> the user(".$user->id.") attempted to log into " .
                    "a steam account(".$id64.") that is bound to another account(".$steamUser->user->id.")"
                    , true, \HipChat\HipChat::COLOR_RED);
                //Log::
            }
            return redirect( '/' );

        } else if ( $user === false && $steamUser === null ) { // The user is not logged in and this is a new steam user

            $user = new TavernUser();
            $user->save();
            SteamUser::createNewUser( $id64, $user->id );
            Sentinel::login( $user, true );

        } else if ( $user != false && $steamUser === null ) { // User exists but doesn't have a steam account attached.

            SteamUser::createNewUser( $id64, $user->id );
            Sentinel::login( $user, true );

        } else if ($user === false && $steamUser != null) { // Steam user exists in our database

            if ( $steamUser->user->password === null ) {
                $this->fastLogin( $steamUser->user );
            } else {
                Session::set('locked', true);
                $this->requestSecureLogin( $user, $steamUser );
            }

        }

        if (Session::has('locked') && Session::get('locked') === true) {
            return redirect('/lock');
        }
        return ( Session::has( 'lastpage' ) ? redirect( Session::get( 'lastpage' ) ) : redirect( '/' ) );
    }

    /**
     * @param TavernUser $user
     */
    private function fastLogin( $user )
    {
        Sentinel::login( $user, true );
    }

    /**
     * @param TavernUser $user
     * @param SteamUser $steamUser
     */
    private function requestSecureLogin( $user, $steamUser )
    {
        if($steamUser->user != null) {
            Sentinel::login( $steamUser->user, true );
        } else {
            Sentinel::login( $user, true );
        }
        /*
        Sentinel::logout();
        Session::put( 'steam.auth.' );
        return view( 'pages.user.secure-login' );
        */
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect( '/' );
    }

    private function newTavernUser( $id64 )
    {
        $steamUser = $this->newSteamUser( $id64 );
        $user = new TavernUser();
        $user->primary_steam_id64 = $id64;
        dd( $user->save() );
    }

    /* Returns an Array of inventory Data, or null */

    private function newSteamUser( $id64 )
    {
        dd( SteamUser::createNewUser( $id64 ) );
    }
}
