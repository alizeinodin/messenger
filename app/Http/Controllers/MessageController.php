<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getMessages(Request $request)
    {
        $cleanData = $request->validated();

        $messages = Message::where([
            'sender_id' => $request->user(),
            'receiver_id' => $cleanData['user_id'],
        ])->all();

        $response = [
            'messages' => $messages,
        ];

        return response($response, ResponseAlias::HTTP_OK);
    }
}
