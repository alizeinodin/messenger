<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest\GetMessageRequest;
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
     * @param GetMessageRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function getLatestMessages(GetMessageRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $messagesOne = Message::where([
            'sender_id' => $request->user()->id,
            'receiver_id' => $cleanData['receiver_id'],
        ])
            ->paginate(250);


        $messagesTwo = Message::where([
            'sender_id' => $cleanData['receiver_id'],
            'receiver_id' => $request->user()->id,
        ])
            ->paginate(250);


        $messages = $messagesTwo
            ->merge($messagesOne)
            ->sortBy('id');

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
