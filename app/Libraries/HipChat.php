<?php
/**
 * Part of the CSGO-Tavern application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 11 2015
 */


namespace App\Libraries;


use Config;
use HipChat\HipChat as BaseClass;

class HipChat extends BaseClass
{
    public function __construct($token = null)
    {
        parent::__construct($token);
    }

    /**
     * Send a message to a room
     *
     * @see http://api.hipchat.com/docs/api/method/rooms/message
     */
    public function message($message, $notify = false,
                                 $color = self::COLOR_YELLOW,
                                 $message_format = self::FORMAT_HTML) {
        return parent::message_room(
            Config::get('services.hipchat.room.id'),
            Config::get('services.hipchat.name'),
            $message, $notify, $color, $message_format);
    }

}