<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MarketItemsComments
 *
 * @property integer $id
 * @property integer $market_id
 * @property integer $commenter_id
 * @property string $comment
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereMarketId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereCommenterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItemsComments whereUpdatedAt($value)
 * @property-read \App\Models\MarketItems $item
 * @property-read \App\Models\SteamUser $commenter
 */
class MarketItemsComments extends Model
{
    public $timestamps = true;
    protected $table = 'market_items_comments';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'market_id',
        'commenter_id',
        'comment', // Remember this limit is 255
    ];

    public function item()
    {
        return $this->belongsTo('App\Models\MarketItems', 'market_id', 'id');
    }

    /* Used for Getting Data on Foreign Keys */
    public function commenter()
    {
        return $this->hasOne('App\Models\SteamUser', 'id', 'commenter_id'); // Model, Foreign, Local
    }
}
