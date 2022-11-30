<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class MessageController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
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

    /**
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function sendMessage(Request $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $message = Message::create([
            'content' => $cleanData['content'],
            'sender_id' => $request->user()->id,
            'receiver_id' => $cleanData['receiver_id'],
        ]);

        $response = [
            'isOk' => 'true',
            'message' => $message
        ];

        return response($response, ResponseAlias::HTTP_CREATED);
    }
}
