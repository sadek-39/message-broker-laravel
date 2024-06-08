<?php

namespace App\Http\Controllers;

use App\Jobs\LogJob;

class LogController extends Controller
{
    public function sendLog()
    {
        $message = "Hello I am the log for rabbit mq";
        LogJob::dispatch($message);

        return response()->json(['status'=>'Job dispatched']);
    }
}
