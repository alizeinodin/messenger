<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest\SearchRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    /**
     * get user of request
     *
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function user(Request $request): Response|Application|ResponseFactory
    {
        $response = [
            'user' => $request->user(),
            'isOk' => 'true',
        ];

        return response($response, ResponseAlias::HTTP_OK);
    }

    /**
     * search user by username
     *
     * @param SearchRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function search(SearchRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $users = User::where([
            'username' => '%' . $cleanData['username'] . '%',
        ])->get();

        $response = [
            'result' => $users,
            'isOk' => 'true',
        ];

        return response($response, ResponseAlias::HTTP_OK);
    }
}
