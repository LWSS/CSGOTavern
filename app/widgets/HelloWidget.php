<?php

/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform
 * @version    4.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace App\Widgets;

class HelloWidget
{
    /**
     * Show a welcome message.
     *
     * @param  string  $name
     * @return string
     */
    public function show($name = null)
    {
        $name = $name ?: 'stranger';

        return "Hello {$name}!";
    }
}
