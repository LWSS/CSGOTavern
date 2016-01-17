<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SteamUsersComments
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $commenter_id
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\SteamUser $user
 * @property-read \App\Models\SteamUser $commenter
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereCommenterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\SteamUsersComments whereUpdatedAt($value)
 */
class SteamUsersComments extends Model
{
    public $timestamps = true;
    protected $table = 'steam_users_comments';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'user_id',
        'commenter_id',
        'comment', // Remember this limit is 255
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\SteamUser', 'user_id', 'id64');
    }

    /* Used for Getting Data on Foreign Keys */
    public function commenter()
    {
        return $this->hasOne('App\Models\SteamUser', 'id', 'commenter_id'); // Model, Foreign, Local
    }
}
