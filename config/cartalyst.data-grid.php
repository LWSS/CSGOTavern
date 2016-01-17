<?php
/**
 * Part of the Data Grid package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Data Grid
 * @version    3.0.4
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2015, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;

return array(

    /*
    |--------------------------------------------------------------------------
    | Default Method
    |--------------------------------------------------------------------------
    |
    | Define the default method, this will define the data grid behavior.
    |
    | Supported: "single", "group", "infinite"
    |
    */

    'method' => 'single',

    /*
    |--------------------------------------------------------------------------
    | Threshold
    |--------------------------------------------------------------------------
    |
    | Define the default threshold (number of results before pagination begins).
    |
    */

    'threshold' => 100,

    /*
    |--------------------------------------------------------------------------
    | Throttle
    |--------------------------------------------------------------------------
    |
    | Define the default throttle, which is the maximum results set.
    |
    */

    'throttle' => 100,

    /*
    |--------------------------------------------------------------------------
    | Data Handler Mappings
    |--------------------------------------------------------------------------
    |
    | Here you may specify any "data handlers" which handle the dataset given
    | to a data grid instance. The key is the class which handles the data
    | and the value is a closure which must return true. There may be multiple
    | classes which can handle the same data type but only one for that
    | specific data set.
    |
    | Supported: Any class that implements:
    |            Cartalyst\DataGrid\DataHandlers\HandlerInterface
    |
    */

    'handlers' => array(

        'Cartalyst\DataGrid\DataHandlers\CollectionHandler' => function ($data) {
            return (
                $data instanceof Collection || is_array($data)
            );
        },

        'Cartalyst\DataGrid\DataHandlers\DatabaseHandler' => function ($data) {
            return (
                $data instanceof BelongsToMany ||
                $data instanceof EloquentModel ||
                $data instanceof EloquentQueryBuilder ||
                $data instanceof HasMany ||
                $data instanceof QueryBuilder
            );
        },

    ),

);
