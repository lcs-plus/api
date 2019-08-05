<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class GetMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getMessage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this is mq of consumer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $config = [
            'host' => '129.28.153.237',
            'port' => '5672',
            'user' => 'admin',
            'password' => 'admin',
            'vhost' => '/'
        ];


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
}
