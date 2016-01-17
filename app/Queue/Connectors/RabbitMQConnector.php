<?php namespace App\Queue\Connectors;
/**
 * Part of the CSGO-Trading-Site application.
 *
 * NOTICE OF LICENSE
 *
 * Copyright (C) VIONOX, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Brandon Xversial <xversial@vionox.com>, 09 2015
 */

use App\Queue\RabbitMQQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;
use PhpAmqpLib\Connection\AMQPConnection;

class RabbitMQConnector implements ConnectorInterface
{

    /**
     * Establish a queue connection.
     *
     * @param  array $config
     *
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        // create connection with AMQP
        $connection = new AMQPConnection($config['host'], $config['port'], $config['login'], $config['password'], $config['vhost']);

        return new RabbitMQQueue(
            $connection,
            $config
        );
    }

}