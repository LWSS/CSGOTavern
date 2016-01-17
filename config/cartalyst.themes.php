<?php
/**
 * Part of the Themes package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Themes
 * @version    2.2.4
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Active Theme
    |--------------------------------------------------------------------------
    |
    | Here you can specify the default active theme for your application,
    | or set to null if none is defined.
    |
    */

    'active' => 'frontend::default',

    /*
    |--------------------------------------------------------------------------
    | Fallback Theme
    |--------------------------------------------------------------------------
    |
    | Here you can specify the default fallback theme for your application,
    | or set to null if none is defined.
    |
    */

    'fallback' => null,

    /*
    |--------------------------------------------------------------------------
    | Theme Paths
    |--------------------------------------------------------------------------
    |
    | Here you set the default theme paths for your application. Paths should
    | also be set relative to a publicly accessible directory so assets
    | can be resolved.
    |
    */

    'paths' => array(
        public_path().'/themes',
    ),

    /*
    |--------------------------------------------------------------------------
    | Packages Path
    |--------------------------------------------------------------------------
    |
    | Here, you set the path (relative to your theme's root folder) for all
    | packages to reside.
    |
    */

    'packages_path' => 'extensions',

    /*
    |--------------------------------------------------------------------------
    | Namespaces Path
    |--------------------------------------------------------------------------
    |
    | We even let you theme up Laravel 5 view namespaces. You can register a
    | namespace for a view, for example:
    |
    |	View::addNamespace('foo/bar', '/var/www/some/namespace');
    |
    | This means that, when you call:
    |
    |	View::make('foo/bar::test');
    |
    | It will look in the namespace you specified. However, you can also call
    | Theme::namespace('foo/bar'); which means that all calls to the 'foo/bar'
    | namespace will first check for that namespace within your theme first,
    | before falling back to the hard-coded namespace. Yes, you can theme any
    | view in Laravel now!
    |
    */

    'namespaces_path' => 'namespaces',

    /*
    |--------------------------------------------------------------------------
    | Views Path
    |--------------------------------------------------------------------------
    |
    | List the path (within each theme and it's packages) where views are
    | located.
    |
    */

    'views_path' => 'views',

    /*
    |--------------------------------------------------------------------------
    | Assets Path
    |--------------------------------------------------------------------------
    |
    | List the path (within each theme and it's packages) where assets are
    | located.
    |
    */

    'assets_path' => 'assets',

    /*
    |--------------------------------------------------------------------------
    | Assets Cache Path
    |--------------------------------------------------------------------------
    |
    | The path (relative to your public path) where assets are cached upon
    | compilation.
    |
    */

    'cache_path' => 'cache/assets',

    /*
    |--------------------------------------------------------------------------
    | Asset Default Filters
    |--------------------------------------------------------------------------
    |
    | List the filters used when compiling assets. Filters may be a string
    | representation of the class or a closure which returns a new instance
    | of a filter.
    |
    | Filters are provided through Assetic, which does not supply all the
    | libraries required to make the filters work. Some libraries must be
    | installed to your local machine. For example, the CoffeScriptFilter
    | requires that the `coffee` command-line app is installed on your
    | machine.
    |
    */

    'filters' => [

        'css' => [

            'Assetic\Filter\CssImportFilter',
            'Cartalyst\AsseticFilters\UriRewriteFilter',

        ],

        'less' => [

            'Cartalyst\AsseticFilters\LessphpFilter',
            'Cartalyst\AsseticFilters\UriRewriteFilter',

        ],

        'sass' => [

            'Cartalyst\AsseticFilters\SassphpFilter',
            'Cartalyst\AsseticFilters\UriRewriteFilter',

        ],

        'scss' => [

            'Assetic\Filter\ScssphpFilter',
            'Cartalyst\AsseticFilters\UriRewriteFilter',

        ],

        'js' => [

            'Assetic\Filter\JSMinFilter',

        ],

        'coffee' => [

            'Cartalyst\AsseticFilters\CoffeeScriptphpFilter',
            'Assetic\Filter\JSMinFilter',

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Debug Mode
    |--------------------------------------------------------------------------
    |
    | You can specify if you want to force the package to run in debug mode.
    | Debug mode will change the way assets are compiled.
    |
    | By default, we guess whether you are in a production environment or not,
    | and if you're not in production we will assume you're in debug mode.
    | You can explicitly set this however below.
    |
    | Supported: null, true, false (where null is "automatic detection").
    |
    */

    'debug' => null,

    /*
    |--------------------------------------------------------------------------
    | Force Recompile
    |--------------------------------------------------------------------------
    |
    | If you want your assets to be recompiled on every page load, set
    | this option to true.
    |
    */

    'force_recompile' => false,

    /*
    |--------------------------------------------------------------------------
    | Auto Clear assets
    |--------------------------------------------------------------------------
    |
    | If you want to completely remove all the compiled assets on
    | every page load, set this option to true.
    |
    */

    'auto_clear' => false,

];
