<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $response = [
            'user' => $request->user(),
            'isOk' => 'true',
        ];

        return response($response, ResponseAlias::HTTP_OK);
    }

    public function search(Request $request)
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
