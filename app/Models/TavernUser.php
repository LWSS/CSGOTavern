<?php

namespace App\Models;

use Cartalyst\Attributes\EntityInterface;
use Cartalyst\Sentinel\Users\EloquentUser;
use Cartalyst\Sentinel\Users\UserInterface;
use Cartalyst\Stripe\Billing\Laravel\Billable;
use Cartalyst\Stripe\Billing\Laravel\BillableContract;
use Cartalyst\Support\Traits\NamespacedEntityTrait;
use Illuminate\Database\Query\Builder;
use Platform\Attributes\Traits\EntityTrait;


/**
 * App\Models\TavernUser
 *
 * @method static Builder|TavernUser find($value)
 * @method static Builder|TavernUser whereId64($value)
 * @method static Builder|TavernUser wherePassword($value)
 * @method static Builder|TavernUser whereUsername($value)
 * @method static Builder|TavernUser whereEmail($value)
 * @method static Builder|TavernUser whereFirstName($value)
 * @method static Builder|TavernUser whereLastName($value)
 * @method static Builder|TavernUser whereTradeToken($value)
 * @method static Builder|TavernUser whereTavernTokens($value)
 * @method static Builder|TavernUser whereVisibilityState($value)
 * @method static Builder|TavernUser whereAvatarUrl($value)
 * @method static Builder|TavernUser whereDeveloper($value)
 * @method static Builder|TavernUser whereLastLogin($value)
 * @method static Builder|TavernUser whereCreatedAt($value)
 * @method static Builder|TavernUser whereUpdatedAt($value)
 * @method static Builder|TavernUser whereAnonymous($value)
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $visibility_state
 * @property string $permissions
 * @property string $last_login
 * @property string $first_name
 * @property string $last_name
 * @property string $display_name
 * @property string $trade_token
 * @property integer $tavern_tokens
 * @property string $avatar_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $stripe_id
 * @property string $stripe_discount
 * @property-read mixed $activated
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $addresses
 * @property-read \App\Models\SteamUser $steamuser
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SteamUser[] $steamusers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Platform\Roles\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Persistences\EloquentPersistence[] $persistences
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Activations\EloquentActivation[] $activations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Reminders\EloquentReminder[] $reminders
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentinel\Throttling\EloquentThrottle[] $throttle
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Stripe\Billing\Laravel\Card\Card[] $cards
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Stripe\Billing\Laravel\Charge\Charge[] $charges
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Stripe\Billing\Laravel\Invoice\Invoice[] $invoices
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Stripe\Billing\Laravel\InvoiceItem\InvoiceItem[] $invoiceItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Stripe\Billing\Laravel\Subscription\Subscription[] $subscriptions
 */
class TavernUser extends EloquentUser implements EntityInterface, UserInterface, BillableContract
{
    use EntityTrait, NamespacedEntityTrait, Billable;

    /**
     * The model namespace.
     *
     * @var string
     */
    protected static $entityNamespace = 'vionox/users';
    protected $table = 'users';
    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'email',
        'password',
        'permissions',
        'first_name',
        'last_name',
        'display_name',
        'full_name',
    ];
    /**
     * {@inheritDoc}
     */
    protected $appends = [
        'activated',
    ];
    /**
     * {@inheritDoc}
     */
    protected $with = [
        'activations',
    ];

    /**
     * Get mutator for the "activated" attribute.
     *
     * @return bool
     */
    public function getActivatedAttribute()
    {
        $activation = $this->activations->sortByDesc('created_at')->first();

        return (bool) $activation ? $activation->completed : false;
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\UserAddress', 'user_id', 'id');
    }

    public function steamusers()
    {
        return $this->hasMany('App\Models\SteamUser', 'user_id', 'id');
    }
}
