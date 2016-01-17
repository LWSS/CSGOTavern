<?php namespace App\Libraries\Stripe;

/**
 * Part of the CSGO-Trading-Site application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 10 2015
 */
class Stripe extends \Cartalyst\Stripe\Stripe
{

    /**
     * Constructor.
     *
     * @param  string $apiKey
     * @param  string $apiVersion
     */
    public function __construct( $apiKey = null, $apiVersion = null )
    {
        parent::__construct( $apiKey, $apiVersion );
    }

    /**
     * Dynamically handle missing methods.
     *
     * @param  string $method
     * @param  array $parameters
     * @return \Cartalyst\Stripe\Api\ApiInterface
     */
    public function __call( $method, array $parameters = [ ] )
    {
        parent::__call( $method, $parameters );
    }

    /**
     * @param $cardBrand
     * @return string
     */
    public function getCardSlug( $cardBrand )
    {
        switch ( $cardBrand ) {
            case 'American Express':
                return 'amex';
            case 'Diners Club':
                return 'diners-club';
            default:
                return strtolower( $cardBrand );
        }
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Account
     */
    public function account( array $parameters = [ ] )
    {
        return parent::__call( 'account', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Api
     */
    public function api( array $parameters = [ ] )
    {
        return parent::__call( 'api', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\ApplicationFeeRefunds
     */
    public function applicationFeeRefunds( array $parameters = [ ] )
    {
        return parent::__call( 'applicationFeeRefunds', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\ApplicationFees
     */
    public function applicationFees( array $parameters = [ ] )
    {
        return parent::__call( 'applicationFees', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Balance
     */
    public function balance( array $parameters = [ ] )
    {
        return parent::__call( 'balance', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Cards
     */
    public function cards( array $parameters = [ ] )
    {
        return parent::__call( 'cards', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Charges
     */
    public function charges( array $parameters = [ ] )
    {
        return parent::__call( 'charges', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Coupons
     */
    public function coupons( array $parameters = [ ] )
    {
        return parent::__call( 'coupons', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Customers
     */
    public function customers( array $parameters = [ ] )
    {
        return parent::__call( 'customers', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Events
     */
    public function events( array $parameters = [ ] )
    {
        return parent::__call( 'events', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\ExternalAccounts
     */
    public function externalAccounts( array $parameters = [ ] )
    {
        return parent::__call( 'externalAccounts', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\FileUploads
     */
    public function fileUploads( array $parameters = [ ] )
    {
        return parent::__call( 'fileUploads', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\InvoiceItems
     */
    public function invoiceItems( array $parameters = [ ] )
    {
        return parent::__call( 'invoiceItems', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Invoices
     */
    public function invoices( array $parameters = [ ] )
    {
        return parent::__call( 'invoices', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Orders
     */
    public function orders( array $parameters = [ ] )
    {
        return parent::__call( 'orders', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Plans
     */
    public function plans( array $parameters = [ ] )
    {
        return parent::__call( 'plans', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Products
     */
    public function products( array $parameters = [ ] )
    {
        return parent::__call( 'products', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Recipients
     */
    public function recipients( array $parameters = [ ] )
    {
        return parent::__call( 'recipients', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Refunds
     */
    public function refunds( array $parameters = [ ] )
    {
        return parent::__call( 'refunds', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Skus
     */
    public function skus( array $parameters = [ ] )
    {
        return parent::__call( 'skus', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Subscriptions
     */
    public function subscriptions( array $parameters = [ ] )
    {
        return parent::__call( 'subscriptions', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Tokens
     */
    public function tokens( array $parameters = [ ] )
    {
        return parent::__call( 'tokens', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\TransferReversals
     */
    public function transferReversals( array $parameters = [ ] )
    {
        return parent::__call( 'transferReversals', $parameters );
    }

    /**
     * @param array $parameters
     * @return \Cartalyst\Stripe\Api\Transfers
     */
    public function transfers( array $parameters = [ ] )
    {
        return parent::__call( 'transfers', $parameters );
    }
}