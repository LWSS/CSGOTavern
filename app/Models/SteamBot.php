<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SteamBot
 *
 * @property integer $id
 * @property string $ip
 * @property integer $port
 * @property string $key
 * @property string $error_message
 * @property integer $capacity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot wherePort($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereErrorMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereCapacity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereUpdatedAt($value)
 * @property integer $id64
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamBot whereId64($value)
 */
class SteamBot extends Model
{
    public $timestamps = true;
    protected $table = 'steam_bots';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id64',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'ip',
        'port',
        'key',
        'error_message',
    ];

    /* Shutdown All Bots
     * Returns null if all bots shutdown Correctly
     * Otherwise, it will return Comma Delimited ID's of Bad Bot ID's
     */
    public static function mayday()
    {
        $bots = \App\Models\SteamBot::all();
        $badBots = '';
        foreach ($bots as $bot) {
            if (\App\Http\Controllers\API\Bots\SteamBotController::botPost(array('Command' => 'shutdown'), $bot->ip, $bot->port) != 'GOODBYE') {
                $badBots .= $bot->id . ',';
            }
        }
        if ($badBots != '') {
            return $badBots;
        }
        return null;
    }

    /*
     * Shutdown a Single Bot
     * Takes the Bot's ID as an Argument
     * returns true if successful, otherwise false.
     */
    public static function shutdownBot($Bot_ID)
    {
        $bot = \App\Models\SteamBot::find($Bot_ID);
        if ($bot != null) {
            if (\App\Http\Controllers\API\Bots\SteamBotController::botPost(array('Command' => 'shutdown'), $bot->ip, $bot->port) == 'GOODBYE') {
                return true;
            }
        }
        return false;
    }

    /* Returns the ID of a Random Bot */
    public static function randomBot()
    {
        $botCount = \App\Models\SteamBot::where('capacity', '<', 950)->count();
        if ($botCount >= 1) {
            return mt_rand(1, $botCount);
        } else {
            return null;
        }

    }
}
