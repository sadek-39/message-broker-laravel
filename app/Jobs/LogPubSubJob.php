<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class LogPubSubJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    /**
     * Create a new job instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(AMQPStreamConnection $connection): void
    {
        $channel = $connection->channel();
        $channel->exchange_declare('logs', 'fanout', false, false, false);

        $msg = new AMQPMessage($this->message);
        $channel->basic_publish($msg, 'logs');
        echo ' [x] Sent ', $this->message, "\n";

        $channel->close();
        $connection->close();
    }
}
