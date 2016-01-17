<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Watson\Rememberable\Rememberable;

/**
 * Class MarketItems
 *
 * @package App\Models
 * @method Builder whereNotNull($column, $boolean = 'and') Compile a "where not null" clause.
 * @property integer $id
 * @property integer $bot_id
 * @property integer $user_id
 * @property integer $buyer_id
 * @property integer $trade_id
 * @property integer $first_asset_id
 * @property integer $asset_id
 * @property integer $price
 * @property string $item_name
 * @property string $item_img
 * @property string $inspect_url
 * @property boolean $last_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $description
 * @property-read \App\Models\SteamUser $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereBotId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereBuyerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereTradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereFirstAssetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereAssetId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereItemName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereItemImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereInspectUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereLastStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MarketItems whereDescription($value)
 */
class MarketItems extends Model
{
    use Rememberable;

    public $timestamps = true;
    protected $table = 'market_items';
    protected $primaryKey = 'id';
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $fillable = [
        'bot_id',
        'user_id',
        'buyer_id',
        'trade_id',
        'asset_id',
        'price',
        'item_name',
        'item_img',
        'inspect_url',
        'last_status'
    ];

    /* Used for Getting Data on Foreign Keys */
    public function user()
    {
        return $this->hasOne('\App\Models\SteamUser', 'id', 'user_id'); // Model, Foreign, Local
    }

    /* Used for Getting Data on Foreign Keys */
    public function buyer()
    {
        return $this->hasOne('\App\Models\SteamUser', 'id', 'buyer_id'); // Model, Foreign, Local
    }

}
