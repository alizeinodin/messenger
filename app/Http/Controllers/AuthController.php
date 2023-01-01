<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return Response|Application|ResponseFactory
     */
    public function register(RegisterRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $user = User::create([
            'name' => $cleanData['name'],
            'username' => $cleanData['username'],
            'password' => Hash::make($cleanData['password']),
        ]);

        $res = [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];

        return response($res, ResponseHTTP::HTTP_CREATED);
    }

    /**
     * @param LoginRequest $request
     * @return Response|Application|ResponseFactory
     * @throws ValidationException
     */
    public function login(LoginRequest $request): Response|Application|ResponseFactory
    {
        $cleanData = $request->validated();

        $user = User::where([
            'username' => $cleanData['username']
        ])->first();

        if (Auth::attempt(['username' => $cleanData['username'], 'password' => $cleanData['password']])) {

            $response = [
                'user' => $user,
                'access_token' => $user->createToken('auth_token')->plainTextToken,
                'token_type' => 'Bearer',
            ];

            return response($response, ResponseHTTP::HTTP_OK);
        }

        throw ValidationException::withMessages([
            'username' => ['The provided credentials are incorrect.']
        ]);

    }

    /**
     * @param Request $request
     * @return Response|Application|ResponseFactory
     */
    public function logout(Request $request): Response|Application|ResponseFactory
    {
        $request->user()->tokens()->delete(); // logout from all devices

        $response = [
            'message' => 'You have successfully logged out!',
        ];
        return \response($response, ResponseHTTP::HTTP_NO_CONTENT);
    }
}
