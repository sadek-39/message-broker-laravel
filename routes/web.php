<?php

use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;
use App\Proto\WelcomeMessage;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-log', [LogController::class, 'sendLog']);
Route::get('/send-pub-sub', [LogController::class, 'sendPub']);

Route::get('/check-redis', function () {
    try {
        $msg = new WelcomeMessage();

        $taskId = \Illuminate\Support\Str::uuid();

        $msg->setType("Welcome");
        $msg->setPayload('{"user_id":1}');
        $msg->setUuid($taskId);
        $msg->setQueue('critical');

        // Define the fields for the task
        $taskDetails = [
            'pending_since' => now()->timestamp,
            'msg' => serialize($msg),
            'state' => 'pending',
        ];
        // Connect to Redis
        $redis = Redis::connection();

        // Set the task details in a Redis hash
        $redis->hmset("asynq:{critical}:t:{$taskId}", $taskDetails);

        // Push the task ID onto the pending list for the queue
        $redis->rpush("asynq:{critical}:pending", $taskId);

        return response()->json(['status' => 'Task enqueued successfully']);
    } catch (Exception $e) {
        return response()->json(['status' => 'Failed to enqueue task', 'error' => $e->getMessage()], 500);
    }
//        $field = [
//            'pending_since' => now()->timestamp,
//            'msg' => 'Welcome {"user_id":1} $task1" critical( @? ',
//            'state' => "pending"
//        ];
//
//        $redis = Redis::connection();
//        $redis->hmset('asynq:{critical}:t:task1', $field);
//        $pendingKey = $redis->keys('asynq.{critical}.pending');
//
//        $redis->rpush('asynq:{critical}:pending', 'task1');
//
//
//        return 'Redis connection is working: ' . $redis->get('name');
//    } catch (Exception $e) {
//        return 'Redis connection failed: ' . $e->getMessage();
//    }
});

