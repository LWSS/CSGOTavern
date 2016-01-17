<?php namespace App\Http\Controllers\Auth;

/**
 * Part of the Fallian-Website application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 10 2015
 */
use Input;
use Platform\Users\Controllers\Frontend\OAuthController as BaseController;
use Session;

class OAuthController extends BaseController
{

    /**
     * Shows a link to authenticate a service.
     *
     * @param  string $slug
     * @return \Illuminate\Http\RedirectResponse
     * @internal param Request $request
     */
    public function authorize( $slug )
    {
        try {
            if ( Input::get( 'redirect' ) ) {
                Session::set( 'return.url', Input::get( 'redirect' ) );
            }
        } catch ( \Exception $e ) {
            return $this->handleError( $e );
        }
        try {
            return redirect(
                $this->social->getAuthorizationUrl( $slug, url()->route( 'user.oauth.callback', $slug ) )
            );
        } catch ( \Exception $e ) {
            return $this->handleError( $e );
        }
    }

    /**
     * Handles authentication
     *
     * @param  string $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback( $slug )
    {
        try {
            $this->social->authenticate( $slug, url()->current(), function ( $link, $provider, $token, $slug ) {
                // Callback after user is linked
            } );

            $this->alerts->success( trans( 'platform/users::auth/message.success.login' ) );
            $response = null;
            if ( Session::get( 'return.url' ) ) {
                $response = redirect( Session::get( 'return.url' ) );
                Session::forget( 'return.url' );
            } else {
                $response = redirect( '/' );
            }
            return $response;
        } catch ( \Exception $e ) {
            return $this->handleError( $e );
        }
    }
}
