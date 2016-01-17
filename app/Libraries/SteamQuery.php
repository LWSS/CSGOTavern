<?php
/**
 * Created by PhpStorm.
 * User: bbcha_000
 * Date: 8/21/2015
 * Time: 4:28 PM
 */

namespace App\Libraries;
use Config;

class SteamQuery
{

    public static function getInventory($id64, $array = false)
    {
        $inventoryLink = 'http://steamcommunity.com/profiles/' . $id64 . '/inventory/json/730/2';
        $json = SteamQuery::getJson($inventoryLink);
        if ($json === null) {
            return null;
        }
        $json_output = ($array ? json_decode($json, true) : json_decode($json));
        return $json_output;
    }
    /* Gets the Steam User's Inventory, 2nd Param is flag for Whether or not to return an array instead of an object */

    public static function getJson($url)
    {
        $json = @file_get_contents($url);
        if ($json === false || empty($json)) {
            return null;
        }
        return $json;
    }
    /* Returns the players Inventory or Null on fail */

    public static function getInventoryAPI( $id64, $array = false ){
        $API_link = 'http://api.steampowered.com/IEconItems_730/GetPlayerItems/v0001/?key=' . Config::get('steam.apikey') . '&format=json&steamid=' . $id64;
        //http://api.steampowered.com/IEconItems_730/GetPlayerItems/v0001/?key=061F6498A17352AD0B52FB4A377F9BC5&format=json&steamid=76561197973578969
        $json = SteamQuery::getJson( $API_link );
        if ($json === null) {
            return null;
        }
        $json_output = ( $array ? json_decode( $json, true ) : json_decode( $json ));
        return $json_output;
    }
    /* Returns Player Summary or Null on fail */
    public static function getPlayerSummary( $id64, $array = false ) {
        $API_link = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=' . Config::get('steam.apikey') . '&format=json&steamids=' . $id64;
        $json = SteamQuery::getJson( $API_link );
        $playerSummary = ( $array ? json_decode( $json, true ) : json_decode( $json ));
        if ($array === true) {
            if(empty($playerSummary['response']['players'][0])) {
                return null;
            }
        } else if (empty($playerSummary->response->players[0])) {
            return null;
        }
        return $playerSummary;
    }
}