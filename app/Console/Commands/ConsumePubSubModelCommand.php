<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumePubSubModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume-pub-sub-model-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $connection = new AMQPStreamConnection(
                env('RABBITMQ_HOST'),
                env('RABBITMQ_PORT'),
                env('RABBITMQ_USER'),
                env('RABBITMQ_PASSWORD')
            );

            $channel = $connection->channel();
            $channel->exchange_declare('logs', 'fanout', false, false, false);
            list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

            $channel->queue_bind($queue_name, 'logs');
            echo " [*] Waiting for logs. To exit press CTRL+C\n";
            $callback = function ($msg) {
                Log::debug("Received message: {$msg->getBody()}");
                echo ' [x] ', $msg->getBody(), "\n";
            };

            $channel->basic_consume($queue_name, '', false, true, false, false, $callback);
            $channel->consume();
        }catch (\Exception $exception) {
            Log::error("Failed to consume messages: {$exception->getMessage()}");

        } finally {
            $channel->close();
            $connection->close();
        }

    }
}
