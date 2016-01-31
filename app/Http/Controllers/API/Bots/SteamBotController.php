<?php

namespace App\Http\Controllers\API\Bots;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Exception;

class SteamBotController extends Controller
{
    /**********************************/
    /********** Bot Commands **********/
    /**********************************/
    public static function sendItem($id64, $marketItem, $tradeToken, $msg)
    {
        // $item = MarketItems::find($marketID);
        $marketItem->last_status = null; // set this to null so that we can look at the status of the sendOffer
        $marketItem->save();
        $bot = \App\Models\SteamBot::find($marketItem->bot_id);
        $data = array(
            'Command' => 'send',
            'id64' => $id64,
            'itemID' => $marketItem->asset_id,
            'token' => $tradeToken,
            'msg' => $msg,
            'marketID' => $marketItem->id,
        );
        return \App\Http\Controllers\API\Bots\SteamBotController::botPost($data, $bot->ip, $bot->port);
    }

    public static function botPost($data, $BotIP, $BotPort, $getResult = true)
    {
        $url = 'http://' . $BotIP . ':' . $BotPort;
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        if ($getResult) {
            try {
                $result = file_get_contents($url, false, $context);
                return $result;
            } catch (Exception $e) {
                return null;
            }
        } else {
            try {
                file_get_contents($url, false, $context);
            } catch (Exception $e) {
                return null;
            }
        }
    }

    public static function sendItemMulti($Bot_ID, $id64, $tradeToken, $itemIDArray, $itemCount, $msg)
    {

    }

    public static function receiveItem($marketItem, $itemID, $tradeToken, $msg)
    {
        $bot = \App\Models\SteamBot::find($marketItem->bot_id);
        $data = array(
            'Command' => 'receive',
            'id64' => $marketItem->user_id,
            'itemID' => $itemID,
            'token' => $tradeToken,
            'msg' => $msg,
            'marketID' => $marketItem->id
        );
        return \App\Http\Controllers\API\Bots\SteamBotController::botPost($data, $bot->ip, $bot->port);
    }

    /* Returns Bot's Inventory in Json, returns Exception converted to string if fail */

    public static function receiveItemMulti($Bot_ID, $id64, $tradeToken, $itemIDArray, $itemCount, $msg)
    {

    }

    /* Handles Bot Callbacks */

    public static function getBotJson($Bot_ID)
    {
        $bot = \App\Models\SteamBot::find($Bot_ID);
        $url = 'http://' . $bot->ip . ':' . $bot->port;
        $data = array('Command' => 'jsonInventoryDump');

        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        try {
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            return $result;
        } catch (Exception $e) {
            return $e;
        }
    }

    public static function processBotRequest()
    {
        $BotUser = substr($_SERVER['HTTP_USER_AGENT'], strpos($_SERVER['HTTP_USER_AGENT'], "_") + 1);
        $botLookup = \App\Models\SteamBot::where('ip', $_SERVER['REMOTE_ADDR'])->where('key', $BotUser)->first();
        if ($botLookup === null) { // Invalid Bot Secret Key
            return 'This is our town SCRUB! Yeah, Beat it!';
        }
        if (!isset($_POST['Command'])) {
            return 'Heh heh heh, its time for a little blood.';
        }
        switch ($_POST['Command']) {
            case 0: // Error with Bot
                $botLookup->error_message = $_POST['Message'];
                $botLookup->save();
                break;
            case 1: // Single Receive Item
                if (isset($_POST['error'])) {
                    // Item was not Sent to Us, we should probably tell them why
                    break;
                }
                if (isset($_POST['marketID']) && isset($_POST['tradeID'])) {
                    // Offer has been Sent to User
                    $item = \App\Models\MarketItems::find($_POST['marketID']);
                    if ($item !== null) {
                        $item->trade_id = $_POST['tradeID'];
                        $item->save();
                    }
                }
                if (isset($_POST['state']) && isset($_POST['tradeID'])) {
                    $item = \App\Models\MarketItems::where('trade_id', $_POST['tradeID'])->first(); // this is unique, there should only be 1 row,
                    if ($item === null) {
                        throwException('Meme');
                        // Error, couldn't find the Item based on trade_id
                        // This Means we Received an Item and don't know which one it is
                        break;
                    }
                    switch ($_POST['state']) {
                        case 3: // Offer Accepted
                            $item->asset_id = $_POST['assetID'];
                            $item->last_status = 3;
                            $botLookup->capacity = $botLookup->capacity + 1;
                            $botLookup->save();
                            break;
                        case 5: // Offer Expired
                            $item->last_status = 5;
                            $item->trade_id = null;
                            break;
                        case 6: // Offer Canceled by Us, ( bot has a timeout )
                            $item->last_status = 6;
                            $item->trade_id = null;
                            break;
                        case 7: // Offer Declined
                            $item->last_status = 7;
                            $item->trade_id = null;
                            break;
                        case 8: // Items Invalid, Means they got rid of whatever they were gonna give us
                            $item->last_status = 8;
                            $item->trade_id = null;
                            break;
                        case 10:// Offer Canceled via Email
                            $item->last_status = 10;
                            $item->trade_id = null;
                            break;
                        case 11:// In Escrow
                            $item->last_status = 11;
                    }
                    $item->save();
                }
                break;
            case 2: // ReceiveMulti
                break;
            case 3: // Send
                if (isset($_POST['error'])) { // Error Sending Trade Offer
                    // Item was not Sent to User, we should probably tell them why
                    break;
                }
                if (isset($_POST['marketID']) && isset($_POST['tradeID'])) {
                    // Offer has been Sent to User
                    $item = \App\Models\MarketItems::find($_POST['marketID']);
                    if ($item !== null) {
                        $item->trade_id = $_POST['tradeID'];
                        $item->save();
                    }
                }
                if (isset($_POST['state'])) {
                    $item = \App\Models\MarketItems::where('trade_id', $_POST['tradeID'])->first(); // this is unique, there should only be 1 row,
                    if ($item === null) {
                        // Error Couldn't find Row based on trade_id
                        // This means the TradeOffer State of an Item has Changed on an unknown Item
                        break;
                    }
                    switch ($_POST['state']) {
                        case 3:  // Offer Accepted
                            $item->asset_id = null;
                            $item->last_status = 3;
                            $botLookup->capacity = $botLookup->capacity - 1;
                            $botLookup->save();
                            if ($item->buyer_id === null) {
                                $item->delete();
                            } else {
                                $item->save();
                            }
                            break;
                        case 5: // Offer Expired
                            $item->last_status = 5;
                            $item->buyer_id = null; // unset the buyer, the offer expired, refund him and relist this
                            $item->trade_id = null; // unset the trade_id so we know an offer isn't pending/completed
                            $item->save();
                            break;
                        case 6: // Offer Canceled by Us, ( bot has a timeout )
                            $item->last_status = 6;
                            $item->trade_id = null; // unset the trade_id so we know an offer isn't pending/completed
                            $item->save();
                            break;
                        case 7: // Offer Declined
                            $item->last_status = 7;
                            $item->buyer_id = null; // Unset buyer
                            $item->trade_id = null; // unset the trade_id so we know an offer isn't pending/completed
                            $item->save();
                            break;
                        case 8: // Items Invalid
                            // TODO: Shutdown all Bots or do something drastic if this happens
                            // TODO: This Means that An Item was Knabbed from a Bot without Us Knowing
                            // TODO: Could also mean that a Steam asset_id changed while the item is in our Inventory
                            // TODO: An asset_id should only change if an item is changed or modified (added nametag, sticker, etc.), but I heard one rumor that steam can change them
                            $item->last_status = 8;
                            $item->save();
                            break;
                        case 10:// Offer Canceled via Email
                            $item->last_status = 10;
                            $item->buyer_id = null; // Unset Buyer
                            $item->trade_id = null; // unset the trade_id so we know an offer isn't pending/completed
                            $item->save();
                            break;
                        case 11:// In Escrow
                            $item->last_status = 11;
                            $item->save();
                    }
                }
                break;
            case 4: // SendMulti
                break;
        }
        return 'OK';
    }
}
