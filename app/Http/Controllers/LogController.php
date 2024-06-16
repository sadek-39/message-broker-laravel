<?php

namespace App\Http\Controllers;

use App\Jobs\LogJob;
use App\Jobs\LogPubSubJob;

class LogController extends Controller
{
    public function sendLog()
    {
        $message = "Hello I am the log for rabbit mq";
        for ($i = 0; $i < 20; $i++) {
            LogJob::dispatch($message);
        }
        return response()->json(['status'=>'Job dispatched']);
    }

    public function sendPub()
    {
        $message = "Hello I am the log for rabbit mq pub sub model";
        for ($i = 0; $i < 20; $i++) {
            LogPubSubJob::dispatch($message);
        }
        return response()->json(['status'=>'Job dispatched']);
    }
}
