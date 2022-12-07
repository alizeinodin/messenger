<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')
        ->name('register');
    Route::post('/login', 'login')
        ->name('login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {


    Route::controller(MessageController::class)->group(function () {
        Route::post('/send_message', 'sendMessage')
            ->name('sendMessage');
        Route::get('/get_message', 'getLatestMessages')
            ->name('getMessage');
    });

    Route::name('user.')->group(function () {

        Route::prefix('/user')->group(function () {

            Route::controller(UserController::class)->group(function () {
                Route::get('/get', 'user')
                    ->name('get');

                Route::post('/search', 'search')
                    ->name('search');
            });
        });
    });

});
