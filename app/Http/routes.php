<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Models\SteamUser;

$devIPs = [
    '73.181.170.12',
    '75.139.184.14',
    '162.158.254.113',
    '104.66.207.23',
    '127.0.0.1',
    '10.0.0.2',
    '10.1.0.2',
    '71.94.186.186',
];
if(!in_array(Request::getClientIp(), $devIPs) && !App::runningInConsole()){
    abort(403);
}
Route::get('/', function () {
    return view('pages.welcome');
});

Route::get( 'payments', [ 'as' => 'payments.index', 'uses' => 'BillingController@index' ] );
Route::get( 'addtokens', [ 'as' => 'billing.addtokens', 'uses' => 'BillingController@index' ] );
Route::post( 'addtokens', [ 'as' => 'billing.addtokens.action', 'uses' => 'BillingController@addTokens' ] );
Route::post( 'payments', [ 'as' => 'payments.post', 'uses' => 'BillingController@makePayment' ] );


/* Cartalyst Crap */
Route::group( [ 'namespace' => 'Auth' ], function () {
    // Login
    //Route::get( 'login', [ 'as' => 'user.login', 'uses' => 'UsersController@login' ] );
    //Route::post( 'login', [ 'as' => 'user.login', 'uses' => 'UsersController@processLogin' ] );
//
//    // Register
    Route::get( 'register', [ 'as' => 'user.register', 'uses' => 'UsersController@register' ] );
    Route::post( 'register', [ 'as' => 'user.register', 'uses' => 'UsersController@processRegistration' ] );

    // Logout
    Route::get( 'logout', [ 'as' => 'user.logout', 'uses' => 'UsersController@logout' ] );

    // OAuth
    Route::group( [ 'prefix' => 'oauth' ], function () {
        Route::get( 'authorize/{slug}', [ 'as' => 'user.oauth.auth', 'uses' => 'OAuthController@authorize' ] );

        Route::get( 'callback/{slug}', [ 'as' => 'user.oauth.callback', 'uses' => 'OAuthController@callback' ] );
    } );
} );


Route::get( 'lock', [ 'as' => 'lockscreen', 'uses' => 'Auth\UsersController@showLockScreen' ] );
Route::post('lockPass', 'Auth\UsersController@lockScreenPassword');

//Route::get('addtokens', ['as' => 'user.balance', 'uses' => 'BillingController@addTokensPage']);

/* Profile/Personal Pages */
Route::group( [ 'middleware' => 'lock', 'namespace' => 'Users' ], function () {
    /** Personal Profile **/
    Route::get( 'profile', [ 'as' => 'user.profile.self', 'uses' => 'ProfileController@profileSelf' ] );
    /* Update  */
    Route::post('profile/update', ['as' => 'user.profile.update', 'uses' => 'ProfileController@profileSelfUpdate']);
    /* Password  */
    Route::post('profile/passwordset', ['as' => 'user.profile.password.set', 'uses' => 'ProfileController@profileSelfPasswordSet']);
    Route::post('profile/passwordchange', ['as' => 'user.profile.password.change', 'uses' => 'ProfileController@profileSelfPasswordChange']);
    /* Comment Management */
    Route::post('profile/comment', ['as' => 'user.profile.selfcomment', 'uses' => 'ProfileController@profileSelfComment']);
    Route::get('profile/comment/delete', ['as' => 'user.profile.comment.delete', 'uses' => 'ProfileController@profileSelfCommentDelete']);


    /** Public Profile **/
    Route::get('profile/{id64}', ['as' => 'user.profile.public', 'uses' => 'ProfileController@profilePublic']);
    /* Public Comments */
    Route::post('profile/{id64}/comment', ['as' => 'user.profile.comment.delete', 'uses' => 'ProfileController@profilePublicComment']);


    Route::get( 'profile/mycashouts', function () {

    } );
} );

Route::get( 'browse', [ 'as' => 'items.browse', 'uses' => 'ItemsController@index' ] );
Route::get( 'search', [ 'as' => 'items.search', 'uses' => 'ItemsController@search' ] );
// Route::get( 'auctions', [ 'as' => 'items.auctions', 'uses' => 'ItemsController@auctions' ] );
// Route::get( 'mysales', 'ItemsController@mySales' );
/* Market Pages */
Route::group( [ 'prefix' => 'marketitems', 'middleware' => 'lock' ], function () {
    Route::get( '/{id}', function ( $id ) {
        $itemSearch = \App\Models\MarketItems::find( $id );
        if ( $itemSearch === null || $itemSearch->asset_id === null ) {
            return view( 'pages.noItem' );
        }
        $comments = \App\Models\MarketItemsComments::where( 'market_id', '=', $id )->get();
        $cacheHistory = Cache::remember($id, 5, function () use ($itemSearch) { // This is for Price Graphs on Sold Items.
            return \App\Models\MarketItems::where( [ 'item_name' => $itemSearch->item_name, 'last_status' => 3 ] )->whereNotNull( 'buyer_id' )->orderBy( 'updated_at', 'asc' )->get();
        } );
        if ( !$comments->isEmpty() ) { // HAS Comments
            if ($itemSearch->user_id === \App\Models\SteamUser::getID() && $itemSearch->buyer_id === null) { // Owner
                if ( !$cacheHistory->isEmpty() ) { // History not Empty
                    return view( 'pages.itemOwner' )->with( 'item', $itemSearch )->with( 'comments', $comments )->with( 'cacheHistory', $cacheHistory );
                } else {  // No history for this item
                    return view( 'pages.itemOwner' )->with( 'item', $itemSearch )->with( 'comments', $comments );
                }
            } else { // Not Owner
                if ( !$cacheHistory->isEmpty() ) { // History not Empty
                    return view( 'pages.item' )->with( 'item', $itemSearch )->with( 'comments', $comments )->with( 'cacheHistory', $cacheHistory );
                } else { // No History for this item
                    return view( 'pages.item' )->with( 'item', $itemSearch )->with( 'comments', $comments );
                }
            }
        } else { // No Comments
            if ( $itemSearch->user_id === \App\Models\SteamUser::getID() ) { // Owner
                if ( !$cacheHistory->isEmpty() ) { // History not Empty
                    return view( 'pages.itemOwner' )->with( 'item', $itemSearch )->with( 'cacheHistory', $cacheHistory );
                } else {
                    return view( 'pages.itemOwner' )->with( 'item', $itemSearch );
                }
            } else { // Not Owner
                if ( !$cacheHistory->isEmpty() ) { // History not Empty
                    return view( 'pages.item' )->with( 'item', $itemSearch )->with( 'cacheHistory', $cacheHistory );
                } else {
                    return view( 'pages.item' )->with( 'item', $itemSearch );
                }
            }
        }
    } );
    Route::post( '/{id}/comment', function ( $id ) {
        if ( \App\Models\SteamUser::check() === true ) {
            if ( \App\Models\SteamUser::getID() !== null ) {
                $itemSearch = \App\Models\MarketItems::find($id);
                if ($itemSearch === null || $itemSearch->buyer_id !== null) { // If not found or Sold
                    return redirect('/browse');
                }
                $commentEntry = new \App\Models\MarketItemsComments;
                $commentEntry->market_id = $id;
                $commentEntry->commenter_id = \App\Models\SteamUser::getID();
                $commentEntry->comment = $_POST['comment'];
                $commentEntry->save();
            }
        }
        return Redirect::back();
    } );
    Route::get( '/{id}/comment/delete', function ( $id ) {
        if ( \App\Models\SteamUser::check() === true && isset( $_GET['commentID'] ) ) {
            $commentLookup = \App\Models\MarketItemsComments::find( $_GET['commentID'] );
            if ( $commentLookup !== null ) {
                if ( \App\Models\SteamUser::getID() === $commentLookup->item->user_id ) {
                    $commentLookup->delete();
                }
            }
        }
        return Redirect::back();
    } );
    Route::get( '/{id}/buy', function ( $id ) {
        if ( \App\Models\SteamUser::check() !== true ) {
            Session::flash( 'lastpage', 'marketitems/' . $id . '/buy' );
            return redirect( SteamLogin::url( route('steam.oauth.callback') ) );
        }
        $itemSearch = \App\Models\MarketItems::find( $id );
        if ( $itemSearch !== null && $itemSearch->asset_id !== null && \App\Models\SteamUser::getID() !== $itemSearch->user_id ) {
            $buyer = \App\Models\SteamUser::find(\App\Models\SteamUser::getID());
            if ($buyer->user->tavern_tokens >= $itemSearch->price) {
                return view( 'pages.items.buy' )->with( 'item', $itemSearch )->with( 'buyer', $buyer );
            } else {
                return view( 'pages.items.buy' )->with( 'item', $itemSearch );
            }
        } else {
            return view( 'pages.noItem' )->with( 'message', 'This Item is Yours; You can\'t Buy it.' );
        }
    } );
    Route::post( '/{id}/buy/confirm', function ( $id ) {
        if ( \App\Models\SteamUser::check() !== true ) {
            Session::flash( 'lastpage', 'marketitems/' . $id . '/buy' );
            return redirect( SteamLogin::url( route('steam.oauth.callback') ) );
        }
        if ( $_POST['buyConf'] === 'yes' ) {
            $user = \App\Models\SteamUser::find(\App\Models\SteamUser::getID());
            if ($user === null) {
                Session::flash('lastpage', $id . '/buy');
                return redirect(SteamLogin::url(route('steam.oauth.callback')));
            }
            $item = \App\Models\MarketItems::find($id);
            if ($item->asset_id === null || $item->buyer_id !== null || $item === null) {
                dd($item);
                return 'Yikes.. Looks like Someone Beat you to it!';
            }
            if (!$user->user->tavern_tokens >= $item->price) {
                return 'Not Enough Tokens there Bud'; // this only happens if someone tries to be 1337
            }
            $user->user->tavern_tokens = ($user->user->tavern_tokens - $item->price); // Take Tokens away from buyer
            $item->buyer_id = $user->id; // Set item's status to sold
            $item->trade_id = null; // Prep for Shipping to Buyer
            $item->user->user->tavern_tokens = ($item->user->user->tavern_tokens + $item->price); // Give Tokens to Seller
            $item->user->user->save();
            $user->user->save();
            $item->save();

            return view('pages.items.buy')->with('green', 'This Item is now Yours!')->with('item', $item)->with('newlyBought', true);

        } else {
            return redirect( '/browse' );
        }
    } );
} );
/***** Sell *****/
Route::group( [ 'prefix' => 'sell', 'middleware' => 'lock' ], function () {
    Route::get( '', function () {
        if ( \App\Models\SteamUser::check() === true ) {
            $parsedInvItems = \App\Http\Controllers\SteamController::getParsedInventoryRaw();
            if ( $parsedInvItems !== null ) {
                return view( 'pages.items.inventory' )->with( 'invItems', $parsedInvItems );
            } else {
                return view( 'pages.items.inventory' );
            }
        } else {
            Session::flash( 'lastpage', 'sell' );
            return redirect( SteamLogin::url( route('steam.oauth.callback') ) );
        }
    } );
    Route::get( 'list/{id}', function ( $id ) {
        $parsedInvItems = \App\Http\Controllers\SteamController::getParsedInventoryRaw();
        if ( $parsedInvItems === null ) { // In Case Session Expires On the Sell Page, getParsedInventoryRaw will return null.
            return Redirect( '/' );
        }
        $confirmedItem = null;

        foreach ( $parsedInvItems as $item ) {
            if ( $item['info']['id'] === $id ) {
                $confirmedItem = $item;
                break;
            }
        }
        if ( $confirmedItem === null ) {
            return redirect()->back()->withInput()->with( 'error', 'Item Check failed, try Refreshing the Last Page' );
        } else if ( $confirmedItem['desc']['tradable'] === 0 ) {
            return redirect()->back()->withInput()->with( 'error', 'That Item Isn\'t Tradable =(' );
        } else if ( $confirmedItem['desc']['type'] === 'Base Grade Container' ) {
            return redirect()->back()->withInput()->with( 'error', 'We do not Accept Cases, Sorry.' );
        } else if ( ( strpos( $confirmedItem['desc']['type'], 'Consumer' ) !== false ) || ( strpos( $confirmedItem['desc']['type'], 'Industrial' ) !== false ) ) {
            return redirect()->back()->withInput()->with( 'error', 'Your Item\'s Quality Must be at least Mil-Spec' );
        } else {
            return view( 'pages.items.listNewItem' )->with( 'confirmedItem', $confirmedItem );
        }
    } );
    Route::post( 'list/{id}/settings', function ( $id ) {
        /* Need to Reparse their Inventory So that the page will know which Item to get AND so that someone can't forge a post and give the bot an invalid request */
        $parsedInvItems = \App\Http\Controllers\SteamController::getParsedInventoryRaw();
        if ( $parsedInvItems === null ) { // In Case Session Expires On the Previous Page, getParsedInventoryRaw will return null.
            return Redirect( '/' );
        }
        $confirmedItem = null;

        foreach ( $parsedInvItems as $item ) {
            if ( $item['info']['id'] === $id ) {
                $confirmedItem = $item;
                break;
            }
        }

        if ( $confirmedItem === null ) {
            return 'You dont have that Item, try going back and refreshing the Page :/';
        } else if ( $confirmedItem['desc']['tradable'] === 0 ) {
            return 'This item isnt Tradable =(';
        } else if ( !( isset( $_POST['price'] ) && ctype_digit( $_POST['price'] ) && $_POST['price'] > 200 ) ) { /* If Price Submitted is Not Set OR it is not a digit OR it is less than 1 */
            return redirect()->back()->withInput()->with( 'error', 'Invalid Price! Must be a Number and Over 200' );
        } else if ( \App\Models\MarketItems::where( 'user_id', '=', \App\Models\SteamUser::getID() )->whereNull( 'buyer_id' )->count() >= 100 ) {
            return redirect()->back()->withInput()->with( 'error', 'Sorry, But you May Only have 20(100 For Now) Active Listings At this Time.' );
        } else if ( \App\Models\MarketItems::where( 'user_id', '=', \App\Models\SteamUser::getID() )->where( 'first_asset_id', '=', $confirmedItem['info']['id'] )->count() >= 1 ) { /* This Ensures they can't Trick the System With the Same Item Twice Under 10minutes */
            return redirect()->back()->withInput()->with( 'error', 'You Can\'t List the Same Item Twice, Bub.' );
        } else {
            $marketItem = \App\Models\MarketItems::where( 'asset_id', '=', $id )->first();
            if ( $marketItem === null ) {
                $marketItem = new \App\Models\MarketItems;
                $botToUse = \App\Models\SteamBot::randomBot();
                if ( $botToUse === null ) {
                    return redirect()->back()->withInput()->with( 'error', 'Bots are Full, Scoob.' );
                } else {
                    $marketItem->bot_id = $botToUse;
                }
                $marketItem->user_id = \App\Models\SteamUser::getID();
                $marketItem->first_asset_id = $confirmedItem['info']['id'];
                $marketItem->buyer_id = null;
                if ( isset( $_POST['description'] ) ) {
                    $marketItem->description = $_POST['description'];
                }
                $marketItem->price = $_POST['price'];
                $marketItem->item_name = $confirmedItem['desc']['market_name'];
                $marketItem->item_img = $confirmedItem['desc']['icon_url'];
                $marketItem->save();
            }
            return Redirect::to( 'sell/list/setup/' . $marketItem->id );
        }
    } );
    Route::get( 'list/setup/{id}', function ( $id ) {
        $marketItem = \App\Models\MarketItems::find( $id );
        if ( $marketItem === null ) { /* If an Invalid ID was entered */
            return Redirect::to( '/' );
        }
        if ( \App\Models\SteamUser::getID() !== $marketItem->user_id ) { /* If you're Trying to Setup an Item that isn't yours */
            return Redirect::to( '/' );
        }
        return view( 'pages.items.setupItem' )->with( 'marketItem', $marketItem );
    } );
    Route::get( 'list/setup/{id}/send', function ( $id ) {
        $marketItem = \App\Models\MarketItems::find( $id );
        if ( $marketItem === null ) { /* If an Invalid ID was entered */
            return Redirect::to( '/' );
        }
        if ((\App\Models\SteamUser::getID() !== $marketItem->user_id) || $marketItem->buyer_id !== null) { /* If you're Trying to Setup an Item that isn't yours */
            return Redirect::to( '/' );
        }
        if ( $marketItem->user->trade_token === null || $marketItem->user->trade_token === '' ) {
            return redirect()->back()->withInput()->with( 'error', 'Need to Set your Trade Token On your Profile Page' );
        }
        $tradeOfferToken = uniqid();
        $botContact = \App\Http\Controllers\API\Bots\SteamBotController::receiveItem($marketItem, $marketItem->first_asset_id, $marketItem->user->trade_token, 'Good Evening Sir/Madam, here is your Offer: (' . $tradeOfferToken . ') This Offer will Expire in 4 Days');
        if ( $botContact === 'OK' ) {
            return redirect()->back()->withInput()->with('green', 'Trade Offer Sent, Check your Trade Offers! Token: ' . $tradeOfferToken);
        } else if ( $botContact === null ) {
            return redirect()->back()->withInput()->with( 'error', 'Couldn\'t Contact the Bot!' );
        } else if ($botContact === 'ESCROW') {
            return redirect()->back()->withInput()->with('green', 'Trade Offer Sent with Escrow( Expires in 4 Days ), Check your Trade Offers! ' . $tradeOfferToken);
        } else {
            return redirect()->back()->withInput()->with('error', $botContact);
        }

    } );
    Route::get( 'list/setup/{id}/delete', function ( $id ) {
        $marketItem = \App\Models\MarketItems::find( $id );
        if ( $marketItem === null ) {
            return Redirect::to( '/' );
        }
        if ( \App\Models\SteamUser::getID() !== $marketItem->user_id ) {
            return Redirect::to( '/' );
        }
        if ( $marketItem->asset_id !== null ) {
            return redirect()->back()->withInput()->with( 'error', 'You might want to Take your Item Back first =)' );
        }
        $marketItem->delete();
        return Redirect::to( '/' );
    } );
    Route::get( 'list/setup/{id}/cancel', function ( $id ) {
        $marketItem = \App\Models\MarketItems::find( $id );
        if ( $marketItem === null ) {
            return redirect( '/' );
        }
        if ( \App\Models\SteamUser::getID() !== $marketItem->user_id ) {
            return Redirect::to( '/' );
        }
        if ( $marketItem->buyer_id !== null ) {
            return redirect( '/' );
        }
        if ( $marketItem->user->trade_token === null || $marketItem->user->trade_token === '' ) {
            return redirect()->back()->withInput()->with( 'error', 'Need to Set your Trade Token On your Profile Page' );
        }
        if ( $marketItem->asset_id !== null ) {
            $tradeOfferToken = uniqid();
            $botContact = \App\Http\Controllers\API\Bots\SteamBotController::sendItem($marketItem->user->id, $marketItem, $marketItem->user->trade_token, 'Good Evening Sir/Madam, here is your Offer: (' . $tradeOfferToken . ') This Offer will Expire in 4 Days');
            if ( $botContact === 'OK' ) {
                return redirect()->back()->withInput()->with( 'green', 'Trade Offer Requested, Check your Trade Offers! Token: ' . $tradeOfferToken );
            } else if ( $botContact === null ) {
                return redirect()->back()->withInput()->with( 'error', 'Couldn\'t Contact the Bot!' );
            } else if ($botContact === 'ESCROW') {
                return redirect()->back()->withInput()->with('green', 'Trade Offer Sent with Escrow( Expires in 4 Days ), Check your Trade Offers! ' . $tradeOfferToken);
            } else {
                return redirect()->back()->withInput()->with('error', $botContact);
            }
        }
    } );

} );
Route::get( 'mylistings', [ 'middleware' => 'lock', function () {
    if ( \App\Models\SteamUser::check() !== true ) {
        Session::flash( 'lastpage', 'mylistings' );
        return redirect( SteamLogin::url( route('steam.oauth.callback') ) );
    }
    $allListings = \App\Models\MarketItems::where( 'user_id', '=', \App\Models\SteamUser::getID() )->whereNull( 'buyer_id' )->get();
    if ( !$allListings->isEmpty() ) {
        return view( 'pages.items.mylistings' )->with( 'allListings', $allListings );
    }
    Session::flash( 'error', 'No Listings Found For You' );
    return view( 'pages.items.mylistings' );
} ] );
Route::get( 'mylistings/all', [ 'middleware' => 'lock', function () {
    if ( \App\Models\SteamUser::check() !== true ) {
        Session::flash( 'lastpage', 'mylistings' );
        return redirect( SteamLogin::url( route('steam.oauth.callback') ) );
    }
    $allListings = \App\Models\MarketItems::where( 'user_id', '=', \App\Models\SteamUser::getID() )->get();
    if ( !$allListings->isEmpty() ) {
        return view( 'pages.items.mylistings' )->with( 'allListings', $allListings )->with( 'all', true );
    }
    Session::flash( 'error', 'No Listings Found For You' );
    return view( 'pages.items.mylistings' );
} ] );
Route::get('mypurchases', ['middleware' => 'lock', function () {
    if (\App\Models\SteamUser::check() !== true) {
        Session::flash('lastpage', 'mylistings');
        return redirect(SteamLogin::url(route('steam.oauth.callback')));
    }
    $userPurchases = \App\Models\MarketItems::where('buyer_id', '=', \App\Models\SteamUser::getID())->get();
    if (!$userPurchases->isEmpty()) {
        return view('pages.items.mypurchases')->with('userPurchases', $userPurchases);
    }
    return view('pages.items.mypurchases')->with('error', 'No Purchases Found for You');
}]);
Route::get('mypurchases/{id}', ['middleware' => 'lock', function ($marketId) {
    if (\App\Models\SteamUser::check() !== true) {
        Session::flash('lastpage', 'mylistings');
        return redirect(SteamLogin::url(route('steam.oauth.callback')));
    }
    $userPurchase = \App\Models\MarketItems::find($marketId);
    if ($userPurchase === null || $userPurchase->buyer_id !== \App\Models\SteamUser::getID()) {
        return view('pages.items.mypurchases')->with('error', 'Item not found, or it does not belong to thou.');
    }
    return view('pages.items.mypurchasesItem')->with('userPurchase', $userPurchase);
}]);
Route::get('mypurchases/{id}/send', ['middleware' => 'lock', function ($marketId) {
    $marketItem = \App\Models\MarketItems::find($marketId);
    if ($marketItem === null) { /* If an Invalid ID was entered */
        return Redirect::to('/');
    }
    if (\App\Models\SteamUser::getID() !== $marketItem->buyer_id) { /* If you're Trying to Setup an Item that isn't yours */
        return Redirect::to('/');
    }
    if ($marketItem->buyer->trade_token === null || $marketItem->buyer->trade_token === '') {
        return redirect()->back()->withInput()->with('error', 'Need to Set your Trade Token On your Profile Page');
    }
    $tradeOfferToken = uniqid();
    $botContact = \App\Http\Controllers\API\Bots\SteamBotController::receiveItem($marketItem, $marketItem->asset_id, $marketItem->user->trade_token, 'Good Evening Sir/Madam, here is your Offer: (' . $tradeOfferToken . ') This Offer will Expire in 4 Days');
    if ($botContact === 'OK') {
        return redirect()->back()->withInput()->with('green', 'Trade Offer Requested, Check your Trade Offers! Token: ' . $tradeOfferToken);
    } else if ($botContact === null) {
        return redirect()->back()->withInput()->with('error', 'Couldn\'t Contact the Bot!');
    } else if ($botContact === 'ESCROW') {
        return redirect()->back()->withInput()->with('green', 'Trade Offer Sent with Escrow( Expires in 4 Days ), Check your Trade Offers! ' . $tradeOfferToken);
    } else {
        return redirect()->back()->withInput()->with('error', $botContact);
    }
}]);


/* Bot-Based Functions and API */
Route::group( [ 'prefix' => 'steambot', 'namespace' => 'API\Bots' ], function () {
    Route::post( 'dispatch', [ 'uses' => 'SteamBotController@processBotRequest' ] );
} );
/* Steam OpenID  */
Route::get( 'steamlogout', 'SteamController@logout' );
Route::get( '/openid/steam/callback', [ 'as' => 'steam.oauth.callback', 'uses' => 'SteamController@login' ] );

if ( !App::runningInConsole() && config( 'app.debug' ) ) {
    Route::controller( 'dev', 'DevController' );
}
/* Development Testing Zone, xxxxxx.com/dev/xyxyxy */
Route::group( [ 'prefix' => 'dev2' ], function () {
    if ( !App::runningInConsole() ) {

        Route::get( 'queue', function () {
            dd( Queue::pushDirect( 'test', 'users.direct', 'test' ) );
        } );

        Route::get( 'comments', function () {
            dd( SteamUser::find( SteamUser::getID() )->comments );
        } );

        Route::get( 'swag', function () {
            if ( \App\Models\SteamUser::check() ) {
                dd( \App\Libraries\SteamQuery::getPlayerSummary( \App\Models\SteamUser::getID() ) );
            } else {
                dd( 'login scrubs ' );
            }
        } );
        Route::get( 'item', function () {
            return view( 'pages.items.inventory' );
        } );
        /* Steam Inventory Testing */
        Route::get( 'inventoryraw', function () {
            dd( \App\Http\Controllers\SteamController::getParsedInventoryRaw() );
        } );
        Route::get( 'inventorywwe', function () {
            dd( \App\Libraries\SteamQuery::getInventory( \App\Models\SteamUser::getID(), true ) );
        } );

        Route::get( 'steamuser', function () {
            dd( SteamUser::getSession() );
        } );
        /*******************************************************/
        /* UpDated this example to show how Bot Cmd's are done */
        /*******************************************************/
        Route::get( 'senditem', function () {
            $itemToSend = \App\Models\MarketItems::find( 1034 );
            $botTalk = \App\Http\Controllers\API\Bots\SteamBotController::sendItem( '76561198047479758', $itemToSend, 'VhR3L_-P', 'Trade Offer Message' );
            if ( $botTalk === 'OK' ) {
                return 'Offer Sent';
            } else if ( $botTalk === null ) {
                return 'Error Talking to bot';
            } else {
                return 'Bot Says Error: ' . $botTalk;
            }
        } );
        Route::get( 'takeitem', function () {
            $itemToGet = new \App\Models\MarketItems;
            $itemToGet->bot_id = 1;
            $itemToGet->user_id = '76561198047479758';
            $itemToGet->buyer_id = null;
            $itemToGet->price = 42069;
            $itemToGet->item_name = 'Nova | Walnut';
            $itemToGet->save();
            return ( \App\Http\Controllers\API\Bots\SteamBotController::receiveItem( $itemToGet, '2648426540', 'VhR3L_-P', 'Drop me a Negev Bro' ) );
            if ( \App\Http\Controllers\API\Bots\SteamBotController::receiveItem( $itemToGet, '302028390', 'VhR3L_-P', 'Drop me a Negev Bro' ) === 'OK' ) {
                return 'swag';
            } else {
                return 'no good';
            }
        } );
        Route::get( 'checktake/{marketId}', function ( $marketId ) {
            $itemToCheck = \App\Models\MarketItems::find( $marketId );
            if ( $itemToCheck->user_id !== \App\Models\SteamUser::getID() ) {
                return 'This is not your Item, Stop Stalking other Users! =)';
            }
            return \App\Http\Controllers\ItemsController::checkReceived( $itemToCheck );
        } );
        Route::get( 'checksend/{marketId}', function ( $marketId ) {
            $itemToCheck = \App\Models\MarketItems::find( $marketId );
            if ( $itemToCheck->user_id !== \App\Models\SteamUser::getID() ) {
                return 'This is not your Item, Stop Stalking other Users! =)';
            }
            return \App\Http\Controllers\ItemsController::checkSent( $itemToCheck );
        } );
        Route::get( 'cholo', function () {
            $newItem = new \App\Models\MarketItems;
            $newItem->bot_id = 1;
            $newItem->user_id = '76561198047479758';
            $newItem->buyer_id = null;
            $newItem->price = 500;
            $newItem->item_name = 'One Sick Gun';
            $newItem->save();
            if ( \App\Http\Controllers\API\Bots\SteamBotController::receiveItem( $newItem, '2648432687', 'VhR3L_-P', 'Trade Offer Message' ) === 'OK' ) {
                return 'swag';
            } else {
                return 'no good';
            }
        } );

        Route::get( 'steamuser', function () {
            dd( Session::get( \App\Models\SteamUser::sessionVariable ) );
        } );


        Route::get( 'config', function () {
            return dd( app( 'config' ) );
        } );
        Route::get( 'benchmark', function () {
            return App\Http\Controllers\ItemsController::search();
        } );
    }
} );