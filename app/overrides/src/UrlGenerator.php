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

namespace Cartalyst\Platform;

use Platform\Access\Traits\UrlGeneratorTrait as AccessUrlGeneratorTrait;

class UrlGenerator extends \Illuminate\Routing\UrlGenerator
{
    use AccessUrlGeneratorTrait;

    /**
     * Get the URL for the previous request.
     *
     * @param  string  $fallback
     * @return string
     */
    public function previous($fallback = null)
    {
        $referer = $this->request->headers->get('referer', $fallback);

        $url = $referer ? $this->to($referer) : $this->getPreviousUrlFromSession();

        return $url ?: $this->to('/');
    }
}
