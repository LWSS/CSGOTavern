<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\SteamUser;
use Event;
use Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Platform\Users\Repositories\UserRepositoryInterface;
use Sentinel;
use Session;
use Social;
use SteamLogin;

class UsersController extends Controller
{
    /**
     * The Users repository.
     *
     * @var \Platform\Users\Repositories\UserRepositoryInterface
     */
    protected $users;

    public function __construct( UserRepositoryInterface $users )
    {
        parent::__construct();

        $this->users = $users;

        Sentinel::setModel( 'App\Models\TavernUser' );
    }
    /**
     * Login get request
     *
     */
    public function login()
    {
        $callback = URL::to( 'oauth/callback/vionox' );
        $url = Social::getAuthorizationUrl( 'vionox', $callback );
        return Redirect::to( $url );
    }

    /**
     * Logout get request
     *
     */
    public function logout()
    {
        // Log the user out
        //$this->users->getSentinel()->logout();
        if ( $user = Sentinel::check() ) {
            Sentinel::logout();
            // Fire the 'platform.user.logged_out' event
            Event::fire( 'platform.user.logged_out', $user );
        }
        if ( SteamUser::check() ) {
            Sentinel::logout();
        }
        return redirect( '/' );
    }

    public function showLockScreen()
    {
        $user = SteamUser::find( SteamUser::getID() );
        if ($user !== null) {
            if ($user->user->password === null || $user->user->password === '') {
                return redirect('/');
            }
            Session::set('locked', true); // In case Someone Types /lock
            return view('pages.user.lockscreen')->with('user', $user);
        } else {
            Session::flash('lastpage', 'lock');
            return redirect(SteamLogin::url(route('steam.oauth.callback')));
        }
    }

    public function lockScreenPassword()
    {
        $steamUser = SteamUser::find( SteamUser::getID() );
        if ($steamUser !== null) {
            if (Hash::check($_POST['curPass'], $steamUser->user->password)) {
                if (Session::has('oneWrong')) {
                    Session::forget('oneWrong');
                }
                Session::set('locked', false);
                if (Session::has('lockedPage')) {
                    return redirect(Session::get('lockedPage'));
                } else {
                    return redirect('/');
                }
            } else {
                if (Session::has('oneWrong')) {
                    Session::flush();
                    Sentinel::logout();
                    return redirect('/');
                }
                Session::set('oneWrong', true);
                return redirect()->back()->withInput()->with('error', 'Invalid Password!');
            }
        } else {
            Session::flash('lastpage', 'lock');
            return redirect(SteamLogin::url(route('steam.oauth.callback')));
        }
    }
}
