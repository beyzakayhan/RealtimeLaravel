<?php

namespace App\Http\Controllers;

use App\Events\GreetingSent;
use App\Events\MessageSent;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showChat()
    {
        return view('chat.show');
    }

    public function messageReceived(Request $request)
    {
        $rules = [
            'message' => 'required',
        ];

        $request->validate($rules);
        broadcast(new MessageSent($request->message));

        return response()->json('Message broadcast');
    }

    public function greetReceived(Request $request, $user)
    {
        $data = new Message();
        $data->from = $request->from;
        $data->to = $user;
        $data->message = $request->message;
        $data->save();

        // broadcast(new GreetingSent($user, '12345'));
        Log::debug($request);
        //  broadcast(new GreetingSent($user, '12345'));
        broadcast(new GreetingSent($user, $request->message));
        broadcast(new GreetingSent($request->from, $request->message));

        // return "Greeting {$user->name} from {$request->user()->name}";
    }
}
