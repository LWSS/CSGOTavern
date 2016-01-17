<?php

namespace App\Http\Middleware;

use Closure;
use Cartalyst\Sentinel\Sentinel;

class Authenticate
{
    /**
     * The Sentinel instance.
     *
     * @var \Cartalyst\Sentinel\Sentinel
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  \Cartalyst\Sentinel\Sentinel  $auth
     * @return void
     */
    public function __construct(Sentinel $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                app('alerts')->error(trans('message.not_logged_in'));

                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
