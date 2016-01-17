<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\MarketItems;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemsController extends Controller
{
    /**
     * Search for items.
     *
     * @return Response
     */
    public static function search()
    {
        if (!isset($_GET['query']) || $_GET['query'] === '') {
            return view('pages.items.search', [
                'results' => null,
                'searchQuery' => '',
            ]);
        }
        $cache = Cache::remember('search', 5, function () {
            return MarketItems::whereNull('buyer_id')->whereNotNull('asset_id')->get(); // We have the Item and it isn't Currently Involved in a TradeOffer
        });
        $searchCache = $cache->filter(function ($item) {
            if (stripos($item->item_name, $_GET['query']) !== false) {
                return true;
            }
        });
        $page = (isset($_GET['page']) ? $_GET['page'] : 1);

        if ($searchCache->isEmpty()) { // no Results Found
            return view('pages.items.search', [
                'searchQuery' => $_GET['query'],
            ]);
        }

        return view('pages.items.search', [
            'results' => new LengthAwarePaginator($searchCache->chunk(24)[$page - 1], count($searchCache), 24, $page, ['path' => '/search']),
            'searchQuery' => $_GET['query'],
        ]);
    }

    public static function checkSent($marketItem)
    {
        if ($marketItem->asset_id !== null) {
            // We still have Your Item!
            if ($marketItem->last_status === null) {
                // Looks like you haven't Accepted your TradeOffer Yet
                return 'We Still have Your Item! Looks like you havent Accepted your TradeOffer Yet';
            } else {
                // Looks like you Declined our Offer or it expired
                // Click Here to Resend
                return 'We Still have Your Item! Looks like you Declined or the Offer Expired :(';
            }
        } else {
            // Your Item Has been Sent, Have a Tavern Day!
            return 'Your Item Has Been Sent, Have a Tavern Day!';
        }
    }

    public static function checkReceived( $marketItem ) {
        if( $marketItem->asset_id === null ){
            // We Don't have your Item Yet, if this is wrong, Contact us: xxxx
            if ($marketItem->last_status === null) {
                // Looks like you haven't Accepted your TradeOffer
                return 'Dont have your Item, but it Looks like you havent Accepted your TradeOffer';
            } else {
                // Looks like you Declined our Offer or it expired
                // < Delete the MarketItems Entry >
                // Click Here to Browse our Site Somewhere Else..
                return 'Dont have your Item, Looks like you Declined or our Offer Expired :(';
            }
        } else {
            return 'We Got Your Item Hoorah';
            // We Got Your Item Congrats, you can See your listing here < Link >
            // It May take xx Minutes for your Item to Appear on the Browse/Search page Cache's
        }
    }

    /**
     * Display a Logged in User's Personal Listings.
     */
    public static function mySales()
    {
        if (\App\Models\SteamUser::check() === true) {
            return view('pages.items.listings', [
                'results' => MarketItems::remember(5)->where('user_id', \App\Models\SteamUser::getID())->paginate(24)
            ]);
        } else {
            return \App\Http\Controllers\ItemsController::index();
        }
    }

    /**
     * Display a listing of items. AKA the "Browse Page"
     * @return Response
     */
    public static function index()
    {
//        /** @var \Illuminate\Database\Eloquent\Builder $data */
//        $data = MarketItems::whereNotNull('asset_id')->whereNull('buyer_id')->remember(5);
//        dd($data->paginate(24)->items());
        return view('pages.items.listings', [
            'results' => MarketItems::whereNotNull('asset_id')->whereNull('buyer_id')->remember(5)->paginate(24),
        ]);
    }

    /**
     * Show the form for creating new auctions.
     *
     * @return Response
     */
    public function auctions()
    {
        return view('pages.items.auctions', [

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
