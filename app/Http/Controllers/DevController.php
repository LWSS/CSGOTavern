<?php

namespace App\Http\Controllers;

use App;
use App\Models\SteamUser;
use App\Models\TavernUser;
use Config;
use HipChat;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;

class DevController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if ( !config( 'app.debug' ) ) {
            abort( 403, 'Unauthorized action.' );
        }
    }

    public function getIndex()
    {
        dd("");
    }

    public function getHipchatrooms()
    {
        foreach(HipChat::get_rooms() as $room){
            echo " - $room->room_id = $room->name\n";
            echo "<br>";
        }
        //HipChat::message_room()
    }

    public function getHipchatmessage($message)
    {
        $msg = "<strong>Test</strong>";
        HipChat::message($msg, true, 'red');
    }

    public function getUseraddresses()
    {
        /** @var App\Models\TavernUser $user */
        $user = TavernUser::find(1);
        $address = new App\Models\UserAddress();
        dd($user->cards->all());

    }

    public function getSteamuser()
    {
        dd(Sentinel::check()->steamusers->first());
    }

    public function getUser()
    {
        dd(Sentinel::check());
    }

    public function getSteamuser2($id = 76561198060851022)
    {
        $steamUser = SteamUser::find( $id );
        dd($steamUser);
    }
}
