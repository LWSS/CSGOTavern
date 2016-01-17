<?php

namespace App\Http\Controllers\Users;

use App\Http\Requests;
use App\Models\SteamUser;
use App\Models\SteamUsersComments;
use Hash;
use Illuminate\Http\Request;
use Platform\Foundation\Controllers\Controller;
use Session;
use SteamLogin;

/**
 * Class ProfileController
 * @package App\Http\Controllers\Users
 */
class ProfileController extends Controller
{
    public function profilePublic($id64)
    {
        $profileOwner = SteamUser::find($id64);
        if ($profileOwner === null) {
            return Redirect('/');
        }
        $params = [
            'steamuser' => $profileOwner,
        ];
        return view((SteamUser::getID() === $id64 ? 'pages.profile.personal' : 'pages.profile.public'), $params);

    }

    public function profilePublicComment($id64)
    {
        if (\App\Models\SteamUser::getID() !== null) {
            $commentEntry = new \App\Models\SteamUsersComments;
            $commentEntry->user_id = $id64;
            $commentEntry->commenter_id = \App\Models\SteamUser::getID();
            $commentEntry->comment = $_POST['comment'];
            $commentEntry->save();
        }
        return redirect()->back();
    }

    public function profileSelf()
    {
        if( SteamUser::check() !== true ) {
            Session::flash('lastpage', 'profile');
            return redirect(SteamLogin::url( route('steam.oauth.callback')));
        }
        $params = array();
        $steamUser = SteamUser::find(SteamUser::getID());

        $profileCommentsSearch = SteamUsersComments::where('user_id', '=', $steamUser->id)->get();
        $params['steamuser'] = $steamUser;
        $params['comments'] = $profileCommentsSearch;
        return view('pages.profile.personal', $params);
    }

    public function profileSelfComment()
    {
        if (\App\Models\SteamUser::check() === true) {
            if (\App\Models\SteamUser::getID() !== null) {
                $commentEntry = new \App\Models\SteamUsersComments;
                $commentEntry->user_id = \App\Models\SteamUser::getID();
                $commentEntry->commenter_id = \App\Models\SteamUser::getID();
                $commentEntry->comment = $_POST['comment'];
                $commentEntry->save();
            }
            return redirect()->back();
        }
    }

    public function profileSelfCommentDelete()
    {
        if (\App\Models\SteamUser::check() === true && isset($_GET['commentID'])) {
            $commentLookup = \App\Models\SteamUsersComments::find($_GET['commentID']);
            if ($commentLookup !== null) {
                if (\App\Models\SteamUser::getID() === $commentLookup->user_id) {
                    $commentLookup->delete();
                }
            }
            return redirect()->back();
        }
    }

    public function profileSelfUpdate(Request $request)
    {
        if (SteamUser::check() !== true) {
            Session::flash('lastpage', 'profile');
            return redirect(SteamLogin::url(route('steam.oauth.callback')));
        }
        $steamUser = SteamUser::find(SteamUser::getID());
        if ($steamUser === null) {
            return redirect('/');
        }
        if (isset($_POST['anonymous']) && isset($_POST['lock3d'])) { // might change this to OR later
            if ($_POST['anonymous'] === 'yes') {
                $steamUser->anonymous = 1;
            } else if ($_POST['anonymous'] === 'no') {
                $steamUser->anonymous = 0;
            } else {
                return 'You Cheeky Scrub!';
            }
            if ($_POST['lock3d'] === 'yes') {
                $steamUser->lock3d = 1;
            } else if ($_POST['lock3d'] === 'no') {
                $steamUser->lock3d = 0;
            } else {
                return 'Ho Ho Ho!';
            }
            $steamUser->save();
            return redirect()->back();
        }
        $steamUser->user->first_name = $request->get('first_name') ? $request->get('first_name') : $steamUser->user->first_name;
        $steamUser->user->last_name = $request->get('last_name') ? $request->get('last_name') : $steamUser->user->last_name;
        if (($filtered = filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) !== false) {
            $steamUser->user->email = $filtered;
        }
        if (($tokenUrlForm = filter_var($request->get('token'), FILTER_VALIDATE_URL)) !== false) {
            $steamUser->trade_token = substr($request->get('token'), strrpos($request->get('token'), '&token=') + 7);
        } else {
            $steamUser->trade_token = $request->get('token') ? $request->get('token') : $steamUser->token;
        }

        $steamUser->save();
        $steamUser->user->save();
        return redirect()->back();
    }

    public function profileSelfPasswordSet()
    {
        if (strlen($_POST['password']) > 50) { // BCRYPT Limitation.
            return redirect()->back()->withInput()->with('error', 'Password Must Be Less than 50 Bytes ;)');
        }
        if (($_POST['password'] === $_POST['passwordConf'])) {
            $steamUser = SteamUser::find(SteamUser::getID());
            if ($steamUser !== null) {
                $steamUser->user->password = Hash::make($_POST['password']);
                $steamUser->user->save();
                //\App\Models\SteamUser::updateSession($steamUser->id);
                return redirect()->back()->withInput()->with('green', 'Password Set!');
            } else {
                return 'Session Expired, RE-Log and Try Again';
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Password and Password Confirmation Do Not Match!');
        }
    }

    public function profileSelfPasswordChange()
    {
        if (strlen($_POST['curPass']) > 50 || strlen($_POST['newPass']) > 50) { // BCRYPT Limitation.
            return redirect()->back()->withInput()->with('error', 'Passwords Must Be Less than 50 Bytes ;)');
        }
        if ($_POST['curPass'] === $_POST['newPass']) {
            return redirect()->back()->withInput()->with('error', 'Your New Password Can\'t be the Same as your Old One');
        }
        $steamUser = SteamUser::find(SteamUser::getID());
        if ($steamUser !== null) {
            if (Hash::check($_POST['curPass'], $steamUser->user->password)) {
                if ($_POST['newPass'] === '') {
                    $steamUser->user->password = null;
                    $steamUser->save();
                    //\App\Models\SteamUser::updateSession($steamUser->id);
                    Session::set('locked', false);
                    return redirect()->back()->withInput()->with('green', 'Password Removed!');
                }
                if ($_POST['newPass'] === $_POST['newPassConf']) {
                    $steamUser->user->password = Hash::make($_POST['newPass']);
                    $steamUser->save();
                    Session::set('locked', false);
                    //\App\Models\SteamUser::updateSession($steamUser->id);
                    return redirect()->back()->withInput()->with('green', 'Password Updated!');
                } else {
                    return redirect()->back()->withInput()->with('error', 'New Password and New Password Confirmation Must Match');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'Invalid Current Password');
            }
        } else {
            return 'Session Expired, RE-Log and Try Again';
        }
    }
}
