<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/29/2015
 * Time: 7:10 AM
 */
namespace App\Drivers;
use App;
use League\OAuth2\Client\Entity\User;
use League\OAuth2\Client\Provider\AbstractProvider;

class VionoxAuth extends AbstractProvider {

    const CURL_OPTIONS = 'curl.options';

    public function __construct($options = [])
    {
        parent::__construct($options);
        $this->getHttpClient()->setSslVerification(App::basePath() . '/cacert.pem');
    }

    // Default scopes
    public $scopes = ['scope1', 'scope2'];

    // Response type
    public $responseType = 'json';

    public function urlAuthorize()
    {
        return 'https://account.vionox.com/authorize';
    }

    public function urlAccessToken()
    {
        return 'http://account.vionox.com/api/1.0/auth/access_token';
    }

    public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
    {
        return 'https://account.vionox.com/api/1.0/auth/user.json?access_token='.$token;
    }

    public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        $user = new User;
        // Take the decoded data (determined by $this->responseType)
        // and fill out the user object by abstracting out the API
        // properties (this keeps our user object simple and adds
        // a layer of protection in-case the API response changes)

        $user->firstName = $response->user->firstname;
        $user->lastName  = $response->user->lastname;
        //$user->name = $response->user->firstname . " " . $response->user->lastname;
        $user->email      = $response->emails->primary;
        // Etc..

        return $user;
    }

    public function userUid($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        return $response->unique_id;
    }

    public function userEmail($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        // Optional, however OAuth2 usually provides a scope
        // to receive access to a user's email, you should always
        // ask for this scope, as having an email is awesome.
        if (isset($response->emails->primary))
        {
            return $response->emails->primary;
        }
    }

    public function userScreenName($response, \League\OAuth2\Client\Token\AccessToken $token)
    {
        // Optional
        if (isset($response->screen_name))
        {
            return $response->screen_name;
        }
    }
}