<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sentinel;
use Stripe;

/**
 * App\Models\Customer
 *
 * @property string $id
 * @property integer $user_id
 * @property-read \App\Models\TavernUser $user
 */
class Customer extends Model
{

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id',
    ];

    public static function getCustomerId( $uid = null )
    {
        if ( $uid === null ) {
            $uid = Sentinel::check()->getUserId();
        }
        return Customer::getCustomer( $uid )['id'];
    }

    public static function getCustomer( $uid )
    {
        $user = TavernUser::find( $uid );
        $customer = $user->customer;
        if ( $customer === null ) {
            $stripeCustomer = Stripe::customers()->create( [
                'email' => $user->email,
                'id' => 'tavern_' . $uid,
            ] );
            $vnxCustomer = Customer::create( array(
                'id' => $stripeCustomer['id'],
                'user_id' => $uid,
            ) );
            return $vnxCustomer;
        }
        return $customer;
    }

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo( 'App\Models\TavernUser', 'user_id', 'id' );
    }
}
