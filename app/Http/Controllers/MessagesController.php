<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Messages;
use App\Models\Subscribers;
use App\Models\Topics;

use Illuminate\Support\Facades\Http;


class MessagesController extends Controller
{
    public function publishMessage(Request $request, $topic_id) {
        if(Topics::where('id', $topic_id)->exists()) {
            $validator = Validator::make($request->all(),[
                'message' => 'required|string|between:2,10000'
            ]);

            if($validator->fails()) {
                return response()->json(['status' => 'failed', 'message' => $validator->errors()], 400);
            }

            $message = Messages::create([
                'topic_id' => $topic_id,
                'message' => $request->message,
            ]);

            //check the subscribers table
            $all_subscribers = Subscribers::where('topic_id', $topic_id)->with('topic')->get();
            $count = $all_subscribers->count();


            $data = array();

            if($count > 0) {
                foreach ($all_subscribers as $subscriber) {
                    $send_http = Http::post($subscriber->url, [
                        'topic' => $subscriber->topic->title,
                        'message' => $request->message,
                    ]);
                    //$data[] = "sending message to " .$subscriber->topic->title;
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $send_http
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Topic does not exist'
        ], 404);
        
    }
}
