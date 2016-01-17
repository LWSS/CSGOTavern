<?php

/**
 * Part of the Platform Media extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Platform Media extension
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Media\Styles\Style;
use Platform\Media\Styles\Manager;

return [

    /*
    |--------------------------------------------------------------------------
    | Time to live
    |--------------------------------------------------------------------------
    |
    | Define here the time to live, in seconds, before the browser
    | sends another request to re-cache the media.
    |
    */

    'ttl' => 2592000,

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | Define here the required Style config sets that will
    | be executed whenever a file gets uploaded.
    |
    */

    'styles' => function (Manager $manager) {
        $manager->setStyle('thumbnail', function (Style $style) {
            // Set the style image width.
            $style->width = 300;

            // Set the style macros
            $style->macros = [ 'resize' ];

            // Set the storage path
            $style->path = public_path('cache/media');
        });
    },

    /*
    |--------------------------------------------------------------------------
    | Macros
    |--------------------------------------------------------------------------
    |
    | Define here the Macros that can be used with the Style config sets.
    |
    */

    'macros' => function (Manager $manager) {
        $manager->setMacro('resize', 'Platform\Media\Styles\Macros\ResizeMacro');
    }

];
