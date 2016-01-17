<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserAddress
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $customer_name
 * @property string $street
 * @property string $street2
 * @property string $city
 * @property string $zip
 * @property string $state
 * @property string $country
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\TavernUser $user
 * @property string $phone_number
 */
class UserAddress extends Model
{
    protected $table = 'user_addresses';

    public function user()
    {
        return $this->belongsTo('App\Models\TavernUser', 'user_id', 'id' );
    }
}
