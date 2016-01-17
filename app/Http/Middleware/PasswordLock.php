<?php

namespace App\Http\Middleware;

use Closure;
use Redirect;
use Request;
use Session;

class PasswordLock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::get('locked') === true) {
            Session::set('lockedPage', Request::path());
            return Redirect::to('/lock');
        }
        return $next($request);
    }
}
