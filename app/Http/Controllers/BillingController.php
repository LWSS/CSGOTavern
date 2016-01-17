<?php

namespace App\Http\Controllers;

use Alert;
use App\Http\Requests;
use App\Models\SteamUser;
use App\Models\UserAddress;
use Cartalyst\Stripe\Exception\MissingParameterException;
use DB;
use Illuminate\Http\Request;
use Sentinel;

class BillingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware( 'auth' );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $viewParams = array();
        /** @var \App\Models\TavernUser $user */
        $user = Sentinel::getUser();

        //dd(Stripe::getCardSlug('Visa'));
        //dd($cards);

        $viewParams['cards'] = $user->cards->all();
        $viewParams['addresses'] = $user->addresses->all();
        $viewParams['balance'] = SteamUser::check( true )->tavern_tokens;
        $viewParams['hasAddresses'] = (count($viewParams['addresses']) > 0);
        $viewParams['hasCards'] = (count($viewParams['cards']) > 0);

        return view( 'pages.payments.addcredit', $viewParams );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addTokens( Request $request )
    {
        /** @var \Cartalyst\Stripe\Billing\Laravel\Charge\Charge $charge */
        /** @var \App\Models\TavernUser $user */
        $user = Sentinel::check();
        if($user===false) {
            return redirect('/');
        } else if($user->email===null) {
            Alert::error('You must have an email address confirmed before you can proceed with billing.');
            return redirect(route('user.profile.self').'#tab_1_2');
        }
        $tokens = intval($request->get( 'tokens' ));
        $cost = ($tokens / 100);
        // Get the submitted Stripe token
        $token = $request->get('stripeToken');
        if(!$user->isBillable()){
            $user->createStripeCustomer([
                'email' => $user->email,
            ]);
        }

        if($request->get('billingAddressId')==="-1"){
            $address = new UserAddress();
            $address->user_id = Sentinel::getUser()->id;
            $address->country = $request->get('address_country');
            $address->city = $request->get('address_city');
            $address->customer_name = $request->get('RECIPIENT');
            $address->state = $request->get('address_state');
            $address->street = $request->get('address_addressLine1');
            $address->street2 = $request->get('address_addressLine2');
            $address->zip = $request->get('address_zipcode');
            $address->phone_number = $request->get('address_phoneNumber');
            $address->save();
        }

        $chargeDetails = [
            'description' => 'Purchasing '.$tokens.' Tavern Tokens.',
            'metadata' => [
                'uid' => $user->id,
                'steamid64' => $user->steamusers->first()->id,
            ],
            'receipt_email' => $user->email,
            'capture'   => true,
            'statement_descriptor' => $tokens . ' Tavern Tokens'
        ];
        if($token != null && $request->get('payment_method')==="credit-card") {
        $charge = $user
            ->charge()
            ->setToken($token)
            ->create($cost, $chargeDetails);
        } else if($request->get('payment_method')!="balance") {
            // The Stripe Billing Package only bills the user's default card,
            // so we will set the default to the card they selected
            $user->cards->find(($request->get('payment_method')))->setDefault();

            $charge = $user
                ->charge()
                ->create($cost, $chargeDetails);
        } else {
            Alert::error('Invalid payment option selected.');
            return redirect(route('billing.addtokens'));
        }

        if($charge->isCaptured() && $charge->isPaid()){
            // Successfully got da money
            DB::table('users')
                ->where('id', $user->id)
                ->increment('tavern_tokens', $tokens);
            return redirect(route('billing.addtokens'));
        }
        return redirect(route('billing.addtokens'));
    }

    public function makePayment( Request $request )
    {
        $user = Sentinel::check();
        //$customerId = Customer::getCustomerId( $user->getUserId() );
        dd( $request->all() );
        $tokens = $request->get( '' );

        $card = Stripe::cards()->create( $customerId, $request->get( 'stripeToken' ) );

        try {
            $charge = Stripe::charges()->create( [
                'customer' => $customerId,
                'currency' => 'USD',
                'amount' => $request->get( 'amount' ),
            ] );
        } catch ( MissingParameterException $ex ) {

        }

        dd( [
            'Stripe Customer' => Stripe::customers()->find( $customerId ),
            'card' => $card,
            'charge' => $charge,
            'request->all()' => $request->all(),
        ] );
        return view( 'pages.payments.confirm', [
            'charge' => $charge,
        ] );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
