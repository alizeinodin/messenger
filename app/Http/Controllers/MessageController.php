<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest\SendMessageRequest;
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
     * @param SendMessageRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function sendMessage(SendMessageRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $message = new Message();
        $message->content = $cleanData['content'];
        $message->receiver_id = $cleanData['receiver_id'];
        $message->sender()->associate($request->user());
        $message->save();

        $response = [
            'isOk' => 'true',
            'message' => $message
        ];

        return response($response, ResponseAlias::HTTP_CREATED);
    }
}
