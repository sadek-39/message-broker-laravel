<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class LogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $msg;

    /**
     * Create a new job instance.
     */
    public function __construct(string $msg)
    {
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     */
    public function handle(AMQPStreamConnection $connection): void
    {
        $channel = $connection->channel();
        $channel->queue_declare(env('RABBITMQ_QUEUE'), false, true, false, false);
        $msg = new AMQPMessage($this->msg, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($msg, '', env('RABBITMQ_QUEUE'));
        $channel->close();
        $connection->close();
    }
}
