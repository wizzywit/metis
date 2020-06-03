<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use \Pusher\Pusher;

class PusherController extends Controller
{
    //

    public function authenticate(Request $request) {
        $socketId = $request->socket_id;
        $channelName = $request->channel_name;

        $pusher = new Pusher('52b6df945610aa082478', 'ae75f5c3fd040b211bd8', '1011578', [
            'cluster' => 'ap2',
            'encrypted' => true
        ]);

        if(Auth::guard('doctor')->check()) {
            $name = Auth::guard('doctor')->user()->name;
            $id = Auth::guard('doctor')->id();
        }
        else if(Auth::guard('web')->check()) {
            $name = Auth::guard('web')->user()->name;
            $id = Auth::guard('web')->id();
        }

        $presense_data = ['name' => $name];
        $key = $pusher->presence_auth($channelName, $socketId, $id, $presense_data );
        return response($key);
    }
}
