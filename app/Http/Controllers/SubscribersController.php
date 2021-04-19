<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Models\Subscribers;
use App\Models\Topics;

class SubscribersController extends Controller
{
    public function createSubscription(Request $request, $topic_id) {
        if(Topics::where('id', $topic_id)->exists()) {
            $validator = Validator::make($request->all(),[
                'url' => 'required|string|between:2,10000'
            ]);

            if($validator->fails()) {
                return response()->json(['status' => 'failed', 'message' => $validator->errors()], 400);
            }

            if(Subscribers::where('topic_id', $topic_id)->where('url', $request->url)->exists()) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'This URL is already subscribed to this topic'
                ], 409);
            }

            $subscribers = Subscribers::create([
                'topic_id' => $topic_id,
                'url' => $request->url,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Subscribed!'
            ], 200);
        }

        return response()->json([
            'status' => 'failed',
            'message' => 'Topic does not exist'
        ], 404);
        
    }
}
