<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ConsumeLogJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

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

            $callback = function ($message) {
                Log::debug("Received message: {$message->getBody()}");
                echo "Received message: ", $message->getBody(), "\n";
                $message->ack();

            };

            $limit = 2;
            $count = 0;

            $channel->queue_declare(env('RABBITMQ_QUEUE'), false, true, false, false);

            $channel->basic_consume(env('RABBITMQ_QUEUE'), '', false, false, false, false, $callback);

            while ($count < $limit) {
                $channel->wait();
                $count++;
            }

        } catch (\Exception $exception) {
            Log::error("Failed to consume messages: {$exception->getMessage()}");
        } finally {
            $channel->close();
            $connection->close();
        }

    }
}
