<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

Class RabbitHelper {

    public static function send( $job = "hello", $jsonData = "hello world" ) {

        $connection = new AMQPConnection('192.168.1.27', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->exchange_declare($job, 'fanout', false, false, false);

        $msg = new AMQPMessage($jsonData);
        $channel->basic_publish($msg, $job);

        $channel->close();
        $connection->close();
    }

    public static function receive( $job = "hello", $callback = NULL ) {

        $connection = new AMQPConnection('192.168.1.27', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->exchange_declare($job, 'fanout', false, false, false);
        list($queue_name,, ) = $channel->queue_declare("", false, false, true, false);
        $channel->queue_bind($queue_name, $job);

        echo ' [*] Waiting for logs. To exit press CTRL+C', "\n";

        if( !$callback ) {
            $callback = function($msg) {
                echo ' [x] ', $msg->body, "\n";
            };
        }

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while( count($channel->callbacks) ) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }

}