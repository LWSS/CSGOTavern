<?php

namespace App\Models;

use App\Libraries\SteamQuery;
use Carbon\Carbon;
use Cartalyst\Attributes\EntityInterface;
use Cartalyst\Attributes\EntityTrait;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Sentinel;
use Session;

/**
 * App\Models\SteamUser
 *
 * @property-read Collection|SteamUsersComments[] $comments
 * @method static Builder|SteamUser whereid( $value )
 * @method static Builder|SteamUser first()
 * @method static Builder|SteamUser wherePassword( $value )
 * @method static Builder|SteamUser whereUsername( $value )
 * @method static Builder|SteamUser whereEmail( $value )
 * @method static Builder|SteamUser whereFirstName( $value )
 * @method static Builder|SteamUser whereLastName( $value )
 * @method static Builder|SteamUser whereTradeToken( $value )
 * @method static Builder|SteamUser whereTavernTokens( $value )
 * @method static Builder|SteamUser whereVisibilityState( $value )
 * @method static Builder|SteamUser whereAvatarUrl( $value )
 * @method static Builder|SteamUser whereDeveloper( $value )
 * @method static Builder|SteamUser whereLastLogin( $value )
 * @method static Builder|SteamUser whereCreatedAt( $value )
 * @method static Builder|SteamUser whereUpdatedAt( $value )
 * @method static Builder|SteamUser whereAnonymous( $value )
 * @property integer $id
 * @property integer $user_id
 * @property string $display_name
 * @property string $first_name
 * @property string $last_name
 * @property string $trade_token
 * @property integer $visibility_state
 * @property string $avatar_url
 * @property boolean $developer
 * @property boolean $anonymous
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read Customer $customer
 * @property-read TavernUser $user
 */
class SteamUser extends Model implements EntityInterface
{
    use EntityTrait;
    const sessionVariable = 'steam_user';
    /**
     * {@inheritDoc}
     */
    protected static $entityNamespace = 'tavern/steamuser';
    public $timestamps = true;
    protected $table = 'steam_users';
    protected $primaryKey = 'id';
    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'value',
    ];
    /**
     * {@inheritDoc}
     */
    protected $with = [
        'values.attribute',
    ];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public static function getID()
    {
        if ( Sentinel::check() ) {
            if ( count( Sentinel::getUser()->steamusers ) > 0 )
                return Sentinel::getUser()->steamusers->first()->id;
        }
        return null;
    }

    /**
     * @return SteamUser|null
     */
    public static function getSession()
    {
        if ( Session::has( SteamUser::sessionVariable ) === true ) {
            return Session::get( SteamUser::sessionVariable );
        }
        return null;
    }

    /**
     * Check if the user is logged into steam
     *
     * @param bool $getuser return SteamUser or boolean
     * @return SteamUser|false if logged in, otherwise false
     */
    public static function check( $getuser = false )
    {
        /** @var TavernUser $user */
        $user = Sentinel::check();
        if ( $user != false ) {
            return $getuser ? $user->steamusers->first() : true;
        }
        return false;
    }

    public static function createNewUser( $id, $uid )
    {
        $playerData = SteamQuery::getPlayerSummary( $id );
        if ( $playerData !== null ) {
            $steamUser = new SteamUser();
            $steamUser->id = $id;
            $steamUser->user_id = $uid;
            $steamUser->display_name = $playerData->response->players[0]->personaname;
            $steamUser->visibility_state = $playerData->response->players[0]->communityvisibilitystate;
            $steamUser->avatar_url = $playerData->response->players[0]->avatarfull;
            $steamUser->save();
            return $steamUser;
        } else {
            throw new Exception( 'Error Contacting Steam SteamUser@createNewUser' );
        }
    }

    /* This Function Will Query Steam and get the Player's Steam Information
       Takes id as a mandatory argument, setSession will update the session if needed
       Returns a Mapped Array of the player's info */
    public static function updateInfo( $id, $setSession = false )
    {
        $playerData = SteamQuery::getPlayerSummary( $id );
        if ( $playerData !== null ) {
            $steamUser = SteamUser::find( $id );
            $steamUser->display_name = $playerData->response->players[0]->personaname;
            $steamUser->visibility_state = $playerData->response->players[0]->communityvisibilitystate;
            $steamUser->avatar_url = $playerData->response->players[0]->avatarfull;
            $steamUser->save();
            if ( $setSession ) {
                Session::set( SteamUser::sessionVariable, $steamUser );
            }
            return $steamUser;
        } else {
            throw new Exception( 'Error Contacting Steam SteamUser@updateInfo' );
        }
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param  int $id
     * @param  array $columns
     * @return mixed|static
     */
//    public static function find( $id, $columns = [ '*' ] )
//    {
//        return SteamUser::where( 'id', '=', strval( $id ) )->first( $columns );
//    }
    /* this function will NOT contact Steam at all.
        this will query the database for the user and update our info we have for them
        EX: updating tokens
        Needs an id
        returns true, or null if user not found.
        */
    public static function updateSession( $id )
    {
        $user = SteamUser::find( $id );
        if ( $user === null ) {
            return null;
        }
        Session::set( SteamUser::sessionVariable, $user );
        return true;
    }


    public static function checkForAccount( $id )
    {

    }

    public function customer()
    {
        return $this->hasOne( 'App\Models\Customer', 'user_id', 'id' );
    }

    public function user()
    {
        return $this->belongsTo( 'App\Models\TavernUser', 'user_id', 'id' );
    }

    public function comments()
    {
        return $this->hasMany( 'App\Models\SteamUsersComments', 'user_id', 'id' );
    }
}
