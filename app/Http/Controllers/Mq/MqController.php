<?php

namespace App\Http\Controllers\Mq;


use App\Http\Controllers\Controller;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class MqController extends Controller
{

    public $config = [
        'host' => '129.28.153.237',
        'port' => '5672',
        'user' => 'admin',
        'password' => 'admin',
        'vhost' => '/'
    ];

    public function index()
    {


        $config = $this->config;


        $connect = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);

        $exchange = 'ce';

        $queue = 'ce';

        $channel = $connect->channel();

        $message = $channel->basic_get($queue);

        $msg = $message->body;

        $channel->basic_ack($message->delivery_info['delivery_tag']);

        $channel->close();

        $connect->close();

        print_r($msg);

    }

    public function send()
    {

        for ($i = 0; $i < 10; $i++) {


            $config = $this->config;


            $connect = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);

            $exchange = 'ce';

            $queue = 'ce';

            $channel = $connect->channel();

            $channel->queue_declare($queue, false, true, false, false);

            $channel->exchange_declare($exchange, 'headers', false, true, false);

            $channel->queue_bind($queue, $exchange);

            $messageBody = 'ceshi'.$i;

            $message = new AMQPMessage($messageBody, ['content-type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);

            $channel->basic_publish($message, $exchange);

            $channel->close();

            $connect->close();
        }
    }

}